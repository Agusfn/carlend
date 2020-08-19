<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MovimientoAlquiler;
use Carbon\Carbon;

class Alquiler extends Model
{

    const ESTADO_EN_CURSO = "en_curso";
    const ESTADO_FINALIZADO = "finalizado";


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
     * Obtener chofer de este alquiler.
     * @return App\Chofer|null
     */
    public function chofer()
    {
        return $this->belongsTo("App\Chofer", "id_chofer");
    }    


    /**
     * Obtener vehiculo de este alquiler.
     * @return App\Vehiculo|null
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo");
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
     * Agregar nuevo movimiento a este alquiler.
     * @param  string $tipo       
     * @param  float $monto      
     * @param  string $medioPago  
     * @param  string $comentario 
     * @return null             
     */
    public function agregarMovimiento($tipoMovimiento, $monto, $medioPago, $comentario)
    {
        
        $nuevoSaldo = $this->calcularSaldoActual() + $monto;

        MovimientoAlquiler::create([
            "fecha_hora" => Carbon::now(),
            "id_alquiler" => $this->id,
            "tipo" => $tipoMovimiento,
            "monto" => $monto,
            "nuevo_saldo" => $nuevoSaldo,
            "medio_pago" => $medioPago,
            "comentario" => $comentario
        ]);

        $this->saldo_actual = $nuevoSaldo;
        $this->save();
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
