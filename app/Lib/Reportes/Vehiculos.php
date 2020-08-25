<?php

namespace App\Lib\Reportes;

use App\MovimientoAlquiler;
use App\TrabajoVehiculo;
use App\GastoAdicional;
use App\Alquiler;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Vehiculo;


class Vehiculos
{

	public static function generarReporte($mes, $anio)
	{

		// Ingresos
		$movimientosAlquiler = MovimientoAlquiler::with("alquiler.vehiculo")->pagosDeChofer()->enMesYAnio($mes, $anio)->get();

		// Gastos
		$trabajosVehiculos = TrabajoVehiculo::with("vehiculo")->validos()->conCosto()->pagadoEnMesYAnio($mes, $anio)->get();
		$gastosAdicionales = GastoAdicional::with("vehiculo")->enMesYAnio($mes, $anio)->get();

		return [
			"resumen_balances_vehiculos" => self::resumenBalancesVehiculos($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales),
			"detalle_gastos_vehiculos" => self::detalleGastosVehiculos($trabajosVehiculos, $gastosAdicionales),
			"detalle_dias_alquilados" => self::detalleDiasAlquiladosPorVehiculo($mes, $anio),
			"detalle_kms_recorridos" => self::detalleKmsRecorridosPorVehiculo($mes, $anio)
		];

	}


	/**
	 * [resumenBalancesVehiculos description]
	 * @param  [type] $movimientosAlquiler [description]
	 * @param  [type] $trabajosVehiculos   [description]
	 * @param  [type] $gastosAdicionales   [description]
	 * @return [type]                      [description]
	 */
	private static function resumenBalancesVehiculos($movimientosAlquiler, $trabajosVehiculos, $gastosAdicionales)
	{
		
		$ingresosPorVehiculo = [];
		$gastosPorVehiculo = [];

		foreach($movimientosAlquiler as $movimientoAlquiler)
		{
			$nombreVehiculo = $movimientoAlquiler->alquiler->vehiculo->marcaYModelo();

			if(isset($ingresosPorVehiculo[$nombreVehiculo])) {
				$ingresosPorVehiculo[$nombreVehiculo] += $movimientoAlquiler->monto;
			}
			else {
				$ingresosPorVehiculo[$nombreVehiculo] = (float)$movimientoAlquiler->monto;
			}

		}

		foreach($trabajosVehiculos as $trabajoVehiculo)
		{
			$nombreVehiculo = $trabajoVehiculo->vehiculo->marcaYModelo();

			if(isset($gastosPorVehiculo[$nombreVehiculo])) {
				$gastosPorVehiculo[$nombreVehiculo] += $trabajoVehiculo->costo_total;
			}
			else {
				$gastosPorVehiculo[$nombreVehiculo] = (float)$trabajoVehiculo->costo_total;
			}
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			if(!$gastoAdicional->vehiculo)
				continue;

			$nombreVehiculo = $gastoAdicional->vehiculo->marcaYModelo();

			if(isset($gastosPorVehiculo[$nombreVehiculo])) {
				$gastosPorVehiculo[$nombreVehiculo] += $gastoAdicional->monto;
			}
			else {
				$gastosPorVehiculo[$nombreVehiculo] = (float)$gastoAdicional->monto;
			}
		}


		return [
			"ingresos_por_vehiculo" => $ingresosPorVehiculo,
			"gastos_por_vehiculo" => $gastosPorVehiculo
		];
	}


