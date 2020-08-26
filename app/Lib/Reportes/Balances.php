<?php

namespace App\Lib\Reportes;

use App\MovimientoAlquiler;
use App\TrabajoVehiculo;
use App\GastoAdicional;

class Balances
{


	/**
	 * Obtener reporte con total ingresos y gastos, gastos clasificados por tipo, y gastos clasificados por proveedor.
	 * @param  int $mes  
	 * @param  int $anio 
	 * @return array
	 */
	public static function generarReporte($mes, $anio)
	{

		// Ingresos
		$movimientosAlquiler = MovimientoAlquiler::pagosDeChofer()->enMesYAnio($mes, $anio)->get();

		// Gastos
		$trabajosVehiculos = TrabajoVehiculo::with("proveedor")->validos()->conCosto()->pagadoEnMesYAnio($mes, $anio)->get();
		$gastosAdicionales = GastoAdicional::with("proveedor")->enMesYAnio($mes, $anio)->get();

		return [
			"resumen_balances" => self::resumenBalancesMensual($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales, $mes, $anio),
			"gastos_segun_tipo" => self::gastosSegunTipo($trabajosVehiculos, $gastosAdicionales),
			"gastos_segun_proveedor" => self::gastosSegunProveedor($trabajosVehiculos, $gastosAdicionales)
		];
	}


	/**
	 * Detalles de balances mensuales.
	 * @param  int $mes  
	 * @param  int $anio 
	 * @return array
	 */
	public static function reporteSoloBalanceMensual($mes, $anio)
	{
		// Ingresos
		$movimientosAlquiler = MovimientoAlquiler::pagosDeChofer()->enMesYAnio($mes, $anio)->get();

		// Gastos
		$trabajosVehiculos = TrabajoVehiculo::with("proveedor")->validos()->conCosto()->pagadoEnMesYAnio($mes, $anio)->get();
		$gastosAdicionales = GastoAdicional::with("proveedor")->enMesYAnio($mes, $anio)->get();

		return self::resumenBalancesMensual($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales, $mes, $anio);
	}



	/**
	 * Generar resumen balances (ingresos totales, gastos totales, e ingresos y gastos cada día)
	 * @param  [type] $trabajosVehiculos [description]
	 * @param  [type] $gastosAdicionales [description]
	 * @return [type]                    [description]
	 */
	private static function resumenBalancesMensual($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales, $mes, $anio)
	{

		$ingresoTotal = 0;
		$gastoTotal = 0;
		$ingresosDiarios = $gastosDiarios = UtilidadesReportes::arrayNumericoDeDiasDelMes($mes, $anio);

		foreach($movimientosAlquiler as $movimientoAlquiler)
		{
			$ingresoTotal += $movimientoAlquiler->monto;
			$ingresosDiarios[$movimientoAlquiler->fecha_hora->day] += $movimientoAlquiler->monto;
		}

		foreach($trabajosVehiculos as $trabajoVehiculo)
		{
			$gastoTotal += $trabajoVehiculo->costo_total;
			$gastosDiarios[$trabajoVehiculo->fecha_pagado->day] += $trabajoVehiculo->costo_total;
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			$gastoTotal += $gastoAdicional->monto;
			$gastosDiarios[$gastoAdicional->fecha->day] += $gastoAdicional->monto;
		}

		return [
			"ingreso_total" => $ingresoTotal,
			"gasto_total" => $gastoTotal,
			"ingresos_diarios" => $ingresosDiarios,
			"gastos_diarios" => $gastosDiarios
		];
	}



	/**
	 * Clasificar gastos según tipo (un TIPO simplificado y combinado usado únicamente para los reportes) y según proveedor.
	 * @return [type] [description]
	 */
	private static function gastosSegunTipo($trabajosVehiculos, $gastosAdicionales)
	{
		
		$gastosPorTipo = [];

		foreach($trabajosVehiculos as $trabajoVehiculo) 
		{
			$tipoGasto = UtilidadesReportes::obtenerTipoGastoDeTipoTrabajoVehicular($trabajoVehiculo->tipo);
			$gastosPorTipo[$tipoGasto] = isset($gastosPorTipo[$tipoGasto]) ? ($gastosPorTipo[$tipoGasto] + $trabajoVehiculo->costo_total) : (float)$trabajoVehiculo->costo_total;
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			$tipoGasto = UtilidadesReportes::obtenerTipoGastoDeTipoGastoAdicional($gastoAdicional->tipo);
			$gastosPorTipo[$tipoGasto] = isset($gastosPorTipo[$tipoGasto]) ? ($gastosPorTipo[$tipoGasto] + $gastoAdicional->monto) : (float)$gastoAdicional->monto;
		}

		return $gastosPorTipo;
	}


	/**
	 * Clasificar gastos (de trabajos vehiculares y gastos adicionales) segun proveedor.
	 * @param  [type] $trabajosVehiculos
	 * @param  [type] $gastosAdicionales
	 * @return array
	 */
	private static function gastosSegunProveedor($trabajosVehiculos, $gastosAdicionales)
	{
		$gastosPorProveedor = [];

		foreach($trabajosVehiculos as $trabajoVehiculo) 
		{
			if($trabajoVehiculo->proveedor) 
			{
				$nombreProveedor = $trabajoVehiculo->proveedor->nombre;
				
				if(isset($gastosPorProveedor[$nombreProveedor]))
					$gastosPorProveedor[$nombreProveedor] += $trabajoVehiculo->costo_total;
				else 
					$gastosPorProveedor[$nombreProveedor] = (float)$trabajoVehiculo->costo_total;
				
			}
			else {
				$gastosPorProveedor["Otros"] = isset($gastosPorProveedor["Otros"]) ? $gastosPorProveedor["Otros"] + $trabajoVehiculo->costo_total : (float)$trabajoVehiculo->costo_total;
			}
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			if($gastoAdicional->proveedor) 
			{
				$nombreProveedor = $gastoAdicional->proveedor->nombre;

				if(isset($gastosPorProveedor[$nombreProveedor]))
					$gastosPorProveedor[$nombreProveedor] += $gastoAdicional->monto;
				else
					$gastosPorProveedor[$nombreProveedor] = (float)$gastoAdicional->monto;
				
			}
			else {
				$gastosPorProveedor["Otros"] = isset($gastosPorProveedor["Otros"]) ? $gastosPorProveedor["Otros"] + $gastoAdicional->monto : (float)$gastoAdicional->monto;
			}
		}

		return $gastosPorProveedor;
	}



}