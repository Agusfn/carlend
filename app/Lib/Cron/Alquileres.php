<?php

namespace App\Lib\Cron;

use App\Alquiler;
use Carbon\Carbon;

class Alquileres
{


	/**
	 * Debitar los cobros del día de alquiler de las cuentas corrientes de alquileres en curso.
	 * Los cobros se hacen a DIA ATRASADO, es decir se cobra lo del día anterior.
	 * @return null
	 */
	public static function realizarCobrosDelDia()
	{

		$alquileresEnCurso = Alquiler::enCurso()->get();

		foreach($alquileresEnCurso as $alquiler)
		{

			$diaDeCobro = Carbon::today()->subDay();

			// No cobrar si el cobro es de un domingo y hay descuento semanal.
			if($alquiler->descuento_semanal && $diaDeCobro->dayOfWeek == 0) {
				continue;
			}

			$alquiler->debitarCobroDeAlquiler($alquiler->precio_diario);
		}


	}

	
	/**
	 * Finalizar alquileres que llegaron a su fecha de finalización.
	 * @return null
	 */
	public static function terminarAlquileresProgramados()
	{

		$alquileresATerminar = Alquiler::with(["chofer", "vehiculo"])
			->enCurso()
			->where("fecha_fin", "<", date("Y-m-d")) // debe haber transcurrido el día de la fecha de fin y comenzado el sgte día (el cobro se debe haber debitado)
			->get();

		foreach($alquileresATerminar as $alquiler)
		{
	        $alquiler->chofer->asignarAlquilerActual(null);
	        $alquiler->vehiculo->asignarAlquilerActual(null);

	        $alquiler->estado = Alquiler::ESTADO_FINALIZADO;
	        $alquiler->save();
		}

	}




}