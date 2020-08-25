<?php

namespace App\Lib\Reportes;

use Illuminate\Support\Facades\DB;
use App\TrabajoVehiculo;
use App\GastoAdicional;
use Carbon\Carbon;


class UtilidadesReportes
{
		


	/**
	 * Obtiene un array de cada mes (en formato Carbon) desde el momento del primer registro (de alquiler, trabajo, o gasto adicional) hasta el mes actual.
	 * @return array
	 */
	public static function obtenerMesesDeDatosDisponibles()
	{
		$mesesMasAntiguos = [];

		$mesesMasAntiguos[] = DB::table("alquileres")
			->select(DB::raw("DATE_FORMAT(fecha_inicio, '%Y-%m') as month"))
			->orderBy("fecha_inicio", "ASC")->limit(1)
			->value("month") ?: false;

		$mesesMasAntiguos[] = DB::table("trabajos_vehiculos")
			->select(DB::raw("DATE_FORMAT(fecha_pagado, '%Y-%m') as month"))
			->where("es_trabajo_previo", 0)
			->orderBy("fecha_pagado", "ASC")->limit(1)
			->value("month") ?: false;

		$mesesMasAntiguos[] = DB::table("gastos_adicionales")
			->select(DB::raw("DATE_FORMAT(fecha, '%Y-%m') as month"))
			->orderBy("fecha", "ASC")->limit(1)
			->value("month") ?: false;

		$mesesMasAntiguos = array_filter($mesesMasAntiguos); // elimina FALSE, agrega keys
		sort($mesesMasAntiguos); // ordena fechas ASC (como strings) y remueve keys


		if(sizeof($mesesMasAntiguos) >= 1) {
			$fechaIterada = Carbon::create($mesesMasAntiguos[0]);
		}
		else {
			$fechaIterada = Carbon::today();
			$fechaIterada->day = 1;
		}


		$ahora = Carbon::now();
		$mesesDisponibles = [];

		while($fechaIterada->lessThanOrEqualTo($ahora))
		{
			$mesesDisponibles[] = $fechaIterada->copy();
			$fechaIterada->addMonth(1);
		}

		return $mesesDisponibles;
	}


	/**
	 * Obtener el tipo de gasto (un TIPO simplificado y combinado usado únicamente para los reportes) a partir del tipo de trabajo vehicular.
	 * @param  string $tipoTrabajoVehicular
	 * @return string                       
	 */
	public static function obtenerTipoGastoDeTipoTrabajoVehicular($tipoTrabajoVehicular)
	{
		if($tipoTrabajoVehicular == TrabajoVehiculo::SERVICE) {
			return "services";
		}
		else if($tipoTrabajoVehicular == TrabajoVehiculo::REPARACION) {
			return "reparaciones";
		}
		else {
			return "otros_trabajos";
		}
	}



	/**
	 * Obtener el tipo de gasto (un TIPO simplificado y combinado usado únicamente para los reportes) a partir del tipo de gasto adicional.
	 * @param  string $tipoGastoAdicional 
	 * @return string                     
	 */
	public static function obtenerTipoGastoDeTipoGastoAdicional($tipoGastoAdicional)
	{
		if($tipoGastoAdicional == GastoAdicional::TIPO_PAGO_SEGURO_VEHICULO) {
			return "seguros";
		}
		else if($tipoGastoAdicional == GastoAdicional::TIPO_PAGO_IMPUESTO_VEHICULO) {
			return "impuestos_automotor";
		}
		else {
			return "otros_gastos";
		}
	}


	/**
	 * Crear un array del 1 al n con ceros, siendo n la cantidad de días del mes del año indicado.
	 * @param  [type] $mes  [description]
	 * @param  [type] $anio [description]
	 * @return [type]       [description]
	 */
	private static function arrayNumericoDeDiasDelMes($mes, $anio)
	{
		$cantidadDias = Carbon::createFromDate($anio, $mes)->daysInMonth;

		$array = [];

		for($i = 1; $i <= $cantidadDias; $i++) {
			$array[$i] = 0;
		}

		return $array;
	}


}