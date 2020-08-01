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

}
