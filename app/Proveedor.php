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
        self::CATEGORIA_CASA_REPUESTOS => "Casa de repuestos",
        self::CATEGORIA_MECANICO => "Mecánico",
        self::CATEGORIA_CHAPISTA => "Chapista",
        self::CATEGORIA_GOMERIA => "Gomería",
        self::CATEGORIA_SERVICE => "Lubricentro/service",
        self::CATEGORIA_CERRAJERO => "Cerrajero",
        self::CATEGORIA_TECNICO_GAS => "Técnico de gas",
        self::CATEGORIA_ELECTRONICA => "Electrónica",
        self::CATEGORIA_COMPANIA_SEGUROS => "Compañía de seguros"
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
     * Trabajos relacionados a este proveedor
     */
    public function trabajosVehiculos()
    {
        return $this->hasMany("App\TrabajoVehiculo", "id_proveedor");
    }


    /**
     * Obtener lista de proveedores que son compañías de seguros.
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function aseguradoras()
    {
        return self::where("categoria", self::CATEGORIA_COMPANIA_SEGUROS)->get();
    }


    /**
     * Query scope para filtrar omitiendo las aseguradoras.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcluirAseguradoras($query)
    {
        return $query->where("categoria", "!=", self::CATEGORIA_COMPANIA_SEGUROS);
    }


    /**
     * Obtener nombre completo de la categoría de este proveedor
     * @return string
     */
    public function nombreCategoria()
    {
        return self::$nombresCategorias[$this->categoria];
    }
    
}
