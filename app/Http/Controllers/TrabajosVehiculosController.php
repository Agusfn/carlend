<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrabajoVehiculo;
use App\Proveedor;
use App\Vehiculo;
use App\Http\Requests\CrearTrabajoVehiculo;


class TrabajosVehiculosController extends AdminPanelBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajos = TrabajoVehiculo::validos()->with(["vehiculo", "proveedor"])->orderByDesc("fecha_pagado")->get();
        
        return view("trabajos-vehiculos.index")->with("trabajosVehiculos", $trabajos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("trabajos-vehiculos.create")->with([
            "vehiculos" => Vehiculo::nombreAsc()->get(),
            "proveedores" => Proveedor::all() // TODO: alfabeticamente
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearTrabajoVehiculo $request)
    {

        $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);

        if(!$request->kms_vehiculo_estimados) {
            $request->kms_vehiculo_estimados = $vehiculo->estimarKilometraje($request->fecha_realizado);
        }

        $trabajo = TrabajoVehiculo::create($request->all());

        // TODO: actualizar notificaciones

        dd($request);
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trabajo = TrabajoVehiculo::with(["vehiculo", "proveedor"])->findOrFail($id);

        return view("trabajos-vehiculos.show")->with("trabajo", $trabajo);
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
