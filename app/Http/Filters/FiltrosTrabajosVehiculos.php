<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\TrabajoVehiculo;

class FiltrosTrabajosVehiculos extends QueryFilters
{
	
    protected $request;

    public function __construct(Request $request)
    {

    	if(!$request->has("orden"))
    		$request->merge(["orden" => "fecha_pago_desc"]);


        $this->request = $request;
        parent::__construct($request);
    }


    public function orden($term) 
    {
    	
    	if($term == "fecha_pago_desc") {
    		$this->builder->fechaDePagoDesc();
    	}
    	else if($term == "fecha_realizado_desc") {
    		$this->builder->fechaRealizadoDesc();
    	}
    	else if($term == "costo_asc") {
    		$this->builder->orderBy("costo_total", "ASC");
    	}
        else if($term == "costo_desc") {
            $this->builder->orderBy("costo_total", "DESC");
        }
        else {
            $this->builder->fechaDePagoDesc();
        }

    }

    public function medio_pago($term) 
    {
        if(in_array($term, ["efectivo", "tarjeta_credito", "transferencia"])) 
        {
            $this->builder->where("medio_pago", $term);
        }
    }

    public function tipo_trabajo($term) 
    {
        if(in_array($term, TrabajoVehiculo::$tiposTrabajos)) {
            $this->builder->where("tipo", $term);
        }
    }

    public function vehiculo($term) 
    {
            
        if(is_numeric($term)) {
            $this->builder->where("id_vehiculo", $term);
        }
        
    }


}