<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiculo;
use App\Proveedor;
use Carbon\Carbon;

class VehiculosController extends AdminPanelBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Vehiculo::with(["alquilerActual.chofer", "proveedorSeguro"])->get();

        return view("vehiculos.index")->with("vehiculos", $vehiculos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("vehiculos.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $proveedoresSeguro = Proveedor::aseguradoras();

        return view("vehiculos.show")->with([
            "vehiculo" => $vehiculo,
            "proveedoresSeguro" => $proveedoresSeguro
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "dominio" => "required|min:5|max:10",
            "marca" => "required|max:50",
            "modelo" => "required|max:50",
            "anio" => "required|integer|min:1990|max:2025",
            "kms_cada_service" => "nullable|integer",
            "kms_cada_cambio_bujias" => "nullable|integer",
            "kms_cada_rotacion_cubiertas" => "nullable|integer",
            "kms_cada_cambio_cubiertas" => "nullable|integer",
            "kms_cada_cambio_correa_distr" => "nullable|integer",
            "fecha_vto_vtv" => "nullable|date_format:d/m/Y",
            "fecha_vto_oblea_gnc" => "nullable|date_format:d/m/Y",

            "costo_mensual_imp_automotor" => "required_with:debito_patentes",
            "dia_del_mes_debito_imp_automotor" => "required_with:debito_patentes",

            "id_proveedor_seguro" => "required_with:debito_seguro|exists:proveedores,id",
            "fecha_vto_poliza_seguro" => "required_with:debito_seguro|date_format:d/m/Y",
            "costo_mensual_seguro" => "required_with:debito_seguro",
            "dia_del_mes_debito_seguro" => "required_with:debito_seguro|integer|min:1|max:28"
        ]);

        $vehiculo = Vehiculo::findOrFail($id);


        $vehiculo->fill($request->except([
            "debito_seguro",
            "fecha_vto_vtv", 
            "fecha_vto_oblea_gnc", 
            "fecha_vto_poliza_seguro"
        ]));

        if($request->fecha_vto_vtv) {
            $vehiculo->fecha_vto_vtv = Carbon::createFromFormat("d/m/Y", $request->fecha_vto_vtv);
        }

        if($request->fecha_vto_oblea_gnc) {
            $vehiculo->fecha_vto_oblea_gnc = Carbon::createFromFormat("d/m/Y", $request->fecha_vto_oblea_gnc);
        }

        if($request->fecha_vto_poliza_seguro) {
            $vehiculo->fecha_vto_poliza_seguro = Carbon::createFromFormat("d/m/Y", $request->fecha_vto_poliza_seguro);
        }


        if(!$request->has("debito_patentes")) {
            $vehiculo->fill([
                "costo_mensual_imp_automotor" => null,
                "dia_del_mes_debito_imp_automotor" => null
            ]);
        }

        if(!$request->has("debito_seguro")) {
            $vehiculo->fill([
                "id_proveedor_seguro" => null,
                "fecha_vto_poliza_seguro" => null,
                "costo_mensual_seguro" => null,
                "dia_del_mes_debito_seguro" => null
            ]);
        }

        $vehiculo->save();

        return redirect()->back()->with("success", true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
