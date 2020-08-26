<?php

namespace App\Lib;

use Illuminate\Database\Eloquent\Model;

class Strings
{
    
    /**
     * Formatear numero entero a un formato agradable
     * @param int $numero
     * @return string
     */
	public static function formatearEntero($numero)
	{
		return number_format($numero, 0, ",", ".");
	}


    // TODO: eliminar ceros si no tiene decimal, signo pesos a la derecha del menos, si es negativo

    /**
     * Formatear moneda a formato legible prolijo, con numero de decimales variable.
     * @param float $numero
     * @param int $decimales
     * @return string
     */
	public static function formatearMoneda($numero, $decimales = 0)
	{
		return "$".number_format($numero, $decimales, ",", ".");
	}



}
