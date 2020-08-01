<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastoAdicional extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gastos_adicionales';

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
        'fecha',
    ];

    
}
