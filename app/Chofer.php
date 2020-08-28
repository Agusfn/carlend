<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;
use App\TareaPendiente;

class Chofer extends Model
{
    use SoftDeletes, Filterable;
    
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
     * Obtener alquiler actual del chofer.
     * @return App\Alquiler|null
     */
    public function alquilerActual()
    {
        return $this->belongsTo("App\Alquiler", "id_alquiler_actual");
    }    

    /**
     * Obtener los alquileres de este chofer
     * @return [type] [description]
     */
    public function alquileres()
    {
        return $this->hasMany("App\Alquiler", "id_chofer");
    }



    /**
     * Obtener las tareas pendientes (notificaciones) relacionadas a este chofer
     * @return [type] [description]
     */
    public function tareasPendientes()
    {
        return $this->hasMany("App\TareaPendiente", "id_chofer");
    }


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


    /**
     * Si el chofer está alcuilando un vehiculo actualmente o no.
     * @return bool
     */
    public function estaAlquilando()
    {
        return $this->id_alquiler_actual ? true : false;
    }


    /**
     * Registrar las tareas pendientes (notificaciones) del vencimiento de la licencia del chofer. Sólo cuando se da de alta el chofer.
     * @return null
     */
    public function registrarNotifDeVtoLicencia()
    { 
        if($this->fecha_vto_licencia) { 
            TareaPendiente::crear(null, $this->id, $this->fecha_vto_licencia, TareaPendiente::TIPO_RENOV_LICENCIA_CHOFER, null, null);
        }
    }



    /**
     * Actualizar las tareas pendientes (notificaciones) del vto del registro del chofer.
     * Sólo se llama cuando se modifica la entidad.
     * 
     * @return null
     */
    public function actualizarNotifVtoLicenciaSiCambio()
    {
        
        if($this->wasChanged("fecha_vto_licencia")) 
        {
            $this->tareasPendientes()->where("tipo", TareaPendiente::TIPO_RENOV_LICENCIA_CHOFER)->delete();    
            $this->registrarNotifDeVtoLicencia();
        }
    }

}
