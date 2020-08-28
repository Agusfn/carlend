<?php

namespace App\Lib\Cron;

use App\Vehiculo;

class Vehiculos
{


	/**
	 * Setea para cada vehiculo, un atributo que indica si está en fecha actualmente para registrar kilometraje y si adeuda su registro.
	 * Dicho atributo se usa para obtener los vehiculos que deben tener su kilometraje ingresado, en la barra de notificaciones.
	 * @return null
	 */
	public static function actualizarFlagRegistroKilometraje()
	{
		$vehiculos = Vehiculo::all();

		foreach($vehiculos as $vehiculo)
		{
			$vehiculo->en_fecha_registro_kms = $vehiculo->puedeRegistrarKilometraje();
			$vehiculo->save();
		}

	}


}