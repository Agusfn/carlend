<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearGastoAdicional;
use Illuminate\Http\Request;
use App\GastoAdicional;
use App\Vehiculo;
use App\Proveedor;

class GastosAdicionalesController extends AdminPanelBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gastosAdicionales = GastoAdicional::with(["vehiculo", "proveedor"])->orderBy("fecha", "DESC")->get();

        return view("gastos-adicionales.index")->with("gastosAdicionales", $gastosAdicionales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("gastos-adicionales.create")->with([
            "vehiculos" => Vehiculo::nombreAsc()->get(),
            "proveedores" => Proveedor::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearGastoAdicional $request)
    {
        GastoAdicional::create($request->all());

        return redirect()->route("gastos-adicionales.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gastoAdicional = GastoAdicional::with(["vehiculo", "proveedor"])->findOrFail($id);

        return view("gastos-adicionales.show")->with("gastoAdicional", $gastoAdicional);
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
        //
    }
}
