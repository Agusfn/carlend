<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;

class FiltrosChoferes extends QueryFilters
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
    	else if($term == "nombre_asc") {
    		$this->builder->orderBy("nombre_y_apellido", "ASC");
    	}
    	else if($term == "nombre_desc") {
    		$this->builder->orderBy("nombre_y_apellido", "DESC");
    	}
        else {
            $this->builder->orderBy("created_at", "DESC");
        }

    }



}