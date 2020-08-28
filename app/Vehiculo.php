<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Lib\Vehiculos\RegistraKilometraje;
use App\ActualizacionKmVehiculo;
use App\TrabajoVehiculo;
use App\Http\Filters\Filterable;


class Vehiculo extends Model
{
    use SoftDeletes, RegistraKilometraje, Filterable;
    


    /**
     * Cada cuántos días se debe actualizar el kilometraje del auto a partir del primer ingreso.
     */
    const DIAS_ENTRE_CADA_ACTUALIZ_KMS = 14;

    /**
     * Dias mas/menos de tolerancia respecto de la fecha programada en el que se puede hacer el ingreso de KMs
     */
    const DIAS_TOLERANCIA_INGRESO_KMS = 3;


    /**
     * Variables de arriba pero en segundos. (no cambiar)
     */
    const SEGS_ENTRE_CADA_ACTUALIZ_KMS = self::DIAS_ENTRE_CADA_ACTUALIZ_KMS * 24 * 60 * 60;
    const SEGS_TOLERANCIA_INGRESO_KMS = self::DIAS_TOLERANCIA_INGRESO_KMS * 24 * 60 * 60;

    


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
        'fecha_vto_oblea_gnc',
        'fecha_vto_poliza_seguro'
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



    /**
     * Obtener las actualizaciones de Kms del vehiculo.
     */
    public function actualizacionesKms()
    {
        return $this->hasMany("App\ActualizacionKmVehiculo", "id_vehiculo");
    }


    /**
     * Obtener los trabajos de este vehículo
     */
    public function trabajos()
    {
        return $this->hasMany("App\TrabajoVehiculo", "id_vehiculo");
    }


    /**
     * Obtener las tareas pendientes (notificaciones) relacionadas a este vehículo
     * @return [type] [description]
     */
    public function tareasPendientes()
    {
        return $this->hasMany("App\TareaPendiente", "id_vehiculo")->orderBy("fecha_a_realizar", "ASC");
    }


    /**
     * Obtener los alquileres de este vehículo
     * @return [type] [description]
     */
    public function alquileres()
    {
        return $this->hasMany("App\Alquiler", "id_vehiculo");
    }



    /**
     * Ordenar por nombre de marca y modelo ascendiente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNombreAsc($query)
    {
        return $query->orderBy("marca", "ASC")->orderBy("modelo", "ASC");
    }

    
    /**
     * Vehiculos que no estén siendo alquilados actualmente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponibles($query)
    {
        return $query->where("id_alquiler_actual", null);
    }

    /**
     * Obtener todos los vehiculos que tienen algún débito automático (seguro o patentes) asociado. 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConAlgunDebitoAutomatico($query)
    {
        return $query->whereNotNull("costo_mensual_imp_automotor")
            ->orWhereNotNull("costo_mensual_seguro");
    }


    /**
     * Obtener query builder de trabajos previos (o iniciales) de vehiculo.
     * @return [type] [description]
     */
    public function trabajosPrevios()
    {
        return $this->trabajos()->where("es_trabajo_previo", true);
    }


    /**
     * Si el vehiculo tiene registrado el débito automático de pago de patentes
     * @return bool
     */
    public function tieneDebitoAutomPatentes()
    {
        return ($this->costo_mensual_imp_automotor && $this->dia_del_mes_debito_imp_automotor);
    } 

    /**
     * Si el vehiculo tiene registrado el debito automático del pago de seguro
     * @return bool
     */
    public function tieneDebitoAutomSeguro()
    {
        return $this->id_proveedor_seguro ? true : false;
    }   


    /**
     * Obtener marca, modelo y dominio. Ej: Ford Focus (MMH 997)
     * @return string
     */
    public function marcaModeloYDominio()
    {
        return $this->marca." ".$this->modelo." (".$this->dominio.")";
    }


    /**
     * Obtener marca y modelo. Ej: Ford Focus
     * @return string
     */
    public function marcaYModelo()
    {
        return $this->marca." ".$this->modelo;
    }


    /**
     * Obtener modelo del auto y el dominio. Ej: Gol (MMH 997)
     * @return string
     */
    public function modeloYDominio()
    {
        return $this->modelo." (".$this->dominio.")";
    }


