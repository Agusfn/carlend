<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{

    use SoftDeletes;
       

    const CATEGORIA_CASA_REPUESTOS = "repuestos";
    const CATEGORIA_MECANICO = "mecanico";
    const CATEGORIA_CHAPISTA = "chapista";
    const CATEGORIA_GOMERIA = "gomeria";
    const CATEGORIA_SERVICE = "service";
    const CATEGORIA_CERRAJERO = "cerrajero";
    const CATEGORIA_TECNICO_GAS = "gas";
    const CATEGORIA_ELECTRONICA = "electronica";
    const CATEGORIA_COMPANIA_SEGUROS = "aseguradora";


    public static $nombresCategorias = [
        "repuestos" => "Casa de repuestos",
        "mecanico" => "Mecánico",
        "chapista" => "Chapista",
        "gomeria" => "Gomería",
        "service" => "Lubricentro/service",
        "cerrajero" => "Cerrajero",
        "gas" => "Técnico de gas",
        "electronica" => "Electrónica",
        "aseguradora" => "Compañía de seguros"
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proveedores';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];



    /**
     * Obtener nombre completo de la categoría de este proveedor
     * @return string
     */
    public function nombreCategoria()
    {
        return self::$nombresCategorias[$this->categoria];
    }
    
}
