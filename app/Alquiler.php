<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alquileres';

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
        'fecha_inicio',
        'fecha_fin'
    ];



    /**
     * Obtener chofer de este alquiler.
     * @return App\Chofer|null
     */
    public function chofer()
    {
        return $this->belongsTo("App\Chofer", "id_chofer");
    }    


    /**
     * Obtener vehiculo de este alquiler.
     * @return App\Vehiculo|null
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo");
    }    



}
