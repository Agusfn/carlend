<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Vehiculo;
use App\Proveedor;
use Carbon\Carbon;
use App\Http\Requests\CrearVehiculo;
use App\Http\Requests\EditarVehiculo;


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
        $proveedoresSeguro = Proveedor::aseguradoras();

        return view("vehiculos.create")->with([
            "proveedoresSeguro" => $proveedoresSeguro
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearVehiculo $request)
    {
        
        // crear vehiculo
        $vehiculo = new Vehiculo();

        $vehiculo->fill($request->except([
            "kilometraje_actual",
            "kms_ult_service",
            "kms_ult_cambio_bujias",
            "kms_ult_rotacion_cubiertas",
            "kms_ult_cambio_cubiertas",
            "kms_ult_cambio_correa_distr",
            "debito_seguro", // checkboxes
            "debito_patentes"
        ]));

        $vehiculo->kilometraje_prediccion_actual = $request->kilometraje_actual;

        $vehiculo->save();


        // crear los trabajos vehiculo iniciales




        return redirect()->route("vehiculos.index");
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
    public function update(EditarVehiculo $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $vehiculo->fill($request->except([
            "debito_seguro", // checkboxes
            "debito_patentes"
        ]));

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
