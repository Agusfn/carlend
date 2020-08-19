<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chofer extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'choferes';

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
        'fecha_vto_licencia',
    ];


    /**
     * Choferes que no estén alquilando un vehículo actualmente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponibles($query)
    {
        return $query->where("id_alquiler_actual", null);
    }


    /**
     * Vincular a este chofer un alquiler actual.
     * @param  int|null $idAlquiler
     * @return null
     */
    public function asignarAlquilerActual($idAlquiler)
    {
        $this->id_alquiler_actual = $idAlquiler;
        $this->save();
    }


}
