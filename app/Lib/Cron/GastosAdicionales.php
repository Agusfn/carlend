<?php

namespace App\Lib\Cron;

use App\Vehiculo;
use App\GastoAdicional;
use Carbon\Carbon;

class GastosAdicionales
{
	

	/**
	 * Registrar gastos adicionales correspondientes a los débitos automáticos actuales.
	 * @return null
	 */
	public static function registrarDebitosAutomaticos()
	{
		$fechaHoy = Carbon::today();

		$vehiculosConDebito = Vehiculo::conAlgunDebitoAutomatico()->get();

		foreach($vehiculosConDebito as $vehiculo)
		{
			if($vehiculo->tieneDebitoAutomPatentes() && $fechaHoy->day == $vehiculo->dia_del_mes_debito_imp_automotor) 
			{
				GastoAdicional::create([
					"fecha" => $fechaHoy,
					"tipo" => GastoAdicional::TIPO_PAGO_IMPUESTO_VEHICULO,
					"id_vehiculo" => $vehiculo->id,
					"monto" => $vehiculo->costo_mensual_imp_automotor,
					"medio_pago" => GastoAdicional::MEDIO_PAGO_TARJETA
				]);
			}

			if($vehiculo->tieneDebitoAutomSeguro() && $fechaHoy->day == $vehiculo->dia_del_mes_debito_seguro)
			{
				GastoAdicional::create([
					"fecha" => $fechaHoy,
					"tipo" => GastoAdicional::TIPO_PAGO_SEGURO_VEHICULO,
					"id_vehiculo" => $vehiculo->id,
					"monto" => $vehiculo->costo_mensual_seguro,
					"medio_pago" => GastoAdicional::MEDIO_PAGO_TARJETA,
					"id_proveedor" => $vehiculo->id_proveedor_seguro
				]);
			}
		}

	}


}