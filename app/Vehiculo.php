<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_vto_vtv',
        'fecha_vto_oblea_gnc'
    ];



    /**
     * Obtener alquiler actual del vehículo.
     * @return App\Alquiler|null
     */
    public function alquilerActual()
    {
        return $this->belongsTo("App\Alquiler", "id_alquiler_actual");
    }    


    /**
     * Obtener el proveedor de seguro actual
     * @return App\Proveedor|null
     */
    public function proveedorSeguro()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor_seguro");
    }    

}
