<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Proveedor;

class FiltrosProveedores extends QueryFilters
{
	
    protected $request;

    public function __construct(Request $request)
    {

    	if(!$request->has("orden")) {
    		$request->merge(["orden" => "creado_desc"]);
        }

        $this->request = $request;
        parent::__construct($request);
    }


    public function orden($term) 
    {
    	
    	if($term == "creado_desc") {
    		$this->builder->orderBy("created_at", "DESC");
    	}
    	else if($term == "modif_desc") {
    		$this->builder->orderBy("updated_at", "DESC")->orderBy("created_at", "DESC");
    	}
    	else if($term == "nombre_asc") {
    		$this->builder->orderBy("nombre", "ASC");
    	}
    	else if($term == "nombre_desc") {
    		$this->builder->orderBy("nombre", "DESC");
    	}

    }

    public function categoria($term) 
    { 
        if(in_array($term, array_keys(Proveedor::$nombresCategorias))) {
            $this->builder->where("categoria", $term);
        }
    }


}