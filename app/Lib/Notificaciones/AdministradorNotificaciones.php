<?php

namespace App\Lib\Notificaciones;

use App\Alquiler;
use App\Vehiculo;
use App\TareaPendiente;
use App\TrabajoVehiculo;
use App\Lib\Strings;

class AdministradorNotificaciones
{
	

	/**
	 * Obtener notificaciones para mostrar en listado de notificaciones en la navbar.
	 * @return array
	 */
	public static function obtenerNotificaciones()
	{

		$notificaciones = array_merge(
			self::obtenerNotificacionesDeIngresoDeKilometraje(),
			self::obtenerNotificacionesDeTareasPendientes(),
			self::obtenerNotificacionesDeAlquileresImpagos()
		);

		return $notificaciones;
	}



	/**
	 * Obtener las notificaciones relacionadas a las tareas pendientes.
	 * @return array
	 */
	private static function obtenerNotificacionesDeTareasPendientes()
	{
		$notificaciones = [];

		$tareasPendientes = TareaPendiente::aNotificar()
			->with(["chofer", "vehiculo"])
			->orderBy("fecha_a_realizar", "ASC")
			->get();

		foreach($tareasPendientes as $tareaPendiente)
		{

			$notificacion = new Notificacion(
				$tareaPendiente->esDeTrabajoVehicular() ? "fa fa-wrench" : "fa fa-calendar",
				"#000",
				$tareaPendiente->urlDeEntidad(),
				self::obtenerTextoNotificacionTareaPendiente($tareaPendiente)
			);

			$notificaciones[] = $notificacion;
		}

		return $notificaciones;
	}



	/**
	 * Obtenemos el texto de la notificación de acuerdo al tipo de tarea pendiente.
	 * @param  App\TareaPendiente $tareaPendiente
	 * @return string
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




	/**
	 * Obtener las notificaciones de aquellos vehiculos que están en su fecha de ingreso de kilometraje y se debe ingresar.
	 * @return array
	 */
	private static function obtenerNotificacionesDeIngresoDeKilometraje()
	{
		$notificaciones = [];

		$vehiculos = Vehiculo::where("en_fecha_registro_kms", true)->get();

		foreach ($vehiculos as $vehiculo) {
			
			$notificaciones[] = new Notificacion(
				"fa fa-tachometer",
				"#000",
				route("vehiculos.show", $vehiculo->id),
				"Se debe ingresar el kilometraje del ".$vehiculo->marcaModeloYDominio()
			);

		}

		return $notificaciones;
	}



	/**
	 * Obtenemos notificaciones de alquileres en curso que tengan un saldo negativo mayor al umbral.
	 * @return array
	 */
	private static function obtenerNotificacionesDeAlquileresImpagos()
	{
		$notificaciones = [];

		$alquileres = Alquiler::with("vehiculo")->enCurso()->where("saldo_actual", "<", -5000)->get();


		foreach ($alquileres as $alquiler) {
			
			$notificaciones[] = new Notificacion(
				"fa fa-usd",
				"#000",
				route("alquileres.show", $alquiler->id),
				"El alquiler del ".$alquiler->vehiculo->marcaYModelo()." tiene un saldo negativo de ".Strings::formatearMoneda($alquiler->saldo_actual, 0)
			);

		}

		return $notificaciones;
	}


}