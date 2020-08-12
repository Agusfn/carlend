<?php

namespace App\Lib\Notificaciones;

class Notificacion
{


	public function __construct($url, $texto)
	{
		$this->url = $url;
		$this->texto = $texto;
	}


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