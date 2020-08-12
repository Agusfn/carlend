<?php

namespace App\Lib\Notificaciones;

use App\TareaPendiente;
use App\TrabajoVehiculo;

class AdministradorNotificaciones
{
	

	/**
	 * Obtener notificaciones para mostrar en listado de notificaciones en la navbar.
	 * @return array
	 */
	public static function obtenerNotificaciones()
	{

		$notificaciones = self::obtenerNotificacionesTareasPendientes();

		return $notificaciones;
	}



	/**
	 * Obtener las notificaciones relacionadas a las tareas pendientes.
	 * @return array
	 */
	private static function obtenerNotificacionesTareasPendientes()
	{
		$notifiaciones = [];

		$tareasPendientes = TareaPendiente::aNotificar()
			->with(["chofer", "vehiculo"])
			->orderBy("fecha_a_realizar", "ASC")
			->get();

		foreach($tareasPendientes as $tareaPendiente)
		{

			$notificacion = new Notificacion(
				$tareaPendiente->urlDeEntidad(),
				self::obtenerTextoNotificacionTareaPendiente($tareaPendiente)
			);

			$notificaciones[] = $notificacion;
		}

		return $notificaciones;
	}



	/**
	 * [obtenerTextoNotificacionTareaPendiente description]
	 * @param  [type] $tareaPendiente [description]
	 * @return [type]                 [description]
	 */
	private static function obtenerTextoNotificacionTareaPendiente($tareaPendiente)
	{
		$mensaje = "Se debe ";

		if($tareaPendiente->esDeVehiculo()) 
		{

			if($tareaPendiente->esDeTrabajoVehicular())
			{
				if($tareaPendiente->tipo_trabajo_vehicular == TrabajoVehiculo::SERVICE) {
					$mensaje .= "realizar el service";
				}
				else if($tareaPendiente->tipo_trabajo_vehicular == TrabajoVehiculo::CAMBIO_BUJIAS) {
					$mensaje .= "cambiar las bujías";
				}
				else if($tareaPendiente->tipo_trabajo_vehicular == TrabajoVehiculo::ROTACION_RUEDAS) {
					$mensaje .= "rotar las ruedas";
				}
				else if($tareaPendiente->tipo_trabajo_vehicular == TrabajoVehiculo::CAMBIO_CUBIERTAS) {
					$mensaje .= "cambiar las cubiertas";
				}
				else if($tareaPendiente->tipo_trabajo_vehicular == TrabajoVehiculo::CAMBIO_CORREA_DISTR) {
					$mensaje .= "cambiar la correa de distribución";
				}
			}
			else
			{
				if($tareaPendiente->tipo == TareaPendiente::TIPO_RENOV_VTV) {
					$mensaje .= "renovar la VTV";
				}
				else if($tareaPendiente->tipo == TareaPendiente::TIPO_VERIF_GNC) {
					$mensaje .= "renovar la oblea GNC";
				}
				else if($tareaPendiente->tipo == TareaPendiente::TIPO_RENOV_SEGURO) {
					$mensaje .= "renovar el seguro";
				}
				else if($tareaPendiente->tipo == TareaPendiente::TIPO_ACTUALIZ_KMS) {
					$mensaje .= "actualizar los KMs";
				}
			}


			$mensaje .= " del ".$tareaPendiente->vehiculo->marcaYModelo()." para el ".$tareaPendiente->fecha_a_realizar->isoFormat("D MMM");
		}
		else if($tareaPendiente->esDeChofer())
		{
			
			$mensaje .= "del chofer ".$tareaPendiente->chofer->nombre;

		}

		return $mensaje;
	}



	// TODO: agregar notificaciones alquiler impago


}