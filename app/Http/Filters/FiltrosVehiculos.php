<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;

class FiltrosVehiculos extends QueryFilters
{
	
    protected $request;

    public function __construct(Request $request)
    {

    	if(!$request->has("orden"))
    		$request->merge(["orden" => "fecha_desc"]);


        $this->request = $request;
        parent::__construct($request);
    }


    public function orden($term) 
    {
    	
    	if($term == "fecha_desc") {
    		$this->builder->orderBy("created_at", "DESC");
    	}
    	else if($term == "modif_desc") {
    		$this->builder->orderBy("updated_at", "DESC")->orderBy("created_at", "DESC");
    	}
    	else if($term == "dominio_asc") {
    		$this->builder->orderBy("dominio", "ASC");
    	}
        else if($term == "marca_modelo_asc") {
            $this->builder->nombreAsc();
        }
        else if($term == "anio_asc") {
            $this->builder->orderBy("anio", "ASC");
        }
        else {
            $this->builder->orderBy("created_at", "DESC");
        }
        
    }



}