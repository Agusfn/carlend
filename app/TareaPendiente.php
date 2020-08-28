<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TrabajoVehiculo;
use Carbon\Carbon;

class TareaPendiente extends Model
{
	
    const TIPO_RENOV_LICENCIA_CHOFER = "renov_licencia_chofer";
    const TIPO_TRABAJO_VEHICULAR = "trabajo_veh_programado";
    const TIPO_RENOV_VTV = "renov_vtv";
    const TIPO_VERIF_GNC = "verif_gnc";
    const TIPO_RENOV_SEGURO = "renovacion_seguro";


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tareas_pendientes';

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
        'fecha_a_realizar',
        'fecha_a_notificar'
    ];


    /**
     * Crear una nueva tarea pendiente o notificación.
     * @param  int $idVehiculo
     * @param  int $idChofer
     * @param  Carbon\Carbon $fechaARealizar
     * @param  string $tipoTarea
     * @param  string $tipoTrabajo
     * @param  int|null $kmEstimado
     * @return App\Tarea
     */
    public static function crear($idVehiculo, $idChofer, $fechaARealizar, $tipoTarea, $tipoTrabajo, $kmEstimado)
    {
        $tarea = self::create([
            "id_vehiculo" => $idVehiculo,
            "id_chofer" => $idChofer,
            "fecha_a_realizar" => $fechaARealizar,
            "tipo" => $tipoTarea,
            "tipo_trabajo_vehicular" => $tipoTrabajo,
            "kilometraje_estimado" => $kmEstimado,
            "fecha_a_notificar" => self::obtenerFechaNotificacion($fechaARealizar, $tipoTarea, $tipoTrabajo)
        ]);

        return $tarea;
    }



    /**
     * Devuelve la fecha con la anticipación con la cual se notifica cada tipo de tarea, algunas se deben notificar
     * con más anticipación que otras.
     * @param  Carbon\Carbon $fechaARealizar
     * @param  string $tipoTarea
     * @param  string $tipoTrabajo
     * @return Carbon\Carbon
     */
    public static function obtenerFechaNotificacion($fechaARealizar, $tipoTarea, $tipoTrabajo = null)
    {
        $diasAnticipacion = 10;

        // fechas exactas de vencimientos
        if($tipoTarea == self::TIPO_RENOV_LICENCIA_CHOFER || $tipoTarea == self::TIPO_RENOV_VTV || 
            $tipoTarea == self::TIPO_VERIF_GNC || $tipoTarea == self::TIPO_RENOV_SEGURO) 
        {
            $diasAnticipacion = 10;
        }
        else if($tipoTarea == self::TIPO_TRABAJO_VEHICULAR) // fechas aproximadas por desgaste, mejor avisar con mas anticipacion
        {
            if($tipoTrabajo == TrabajoVehiculo::CAMBIO_CORREA_DISTR) {
                $diasAnticipacion = 20;
            }
            else if($tipoTrabajo == TrabajoVehiculo::CAMBIO_CUBIERTAS) {
                $diasAnticipacion = 15;
            }
            else {
                $diasAnticipacion = 10;
            }
        }

        return $fechaARealizar->copy()->subDays($diasAnticipacion);
    }



    /**
     * Obtener chofer relacionado a esta tarea.
     * @return App\Chofer|null
     */
    public function chofer()
    {
        return $this->belongsTo("App\Chofer", "id_chofer");
    }    


    /**
     * Obtener vehiculo relacionado a esta tarea
     * @return App\Vehiculo|null
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo");
    }    


    /**
     * Tareas pendientes cuya fecha de notificación ya pasó (y ya se deben notificar)
     * Recordar que si la tarea existe, entonces está pendiente, las terminadas se borran.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeANotificar($query)
    {
        return $query->where("fecha_a_notificar", "<=", date("Y-m-d"));
    }


    /**
     * Crear query scope para filtrar por tipo de trabajo vehicular dado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeTrabajoVehicular($query, $tipoTrabajo)
    {
        return $query->where("tipo", self::TIPO_TRABAJO_VEHICULAR)
            ->where("tipo_trabajo_vehicular", $tipoTrabajo);
    }


    /**
     * Crear query scope para filtrar por tareas relacionadas a vencimientos con fecha, de vehiculo. (vtv, gnc y seguro)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeVencimientoVehicular($query)
    {
        return $query->whereIn("tipo", [self::TIPO_RENOV_VTV, self::TIPO_VERIF_GNC, self::TIPO_RENOV_SEGURO]);
    }


    /**
     * Crear query scope para filtrar por tareas relacionadas a vencimientos con fecha, de vehiculo. (vtv, gnc y seguro)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaARealizarAsc($query)
    {
        return $query->orderBy("fecha_a_realizar", "ASC");
    }


    /**
     * Si esta tarea es de un vehiculo.
     * @return bool
     */
    public function esDeVehiculo()
    {
        return $this->id_vehiculo ? true : false;
    }


    /**
     * Si esta tarea es de un chofer
     * @return bool
     */
    public function esDeChofer()
    {
        return $this->id_chofer ? true : false;
    }


    /**
     * Si la tarea es de un trabajo programado en kms de vehiculo.
     * @return bool
     */
    public function esDeTrabajoVehicular()
    {
        return $this->tipo == self::TIPO_TRABAJO_VEHICULAR;
    }


    /**
     * La URL relacionada a la tarea pendiente: puede ser relacionada a un chofer o a un vehiculo.
     * @return string
     */
    public function urlDeEntidad()
    {
        if($this->id_vehiculo) {
            return route("vehiculos.show", $this->id_vehiculo);
        }
        else if($this->id_chofer) {
            return route("choferes.show", $this->id_chofer);
        }
    }


    /**
     * Si la tarea está en período de notificacion, pero antes que pase.
     * @return bool
     */
    public function enPeriodoDeNotificacion()
    {
        $today = Carbon::today();
        
         return ($this->fecha_a_notificar->lessThanOrEqualTo($today) &&
            $this->fecha_a_realizar->greaterThanOrEqualTo($today));
    }


    /**
     * Si la tarea ya pasó su fecha de realización.
     * @return bool
     */
    public function estaVencida()
    {
        return $this->fecha_a_realizar->isPast();
    }


    /**
     * Marcar tarea como notificada.
     * @return null
     */
    public function marcarNotificada()
    {
        $this->notificado = true;
        $this->save();
    }


}
