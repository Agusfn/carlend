<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use App\MovimientoAlquiler;
use Carbon\Carbon;

class Alquiler extends Model
{

    use Filterable;

    const ESTADO_EN_CURSO = "en_curso";
    const ESTADO_FINALIZADO = "finalizado";


    /**
     * Días luego del fin del alquiler en donde se pueden seguir registrando movimientos.
     */
    const DIAS_PARA_REGISTRAR_MOVIMIENTOS = 7;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alquileres';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_inicio',
        'fecha_fin'
    ];


    /**
     * Obtener la sumatoria de saldo faltante en los alquileres con saldo negativo (el numero devuelto es positivo)
     * @return float
     */
    public static function sumaPendienteDePago()
    {
        return -1 * self::enCurso()->where("saldo_actual", "<", 0)->sum("saldo_actual");
    }


    /**
     * Obtener chofer de este alquiler (incluyendo choferes eliminados)
     * @return App\Chofer|null
     */
    public function chofer()
    {
        return $this->belongsTo("App\Chofer", "id_chofer")->withTrashed();
    }




    /**
     * Obtener vehiculo de este alquiler. (incluir elementos eliminados)
     * @return App\Vehiculo|null
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo")->withTrashed();
    }    



    /**
     * Obtener los movimientos de saldo de este alquiler
     * @return [type] [description]
     */
    public function movimientosSaldo()
    {
        return $this->hasMany("App\MovimientoAlquiler", "id_alquiler");
    }


    /**
     * Ordenamiento de más reciente a más antiguo
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaDesc($query)
    {
        return $query->orderBy("fecha_inicio", "DESC")->orderBy("id", "DESC");
    }


    /**
     * Filtrar alquileres que hayan tenido al menos un día de alquiler dentro del rango de las fechas dadas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string $fechaInicio Y-m-d
     * @param  string $fechaFin Y-m-d
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->where(function($query) use ($fechaInicio, $fechaFin) {
                $query->where("fecha_inicio", ">=", $fechaInicio)
                    ->where("fecha_fin", "<=", $fechaFin);
            })
            ->orWhere(function($query) use ($fechaInicio, $fechaFin) {
                $query->where("fecha_inicio", "<", $fechaInicio)
                    ->where("fecha_fin", ">", $fechaInicio); 
            })
            ->orWhere(function($query) use ($fechaInicio, $fechaFin) {
                $query->where("fecha_inicio", "<", $fechaFin)
                    ->where("fecha_fin", ">", $fechaFin);
            })
            ->orWhere(function($query) use ($fechaInicio, $fechaFin) {
                $query->where("fecha_inicio", "<", $fechaFin)
                    ->where("fecha_fin", null);
            });
    }




    /**
     * Filtramos por alquileres finalizados.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinalizados($query)
    {
        return $query->where("estado", self::ESTADO_FINALIZADO);
    }



    /**
     * Filtramos por alquileres en curso.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnCurso($query)
    {
        return $query->where("estado", self::ESTADO_EN_CURSO);
    }



    /**
     * Si el alquiler está en curso.
     * @return bool
     */
    public function estaEnCurso()
    {
        return $this->estado == self::ESTADO_EN_CURSO;
    }


    /**
     * Si el alquiler está finalizado.
     * @return bool
     */
    public function estaFinalizado()
    {
        return $this->estado == self::ESTADO_FINALIZADO;
    }


    /**
     * Si puede registrar movimientos. Debe estar activo el alquiler o haber terminado hace 7 días o menos.
     * @return bool
     */
    public function puedeRegistrarMovimientos()
    {
        if($this->estaEnCurso() || 
            $this->fecha_fin->copy()->addDays(self::DIAS_PARA_REGISTRAR_MOVIMIENTOS)->isFuture()) 
        {
            return true;
        }
        else {
            return false;
        }
    }


    /**
     * Agregar nuevo movimiento retroactivo (o no) a este alquiler.
     * @param Carbon $fecha
     * @param  string $tipo       
     * @param  float $monto      
     * @param  string $medioPago  
     * @param  string $comentario 
     * @return null             
     */
    public function agregarMovimientoRetroactivo($fecha, $tipoMovimiento, $monto, $medioPago, $comentario)
    {
        if($fecha->isFuture() || $fecha->copy()->addDays(7)->isPast()) {
            throw new \Exception("La fecha del movimiento retroactivo debe ser hasta 7 días antes y no puede ser futura.");
        }
        
        MovimientoAlquiler::create([
            "fecha_hora" => $fecha,
            "id_alquiler" => $this->id,
            "tipo" => $tipoMovimiento,
            "monto" => $monto,
            "nuevo_saldo" => 0,
            "medio_pago" => $medioPago,
            "comentario" => $comentario
        ]);

        $nuevoSaldo = $this->recalcularSaldosDeMovimientos();

        $this->saldo_actual = $nuevoSaldo;
        $this->save();
    }


    /**
     * Agregar nuevo cobro a este alquiler
     * @param  float $monto monto a cobrar (debe ser un valor positivo)   
     * @return null             
     */
    public function debitarCobroDeAlquiler($monto)
    {
        
        $nuevoSaldo = $this->calcularSaldoActual() - $monto;

        MovimientoAlquiler::create([
            "fecha_hora" => Carbon::now(),
            "id_alquiler" => $this->id,
            "tipo" => MovimientoAlquiler::TIPO_COBRO_ALQUILER,
            "monto" => (-1)*$monto,
            "nuevo_saldo" => $nuevoSaldo
        ]);

        $this->saldo_actual = $nuevoSaldo;
        $this->save();
    }


    /**
     * Recalcular el valor de 'saldo_actual' de cada movimiento debido a haber agregado un movimiento retroactivo
     * @return float
     */
    private function recalcularSaldosDeMovimientos()
    {
        $movimientos = $this->movimientosSaldo()->fechaAsc()->get();

        $saldoAcumulado = 0;
        foreach($movimientos as $movimiento)
        {
            $saldoAcumulado += $movimiento->monto;

            $movimiento->nuevo_saldo = $saldoAcumulado;
            $movimiento->save();
        }

        return $saldoAcumulado;
    }



    /**
     * Sumar los montos de todos los movimientos de saldo de este alquiler.
     * @return float
     */
    private function calcularSaldoActual()
    {
        return $this->movimientosSaldo()->sum("monto");
    }


    /**
     * Obtener suma de ingresos obtenidos con este alquiler (pagos a cuenta de chofer)
     * @return float
     */
    public function calcularIngresosTotales()
    {
        return $this->movimientosSaldo()
            ->where("tipo", MovimientoAlquiler::TIPO_PAGO_DE_CHOFER)
            ->sum("monto");
    }



    /**
     * Terminar el alquiler.
     * @return null
     */
    public function terminar()
    {
        if($this->estaFinalizado())
            return;

        $this->chofer->asignarAlquilerActual(null);
        $this->vehiculo->asignarAlquilerActual(null);

        $this->fecha_fin = Carbon::today();
        $this->estado = self::ESTADO_FINALIZADO;
        $this->save();
    }


}
