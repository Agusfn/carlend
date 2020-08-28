<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\TrabajoVehiculo;
use App\Proveedor;
use App\Vehiculo;
use App\Http\Requests\CrearTrabajoVehiculo;
use App\Http\Filters\FiltrosTrabajosVehiculos;



class TrabajosVehiculosController extends AdminPanelBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FiltrosTrabajosVehiculos $filtros)
    {
        
        $trabajos = TrabajoVehiculo::validos()
            ->with(["vehiculo", "proveedor"])
            ->filter($filtros)
            ->paginate(15);
        
        return view("trabajos-vehiculos.index")->with([
            "tiposTrabajos" => TrabajoVehiculo::$tiposTrabajos,
            "vehiculos" => Vehiculo::nombreAsc()->get(),
            "trabajosVehiculos" => $trabajos,
        ]);
        
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
            "proveedores" => Proveedor::excluirAseguradoras()->get() // TODO: alfabeticamente
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

        if(!$request->kms_vehiculo_estimados) 
        {
            $fechaRealizado = Carbon::create($request->fecha_realizado);
            $request->merge(["kms_vehiculo_estimados" => $vehiculo->estimarKilometraje($fechaRealizado)]);
        }

        $trabajo = TrabajoVehiculo::create($request->all());

        $vehiculo->actualizarNotifsDeTrabajo($request->tipo);

        return redirect()->route("trabajos-vehiculos.index");
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
        $request->validate(["observaciones" => "nullable|max:191"]);

        $trabajo = TrabajoVehiculo::findOrFail($id);
        $trabajo->observaciones = $request->observaciones;
        $trabajo->save();

        return redirect()->back()->with("success", true);
    }
}