    /**
     * Obtener la frecuencia en kilómetros de un tipo de trabajo para este vehiculo.
     * Se obtiene de un atributo del mismo vehiculo.    
     * @param  string $tipoTrabajo
     * @return int
     */
    public function frecuenciaKmsPorTipoTrabajo($tipoTrabajo)
    {
        return $this->{TrabajoVehiculo::$attrsTrabajosNotificables[$tipoTrabajo]};
    }


    /**
     * Vincular a este vehiculo un alquiler actual.
     * @param  int|null $idAlquiler
     * @return null
     */
    public function asignarAlquilerActual($idAlquiler)
    {
        $this->id_alquiler_actual = $idAlquiler;
        $this->save();
    }


    /**
     * Si el vehículo actualmente está en alquiler.
     * @return bool
     */
    public function estaSiendoAlquilado()
    {
        return $this->id_alquiler_actual ? true : false;
    }


    /**
     * Crear los trabajos iniciales (que necesitan de una reposicion periódica y tienen notificaciones) de este vehiculo.
     * Llamado únicamente se da de alta un vehiculo.
     * @param  int $kmsService
     * @param  int $kmsBujias
     * @param  int $kmsRotacionRuedas
     * @param  int $kmsCambioCubiertas
     * @param  int $kmsCambioCorreaDistr
     * @return null
     */
    public function registrarTrabajosIniciales($kmsService, $kmsBujias, $kmsRotacionRuedas, $kmsCambioCubiertas, $kmsCambioCorreaDistr)
    {
        $this->registrarTrabajoPrevio($kmsService, TrabajoVehiculo::SERVICE);
        $this->registrarTrabajoPrevio($kmsBujias, TrabajoVehiculo::CAMBIO_BUJIAS);
        $this->registrarTrabajoPrevio($kmsRotacionRuedas, TrabajoVehiculo::ROTACION_RUEDAS);
        $this->registrarTrabajoPrevio($kmsCambioCubiertas, TrabajoVehiculo::CAMBIO_CUBIERTAS);
        $this->registrarTrabajoPrevio($kmsCambioCorreaDistr, TrabajoVehiculo::CAMBIO_CORREA_DISTR);
    }


    /**
     * Registrar un trabajo previo sobre un vehiculo (solo se usa para trabajos notificables)
     * @param  int $kilometraje
     * @param  string $tipoTrabajo
     * @return null
     */
    public function registrarTrabajoPrevio($kilometraje, $tipoTrabajo)
    {
        TrabajoVehiculo::create([
            "es_trabajo_previo" => true,
            "id_vehiculo" => $this->id,
            "kms_vehiculo_estimados" => $kilometraje,
            "tipo" => $tipoTrabajo,
            "costo_total" => 0,
            "medio_pago" => "n/a"
        ]);

        // No actualizamos las tareas (notificaciones) de este trabajo porque necesitamos estimar la fecha del prox kilometraje, y el trabajo previo se registra
        // cuando se da de alta un vehiculo, y no se puede estimar cuándo será el próximo sin otro ingreso de kilometraje.
    }


    /**
     * Actualizar las tareas pendientes (notifs) de los trabajos notificables sólo de aquellos atributos de frecuencia que fueron modificados.
     * @return null
     */
    public function actualizarNotifsTrabajosSiCambiaronFrecuencias()
    {
        foreach(TrabajoVehiculo::$attrsTrabajosNotificables as $tipoTrabajo => $attrFrecuenciaTrabajo)
        {
            if($this->wasChanged($attrFrecuenciaTrabajo)) 
            {
                $this->actualizarNotifsDeTrabajo($tipoTrabajo);
            }
        }
    }


    /**
     * Actualizar las tareas pendientes (notificaciones) de los tipos de trabajo notificables (los trabajos programados por kilometraje)
     * @return null
     */
    public function actualizarNotifsDeTodosLosTrabajos()
    {
        $this->actualizarNotifsDeTrabajo(TrabajoVehiculo::SERVICE);
        $this->actualizarNotifsDeTrabajo(TrabajoVehiculo::CAMBIO_BUJIAS);
        $this->actualizarNotifsDeTrabajo(TrabajoVehiculo::ROTACION_RUEDAS);
        $this->actualizarNotifsDeTrabajo(TrabajoVehiculo::CAMBIO_CUBIERTAS);
        $this->actualizarNotifsDeTrabajo(TrabajoVehiculo::CAMBIO_CORREA_DISTR);
    }


