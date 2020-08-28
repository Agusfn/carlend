<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;

class FiltrosAlquileres extends QueryFilters
{
	
    protected $request;

    public function __construct(Request $request)
    {

    	if(!$request->has("orden"))
    		$request->merge(["orden" => "fecha_inicio_desc"]);


        $this->request = $request;
        parent::__construct($request);
    }


    public function orden($term) 
    {
        
        if($term == "fecha_inicio_desc") {
            $this->builder->orderBy("fecha_inicio", "DESC");
        }
        else if($term == "nombre_chofer_asc") 
        {
            $this->builder
                ->select("alquileres.*") 
                ->leftJoin("choferes", "choferes.id", "=", "alquileres.id_chofer")
                ->orderBy("choferes.nombre_y_apellido", "ASC");
        }
        else if($term == "nombre_vehiculo_asc") 
        {
            $this->builder
                ->select("alquileres.*") 
                ->leftJoin("vehiculos", "vehiculos.id", "=", "alquileres.id_vehiculo")
                ->orderBy("vehiculos.marca", "ASC")
                ->orderBy("vehiculos.modelo", "ASC");
        }
        else if($term == "monto_diario_asc") {
            $this->builder->orderBy("precio_diario", "ASC");
        }
        else if($term == "monto_diario_desc") {
            $this->builder->orderBy("precio_diario", "DESC");
        }
        else if($term == "saldo_asc") {
            $this->builder->orderBy("saldo_actual", "ASC");
        }
        else if($term == "saldo_desc") {
            $this->builder->orderBy("saldo_actual", "DESC");
        }
        else {
            $this->builder->orderBy("fecha_inicio", "DESC");
        }

    }

    public function estado($term) 
    {
        if(in_array($term, ["en_curso", "finalizado"])) {
            $this->builder->where("estado", $term);
        }
    }


    public function vehiculo($term) 
    {  
        if(is_numeric($term)) {
            $this->builder->where("id_vehiculo", $term);
        }
    }




}