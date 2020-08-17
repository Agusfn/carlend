<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alquiler;

class AlquileresController extends AdminPanelBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alquileres = Alquiler::with(["chofer", "vehiculo"])->orderByDesc("id")->get();

        return view("alquileres.index")->with([
            "alquileres" => $alquileres
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("alquileres.create");
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
        
        $alquiler = Alquiler::with(["chofer", "vehiculo"])->findOrFail($id);
        $movimientos = $alquiler->movimientosSaldo()->orderByDesc("id")->get();

        return view("alquileres.show")->with([
            "alquiler" => $alquiler,
            "ingresos" => $alquiler->calcularIngresosTotales(),
            "movimientosSaldo" => $movimientos,

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
        //
    }


    /**
     * Mostrar formulario para registrar nuevo pago
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formularioRegistrarPago()
    {
        return view("alquileres.registrar-pago");
    }


    /**
     * Registrar nuevo pago a un alquiler
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrarPago(Request $request)
    {
        //
    }



}