    /**
     * Actualizar las tareas (notificaciones) de un tipo de trabajo sobre este vehiculo
     * Elimina notificación anterior y crea una nueva con la fecha estimada a realizar actualizada.
     * 
     * @param  string $tipoTrabajo
     * @return null
     */
    public function actualizarNotifsDeTrabajo($tipoTrabajo)
    {

        $this->tareasPendientes()->deTrabajoVehicular($tipoTrabajo)->delete();


        if(!TrabajoVehiculo::esTrabajoNotificable($tipoTrabajo))
            return;

        if(!$frecuenciaKms = $this->frecuenciaKmsPorTipoTrabajo($tipoTrabajo))
            return;

        if(!$this->puedeEstimarKilometraje())
            return;


        $ultimoTrabajo = $this->trabajos()->where("tipo", $tipoTrabajo)->get()->last();

        $kmsProxTrabajo = $ultimoTrabajo->kms_vehiculo_estimados + $frecuenciaKms;
        
        $fechaProxTrabajo = $this->estimarFechaDesdeKilometraje($kmsProxTrabajo);

        TareaPendiente::crear(
            $this->id,
            null,
            $fechaProxTrabajo,
            TareaPendiente::TIPO_TRABAJO_VEHICULAR,
            $tipoTrabajo,
            $kmsProxTrabajo,
        );
        
    }



    /**
     * Registrar las tareas pendientes (notificaciones) de los vencimientos con fecha de este vehiculo (vtv, gnc, y seguro) si están configurados
     * Se realiza sólo al dar el alta el vehiculo, luego se debe usar al editar el vehiculo actualizarNotifsVtosSiCambiaronFechas()
     * @return null
     */
    public function registrarNotifsDeVencimientos()
    { 
        
        if($this->fecha_vto_vtv) { 
            TareaPendiente::crear($this->id, null, $this->fecha_vto_vtv, TareaPendiente::TIPO_RENOV_VTV, null, null);
        }

        if($this->fecha_vto_oblea_gnc) {
            TareaPendiente::crear($this->id, null, $this->fecha_vto_oblea_gnc, TareaPendiente::TIPO_VERIF_GNC, null, null);
        }

        if($this->fecha_vto_poliza_seguro) {
            TareaPendiente::crear($this->id, null, $this->fecha_vto_poliza_seguro, TareaPendiente::TIPO_RENOV_SEGURO, null, null);
        }
    }


    /**
     * Actualizar las tareas pendientes (notificaciones) de los vencimientos de este vehiculo (vtv, gnc, y seguro) si están configurados
     * Se actualizan SOLO si se modificaron estos valores desde que se cargó el modelo, de manera que quede intacta la notificacion si no se modifica 
     * (sino habria que actualizar todo siempre y se perdería el información de si fue enviada la notif por email)
     * 
     * @return null
     */
    public function actualizarNotifsVtosSiCambiaronFechas()
    {
        
        if($this->wasChanged("fecha_vto_vtv")) 
        {
            $this->tareasPendientes()->where("tipo", TareaPendiente::TIPO_RENOV_VTV)->delete();    
            
            if($this->fecha_vto_vtv) { 
                TareaPendiente::crear($this->id, null, $this->fecha_vto_vtv, TareaPendiente::TIPO_RENOV_VTV, null, null);
            }
        }

        if($this->wasChanged("fecha_vto_oblea_gnc")) 
        {
            $this->tareasPendientes()->where("tipo", TareaPendiente::TIPO_VERIF_GNC)->delete();

            if($this->fecha_vto_oblea_gnc) {
                TareaPendiente::crear($this->id, null, $this->fecha_vto_oblea_gnc, TareaPendiente::TIPO_VERIF_GNC, null, null);
            }
        }

        if($this->wasChanged("fecha_vto_poliza_seguro")) 
        {
            $this->tareasPendientes()->where("tipo", TareaPendiente::TIPO_RENOV_SEGURO)->delete();

            if($this->fecha_vto_poliza_seguro) {
                TareaPendiente::crear($this->id, null, $this->fecha_vto_poliza_seguro, TareaPendiente::TIPO_RENOV_SEGURO, null, null);
            }
        }

    }

}
