<?php

namespace App\Lib\Reportes;

use App\MovimientoAlquiler;
use App\Alquiler;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Choferes
{


	/**
	 * Generar reporte de choferes con los días alquilados por cada chofer, y los ingresos generados por cada uno.
	 * @param  int $mes  
	 * @param  int $anio 
	 * @return array       
	 */
	public static function generarReporte($mes, $anio)
	{
		// ingresos
		$movimientosAlquiler = MovimientoAlquiler::with("alquiler.chofer")->pagosDeChofer()->enMesYAnio($mes, $anio)->get();

		return [
			"detalle_dias_alquilados" => self::detalleDiasAlquiladosPorChofer($mes, $anio),
			"detalle_pagos_de_choferes" => self::detallePagosRealizadosPorChoferes($movimientosAlquiler)
		];

	}

	

	/**
	 * Generar detalle con la suma de los pagos realizados por cada chofer (usando su nombre y apellido como key del array)
	 * @param  [type] $movimientosAlquiler [description]
	 * @return array
	 */
	private static function detallePagosRealizadosPorChoferes($movimientosAlquiler)
	{
		
		$pagosPorChoferes = [];

		foreach($movimientosAlquiler as $movimientoAlquiler)
		{
			$nombreChofer = $movimientoAlquiler->alquiler->chofer->nombre_y_apellido;

			if(isset($pagosPorChoferes[$nombreChofer])) {
				$pagosPorChoferes[$nombreChofer] += $movimientoAlquiler->monto;
			}
			else {
				$pagosPorChoferes[$nombreChofer] = (float)$movimientoAlquiler->monto;
			}

		}

		return $pagosPorChoferes;
	}




	/**
	 * Obtener array con el tiempo de alquiler en días por cada chofer (cuyo nombre es la key del array).
	 * @param  int $mes  
	 * @param  int $anio 
	 * @return array       
	 */
	private static function detalleDiasAlquiladosPorChofer($mes, $anio)
	{	
		$primerDiaMes = $anio."-".$mes."-01";
		
		$ultDiaMes = Carbon::createFromDate($anio, $mes, Carbon::create($primerDiaMes)->daysInMonth)
			->addDay()->format("Y-m-d");  // agregamos 1 día porque el día de alquiler finaliza en el día siguiente a dicho día

		$alquileres = Alquiler::with("chofer")->entreFechas($primerDiaMes, $ultDiaMes)->get();


		$diasAlquiladosChoferes = [];

		foreach($alquileres as $alquiler)
		{
			$periodo = CarbonPeriod::create(
				$alquiler->fecha_inicio,
				$alquiler->fecha_fin ?: Carbon::today(),
				CarbonPeriod::EXCLUDE_END_DATE
			);

			$nombreChofer = $alquiler->chofer->nombre_y_apellido;

			$diasAlquiladosChoferes[$nombreChofer] = 0;

			foreach($periodo as $fecha)
			{
				if($fecha->year == $anio && $fecha->month == $mes && !$fecha->isFuture()) {
					$diasAlquiladosChoferes[$nombreChofer] ++;
				}
			}

		}

		return $diasAlquiladosChoferes;
	}



}