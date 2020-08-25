<?php

namespace App\Lib\Reportes;

use App\MovimientoAlquiler;
use App\TrabajoVehiculo;
use App\GastoAdicional;
use Carbon\Carbon;

class Balances
{


	/**
	 * Obtener reporte con total ingresos y gastos, 
	 * @return [type] [description]
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
	 * Generar resumen balances (ingresos totales, gastos totales, e ingresos y gastos cada día)
	 * @param  [type] $trabajosVehiculos [description]
	 * @param  [type] $gastosAdicionales [description]
	 * @return [type]                    [description]
	 */
	private static function resumenBalancesMensual($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales, $mes, $anio)
	{

		$ingresoTotal = 0;
		$gastoTotal = 0;
		$ingresosDiarios = $gastosDiarios = self::arrayNumericoDeDiasDelMes($mes, $anio);

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



	/**
	 * Clasificar gastos según tipo (un TIPO simplificado y combinado usado únicamente para los reportes) y según proveedor.
	 * @return [type] [description]
	 */
	private static function gastosSegunTipo($trabajosVehiculos, $gastosAdicionales)
	{
		
		$gastosPorTipo = [];

		foreach($trabajosVehiculos as $trabajoVehiculo) 
		{
			$tipoGasto = self::obtenerTipoGastoDeTipoTrabajoVehicular($trabajoVehiculo->tipo);
			$gastosPorTipo[$tipoGasto] = isset($gastosPorTipo[$tipoGasto]) ? ($gastosPorTipo[$tipoGasto] + $trabajoVehiculo->costo_total) : (float)$trabajoVehiculo->costo_total;
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			$tipoGasto = self::obtenerTipoGastoDeTipoGastoAdicional($gastoAdicional->tipo);
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
				$gastosPorProveedor["otros"] = isset($gastosPorProveedor["otros"]) ? $gastosPorProveedor["otros"] + $trabajoVehiculo->costo_total : (float)$trabajoVehiculo->costo_total;
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
				$gastosPorProveedor["otros"] = isset($gastosPorProveedor["otros"]) ? $gastosPorProveedor["otros"] + $gastoAdicional->monto : (float)$gastoAdicional->monto;
			}
		}

		return $gastosPorProveedor;
	}


	/**
	 * Obtener el tipo de gasto usado para el reporte, a partir del tipo de trabajo vehicular.
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
	 * Obtener el tipo de gasto usado para el reporte, a partir del tipo de gasto adicional.
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


}