<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CrearAlquiler;
use App\Alquiler;
use App\Chofer;
use App\Vehiculo;
use Carbon\Carbon;

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

        return view("alquileres.create")->with([
            "choferesDisponibles" => Chofer::disponibles()->get(),
            "vehiculosDisponibles" => Vehiculo::disponibles()->get(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearAlquiler $request)
    {

        
        $alquiler = new Alquiler();

        $alquiler->fill($request->except([
            "alquiler_indefinido",
            "descuento_semanal"
        ]));

        $alquiler->fill([
            "estado" => Alquiler::ESTADO_EN_CURSO,
            "fecha_inicio" => Carbon::today(),
            "saldo_actual" => 0, // default 0, borrar cuando se aplique migration
            "descuento_semanal" => $request->has("descuento_semanal")
        ]);

        $alquiler->save();


        $chofer = Chofer::findOrFail($request->id_chofer);
        $chofer->asignarAlquilerActual($alquiler->id);

        $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
        $vehiculo->asignarAlquilerActual($alquiler->id);


        return redirect()->route("alquileres.index");
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
     * Terminar el alquiler
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function terminar(Request $request, $id)
    {
        
        $alquiler = Alquiler::findOrFail($id);

        if($alquiler->estaEnCurso()) {
            $alquiler->terminar();
        }

        return redirect()->route("alquileres.show", $alquiler->id);
    }



    /**
     * Mostrar formulario para registrar nuevo pago
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formularioRegistrarPago(Request $request, $id)
    {
        $alquiler = Alquiler::findOrFail($id);

        return view("alquileres.registrar-pago")->with("alquiler", $alquiler);
    }


    /**
     * Registrar nuevo pago a un alquiler
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrarPago(Request $request)
    {
        
        $request->validate([
            "fecha" => "required|date_format:d/m/Y|after_or_equal:-7day|before_or_equal:today",
            "tipo" => "",
            "monto" => "",
            "medio_pago" => "",
            "comentario" => ""
        ]);

        dd($request);
    }



}
