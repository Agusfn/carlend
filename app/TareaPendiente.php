<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TareaPendiente extends Model
{
	
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

}
