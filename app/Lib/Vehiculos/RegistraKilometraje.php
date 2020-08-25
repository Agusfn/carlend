<?php

namespace App\Lib\Vehiculos;

use Carbon\Carbon;
use App\Lib\Math;
use App\ActualizacionKmVehiculo;


trait RegistraKilometraje
{



    /**
     * Registrar kilometraje inicial a vehiculo (solo se llama cuando se crea el vehiculo)
     * @param  int $kilometros
     * @return null
     */
    public function registrarKilometrajeInicial($kilometros)
    {
        $this->registrarKilometrajeEnFecha($kilometros, Carbon::now());
    }


    /**
     * Registrar kilometraje a vehiculo en la fecha siguiente cronogramada.
     * @param  int $kilometros
     * @return null
     */
    public function registrarKilometraje($kilometros)
    {
        $this->registrarKilometrajeEnFecha($kilometros, $this->fechaSgteRegistroKilometraje());
    }


    /**
     * Registrar kilometraje a vehiculo
     * @param  int $kilometros
     * @param Carbon $fecha
     * @return null
     */
    private function registrarKilometrajeEnFecha($kilometros, Carbon $fecha)
    {
        ActualizacionKmVehiculo::create([
            "id_vehiculo" => $this->id,
            "fecha" => $fecha,
            "kilometros" => $kilometros
        ]);
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
     * Obtener ultimo kilometraje registrado.
     * @return int
     */
    public function ultimoKmIngresado()
    {
        return $this->actualizacionesKms()->orderBy("fecha", "desc")->first()->kilometros;
    }


    /**
     * Si en este momento puede el usuario registrar una nueva actualización de kilometraje.
     * @return bool
     */
    public function puedeRegistrarKilometraje()
    {
        return $this->enFechaParaRegistrarKilometraje() &&
            $this->adeudaRegistroDeKilometraje();
    }


    /**
     * Obtener el kilometraje actual estimado.
     * @return int
     */
    public function kilometrajeEstimadoActual()
    {
        if(!$this->puedeEstimarKilometraje())
            return false;

        return $this->estimarKilometraje(Carbon::today());
    }


    /**
     * Obtener uso actual en KMs cada 30 dias
     * @return int
     */
    public function usoKmsMensualEstimado()
    {
        if(!$this->puedeEstimarKilometraje())
            return false;

        return round( (($this->b1_prediccion_km*self::SEGS_ENTRE_CADA_ACTUALIZ_KMS) / self::DIAS_ENTRE_CADA_ACTUALIZ_KMS) * 30);
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

    /**
     * Si hay suficientes registros para calcular una predicción de kilometraje.
     * @return [type] [description]
     */
    public function puedeCalcularPrediccionKms()
    {
        return ($this->actualizacionesKms()->count() > 2);
    }


    /**
     * Calcular regresión lineal en base a los registros existentes de kilometraje y guardar b0 y b1 para predicciones futuras.
     * @return null
     */
    public function calcularPrediccionKilometraje()
    {

        $registrosKms = $this->actualizacionesKms()->orderBy("fecha", "asc")->take(5)->get();

        if($registrosKms->count() < 2)
            return false;

        $kilometrajes = $this->crearArrayDeKilometrajes($registrosKms);

        $recta = Math::linearRegression(array_keys($kilometrajes), array_values($kilometrajes));

        $this->b0_prediccion_km = $recta["intercept"];
        $this->b1_prediccion_km = $recta["slope"];

        $this->save();
    }


    /**
     * Crear un conjunto de pares X,Y (fecha, kms recorridos) para regresión lineal, a partir de una colección de ActualizacionKmsVehiculo
     * El conjunto comienza con el primer registro de la colección y termina con el último, con step cada 14 días, y asignando un promedio a los valores faltantes.
     * @param  Illuminate\Database\Eloquent\Collection $registrosKms
     * @return array
     */
    private function crearArrayDeKilometrajes($registrosKms)
    {

        $kilometrajes = [];
        $sum = 0;

        // Ingresamos los valores existentes

        foreach($registrosKms as $registroKms) 
        {
            $kilometrajes[$registroKms->fecha->timestamp] = $registroKms->kilometros;
            $sum += $registroKms->kilometros;
        }

        $avg = $sum / $registrosKms->count();


        // Llenamos los huecos vacíos con el promedio.
        
        $fechaRegistro = $registrosKms->first()->fecha;

        while($fechaRegistro <= $registrosKms->last()->fecha)
        {
            if(!array_key_exists($fechaRegistro->timestamp, $kilometrajes)) {
                $kilometrajes[$fechaRegistro->timestamp] = $avg;
            }

            $fechaRegistro->addDays(self::DIAS_ENTRE_CADA_ACTUALIZ_KMS);
        }

        ksort($kilometrajes);

        return $kilometrajes;
    }



    /**
     * Si es posible calcular una predicción de kilometraje (si b0 y b1 están definidos)
     * @return bool
     */
    public function puedeEstimarKilometraje()
    {
        return $this->b1_prediccion_km && $this->b0_prediccion_km;
    }


    /**
     * Estimar linealmente kilometraje de una fecha dada con la prediccion existente.
     * @param  Carbon\Carbon $fecha
     * @return int kilómetros
     */
    public function estimarKilometraje(Carbon $fecha)
    {
        return round($fecha->timestamp * $this->b1_prediccion_km + $this->b0_prediccion_km);
    }


    /**
     * Estimar inversamente la fecha a partir del kilometraje.
     * @param  int $kilometraje
     * @return Carbon\Carbon
     */
    public function estimarFechaDesdeKilometraje($kilometraje)
    {
        $timestamp = round(($kilometraje - $this->b0_prediccion_km) / $this->b1_prediccion_km);
        return Carbon::createFromTimestamp($timestamp);
    }


    /**
     * Obtener un array con 3 arrays (fechas, kms registrados, kms predecidos) para graficar en html
     * @return array|false
     */
    public function estimacionKmsAnualParaGrafico()
    {

        if(!$this->puedeEstimarKilometraje())
            return false;

        // obtener todos los registros de hasta los ultimos 6 meses
        $registrosKms = $this->actualizacionesKms()->orderBy("fecha", "asc")
            ->whereDate("fecha", ">=", Carbon::now()->subMonths(6))
            ->get();


        $datosKms = [];
        $fechaIterada = $registrosKms->first()->fecha; // hasta 6 meses antes a hoy
        $fechaFinal = Carbon::now()->addMonths(2); // hasta 2 meses posterior a hoy

        while($fechaIterada <= $fechaFinal)
        {
            $datosKms["fechas"][] = $fechaIterada->format("d/m");

            $registroKms = $registrosKms->firstWhere("fecha", $fechaIterada);
            $datosKms["kms_registrados"][] = $registroKms ? $registroKms->kilometros : null;

            $datosKms["kms_estimados"][] = $this->estimarKilometraje($fechaIterada);

            $fechaIterada->addDays(self::DIAS_ENTRE_CADA_ACTUALIZ_KMS);
        }

        //dump($datosKms);
        return $datosKms;
    }



}