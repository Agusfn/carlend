<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ActualizacionKmVehiculo;
use Carbon\Carbon;


class Vehiculo extends Model
{
    use SoftDeletes;
    
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
        'fecha_vto_vtv',
        'fecha_vto_oblea_gnc',
        'fecha_vto_poliza_seguro'
    ];



    /**
     * Obtener alquiler actual del vehículo.
     * @return App\Alquiler|null
     */
    public function alquilerActual()
    {
        return $this->belongsTo("App\Alquiler", "id_alquiler_actual");
    }    


    /**
     * Obtener el proveedor de seguro actual
     * @return App\Proveedor|null
     */
    public function proveedorSeguro()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor_seguro");
    }



    /**
     * Obtener las actualizaciones de Kms del vehiculo.
     */
    public function actualizacionesKms()
    {
        return $this->hasMany("App\ActualizacionKmVehiculo", "id_vehiculo");
    }


    /**
     * Obtener los trabajos de este vehículo
     */
    public function trabajos()
    {
        return $this->hasMany("App\TrabajoVehiculo", "id_vehiculo");
    }


    /**
     * Obtener query builder de trabajos previos (o iniciales) de vehiculo.
     * @return [type] [description]
     */
    public function trabajosPrevios()
    {
        return $this->trabajos()->where("es_trabajo_previo", true);
    }


    /**
     * Si el vehiculo tiene registrado el débito automático de pago de patentes
     * @return bool
     */
    public function tieneDebitoAutomPatentes()
    {
        return ($this->costo_mensual_imp_automotor && $this->dia_del_mes_debito_imp_automotor);
    } 

    /**
     * Si el vehiculo tiene registrado el debito automático del pago de seguro
     * @return bool
     */
    public function tieneDebitoAutomSeguro()
    {
        return $this->id_proveedor_seguro ? true : false;
    }   




    /**
     * Cada cuántos días se debe actualizar el kilometraje del auto a partir del primer ingreso.
     */
    const DIAS_ENTRE_CADA_ACTUALIZ_KMS = 14;

    /**
     * Dias mas/menos de tolerancia respecto de la fecha programada en el que se puede hacer el ingreso de KMs
     */
    const DIAS_TOLERANCIA_INGRESO_KMS = 3;


    /**
     * Variables de arriba pero en segundos. (no cambiar)
     */
    const SEGS_ENTRE_CADA_ACTUALIZ_KMS = self::DIAS_ENTRE_CADA_ACTUALIZ_KMS * 24 * 60 * 60;
    const SEGS_TOLERANCIA_INGRESO_KMS = self::DIAS_TOLERANCIA_INGRESO_KMS * 24 * 60 * 60;






    /**
     * Registrar kilometraje a vehiculo
     * @param  int $kilometros
     * @return null
     */
    public function registrarKilometraje($kilometros)
    {
        ActualizacionKmVehiculo::create([
            "id_vehiculo" => $this->id,
            "fecha" => Carbon::now(),
            "kilometros" => $kilometros
        ]);

        $this->kilometraje_prediccion_actual = $kilometros;
        $this->save();
    }



    /**
     * Obtener la fecha del primer registro de kilometros de este auto (que es la fecha de alta)
     * @return Carbon\Carbon
     */
    public function fechaDePrimeraActualizKms()
    {
        return $this->actualizacionesKms()->orderBy("fecha", "asc")->first()->fecha;
    }


    /**
     * Obtener la fecha de la última (más reciente) actualización de kilometraje de este auto.
     * @return Carbon\Carbon
     */
    public function fechaDeUltimaActualizKms()
    {
        return $this->actualizacionesKms()->orderBy("fecha", "desc")->first()->fecha;
    }


    /**
     * Si la fecha actual se encuentra entre las fechas requeridas para registrar kilometraje de este auto.
     * Las fechas requeridas por defecto son cada 14 días desde la fecha de alta +- 3 días de tolerancia.
     * No importa si se registró el kilometraje o no.
     * @return bool
     */
    public function enFechaParaRegistrarKilometraje()
    {
    
        $segsDesdePrimerIngreso = Carbon::now()->timestamp - $this->fechaDePrimeraActualizKms()->timestamp;

        $segsPasadosIntervaloActual = $segsDesdePrimerIngreso % self::SEGS_ENTRE_CADA_ACTUALIZ_KMS;


        if( $segsPasadosIntervaloActual <= self::SEGS_TOLERANCIA_INGRESO_KMS || 
            $segsPasadosIntervaloActual >= (self::SEGS_ENTRE_CADA_ACTUALIZ_KMS - self::SEGS_TOLERANCIA_INGRESO_KMS) ) 
        {
            return true;
        }
        else {
            return false;
        }

    }


    /**
     * Si al día de hoy pasaron 14-3=11 días o más de la última fecha de registro de kilometraje.
     * @return bool
     */
    public function adeudaRegistroDeKilometraje()
    {
        return $this->fechaDeUltimaActualizKms()
            ->addDays(self::DIAS_ENTRE_CADA_ACTUALIZ_KMS - self::DIAS_TOLERANCIA_INGRESO_KMS)
            ->lessThanOrEqualTo(Carbon::now());

    }


    /**
     * Obtener la fecha del siguiente registro de kilometraje programado (si ya se hizo en la fecha actual, arroja la siguiente)
     * Si se encuentra dentro de la tolerancia, puede dar una fecha anterior a la actual
     * @return Carbon\Carbon
     */
    public function fechaSgteRegistroKilometraje()
    {

        $fechaProxRegistro = $this->fechaDeUltimaActualizKms()->addDays(self::DIAS_ENTRE_CADA_ACTUALIZ_KMS);

        if($fechaProxRegistro->copy()->addDays(self::DIAS_TOLERANCIA_INGRESO_KMS)->isAfter(Carbon::now()))
        {
            return $fechaProxRegistro;
        }
        else // se pasó una de las fechas, obtener la próxima
        {
            $fechaRegistroInicial = $this->fechaDePrimeraActualizKms();

            $segsDesdePrimerIngreso = Carbon::now()->timestamp - $fechaRegistroInicial->timestamp;

            $segsPasadosIntervaloActual = $segsDesdePrimerIngreso % self::SEGS_ENTRE_CADA_ACTUALIZ_KMS;


            $intervalosTranscurridos = $segsDesdePrimerIngreso / self::SEGS_ENTRE_CADA_ACTUALIZ_KMS;

            if( $segsPasadosIntervaloActual <= self::SEGS_TOLERANCIA_INGRESO_KMS)  {
                $intervalosTranscurridos = floor($intervalosTranscurridos);
            }
            else  {
                $intervalosTranscurridos = ceil($intervalosTranscurridos);
            }

            return Carbon::createFromTimestamp($fechaRegistroInicial->timestamp + $intervalosTranscurridos * self::SEGS_ENTRE_CADA_ACTUALIZ_KMS);
        }



    }


}
