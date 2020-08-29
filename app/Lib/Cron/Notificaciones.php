<?php

namespace App\Lib\Cron;

use App\Usuario;
use App\TareaPendiente;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionTareaPendiente;

class Notificaciones
{
		
	/**
	 * Enviar e-mails de notificaciones pendientes de envío.
	 * @return null
	 */
	public static function enviarEmailsPendientes()
	{	

		$emailDestino = Usuario::first()->email;


		$tareasANotificar = TareaPendiente::aNotificar()->where("notificado", false)->get();

		foreach($tareasANotificar as $tareaPendiente)
		{
			Mail::to($emailDestino)->send(new NotificacionTareaPendiente($tareaPendiente));
			$tareaPendiente->marcarNotificada();
		}


	}


}