	/**
	 * [detalleGastosVehiculos description]
	 * @param  [type] $trabajosVehiculos [description]
	 * @param  [type] $gastosAdicionales [description]
	 * @return [type]                    [description]
	 */
	private static function detalleGastosVehiculos($trabajosVehiculos, $gastosAdicionales)
	{
		$gastosVehiculos = [];

		foreach($trabajosVehiculos as $trabajoVehiculo)
		{
			$nombreVehiculo = $trabajoVehiculo->vehiculo->marcaYModelo();

			$tipoGasto = Balances::obtenerTipoGastoDeTipoTrabajoVehicular($trabajoVehiculo->tipo);

			if(isset($gastosVehiculos[$nombreVehiculo][$tipoGasto])) {
				$gastosVehiculos[$nombreVehiculo][$tipoGasto] += $trabajoVehiculo->costo_total;
			}
			else {
				$gastosVehiculos[$nombreVehiculo][$tipoGasto] = (float)$trabajoVehiculo->costo_total;
			}
		}

		foreach($gastosAdicionales as $gastoAdicional)
		{
			if(!$gastoAdicional->vehiculo)
				continue;

			$nombreVehiculo = $gastoAdicional->vehiculo->marcaYModelo();

			$tipoGasto = Balances::obtenerTipoGastoDeTipoGastoAdicional($gastoAdicional->tipo);

			if(isset($gastosVehiculos[$nombreVehiculo][$tipoGasto])) {
				$gastosVehiculos[$nombreVehiculo][$tipoGasto] += $gastoAdicional->monto;
			}
			else {
				$gastosVehiculos[$nombreVehiculo][$tipoGasto] = (float)$gastoAdicional->monto;
			}
			
		}


		return $gastosVehiculos;
	}


	/**
	 * Obtener array con el tiempo de alquiler en días por cada vehiculo (cuyo nombre es la key del array).
	 * @param  int $mes  
	 * @param  int $anio 
	 * @return array       
	 */
	private static function detalleDiasAlquiladosPorVehiculo($mes, $anio)
	{	
		$primerDiaMes = $anio."-".$mes."-01";
		
		$ultDiaMes = Carbon::createFromDate($anio, $mes, Carbon::create($primerDiaMes)->daysInMonth)
			->addDay()->format("Y-m-d");  // agregamos 1 día porque el día de alquiler finaliza en el día siguiente a dicho día

		$alquileres = Alquiler::with("vehiculo")->entreFechas($primerDiaMes, $ultDiaMes)->get();


		$diasAlquiladosVehiculos = [];

		foreach($alquileres as $alquiler)
		{
			$periodo = CarbonPeriod::create(
				$alquiler->fecha_inicio,
				$alquiler->fecha_fin ?: Carbon::today(),
				CarbonPeriod::EXCLUDE_END_DATE
			);

			$nombreVehiculo = $alquiler->vehiculo->modeloYDominio();

			$diasAlquiladosVehiculos[$nombreVehiculo] = 0;

			foreach($periodo as $fecha)
			{
				if($fecha->year == $anio && $fecha->month == $mes) {
					$diasAlquiladosVehiculos[$nombreVehiculo] ++;
				}
			}

		}

		return $diasAlquiladosVehiculos;
	}



	/**
	 * [detalleKmsRecorridosPorVehiculo description]
	 * @param  [type] $mes  [description]
	 * @param  [type] $anio [description]
	 * @return [type]       [description]
	 */
	public static function detalleKmsRecorridosPorVehiculo($mes, $anio)
	{
		
		$kmsRecorridosVehiculos = [];

		$primerDiaMes = $anio."-".$mes."-01";

		$diasEnElMes = Carbon::create($primerDiaMes)->daysInMonth;
		$ultDiaMes = Carbon::createFromDate($anio, $mes, $diasEnElMes)->format("Y-m-d");

		$vehiculos = Vehiculo::all();

		foreach($vehiculos as $vehiculo)
		{

			$actualizacionesKms = $vehiculo->actualizacionesKms()->whereBetween("fecha", [$primerDiaMes, $ultDiaMes])->get();
			
			if($actualizacionesKms->count() < 2)
				continue;

			$kmsInicial = $actualizacionesKms->get(0)->kilometros;
			$kmsFinal = $actualizacionesKms->get(1)->kilometros;
			
			$difDias = CarbonPeriod::create(
				$actualizacionesKms->get(0)->fecha, 
				$actualizacionesKms->get(1)->fecha, 
				CarbonPeriod::EXCLUDE_START_DATE
			)->count();

			$kmsDiarios = ($kmsFinal - $kmsInicial) / $difDias;
			$kmsRecorridos = round($kmsDiarios * $diasEnElMes);

			$kmsRecorridosVehiculos[$vehiculo->modeloYDominio()] = $kmsRecorridos;
		}

		return $kmsRecorridosVehiculos;
	}




}