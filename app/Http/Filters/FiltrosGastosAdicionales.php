<?php

namespace App\Http\Filters;


use Illuminate\Http\Request;

class FiltrosGastosAdicionales extends QueryFilters
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
    		$this->builder->ordenReciente();
    	}
    	else if($term == "nombre_veh_asc") 
        {
            $this->builder
                ->select("gastos_adicionales.*") 
                ->leftJoin("vehiculos", "vehiculos.id", "=", "gastos_adicionales.id_vehiculo")
                ->orderBy("vehiculos.marca", "ASC")
                ->orderBy("vehiculos.modelo", "ASC");
    	}
    	else if($term == "monto_asc") {
    		$this->builder->orderBy("monto", "ASC");
    	}
    	else if($term == "monto_desc") {
    		$this->builder->orderBy("monto", "DESC");
    	}
        else if($term == "nombre_prov_asc") 
        {
            $this->builder
                ->select("gastos_adicionales.*") 
                ->leftJoin("proveedores", "proveedores.id", "=", "gastos_adicionales.id_proveedor")
                ->orderBy("proveedores.nombre", "ASC");
        }
        else if($term == "nombre_prov_desc") 
        {
            $this->builder
                ->select("gastos_adicionales.*") 
                ->leftJoin("proveedores", "proveedores.id", "=", "gastos_adicionales.id_proveedor")
                ->orderBy("proveedores.nombre", "DESC");
        }
        else {
            $this->builder->ordenReciente();
        }

    }

    public function medio_pago($term) 
    {
        if(in_array($term, ["efectivo", "tarjeta_credito", "transferencia"])) 
        {
            $this->builder->where("medio_pago", $term);
        }
    }


    public function tipo_gasto($term) 
    {
        if(in_array($term, ["seguro_vehiculo", "impuesto_automotor", "otro"])) 
        {
            $this->builder->where("tipo", $term);
        }
    }    

}