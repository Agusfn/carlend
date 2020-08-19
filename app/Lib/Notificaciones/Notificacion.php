<?php

namespace App\Lib\Notificaciones;

class Notificacion
{


	public function __construct($icono, $colorIcono, $url, $texto)
	{
		$this->icono = $icono;
		$this->colorIcono = $colorIcono;
		$this->url = $url;
		$this->texto = $texto;
	}


	/**
	 * Nombre de clase/s CSS del ícono de font-awesome 4.7.0 a utilizar en la notificacion
	 * @var string
	 */
	public $icono;


	/**
	 * Color del ícono a usar en la notificación en HEX
	 * @var string
	 */
	public $colorIcono;


	/**
	 * URL o ruta relevante de la notificación (cuando se hace click sobre la misma)
	 * @var string
	 */
	public $url;


	/**
	 * Texto de la notificación en la lista de notificaciones.
	 * @var string
	 */
	public $texto;
	
}