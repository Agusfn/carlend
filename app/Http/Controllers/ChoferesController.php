<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CrearChofer;
use Carbon\Carbon;
use App\Chofer;

class ChoferesController extends AdminPanelBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choferes = Chofer::with("alquilerActual.vehiculo")->get();

        return view("choferes.index")->with(["choferes" => $choferes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("choferes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearChofer $request)
    {
        $chofer = new Chofer();

        $chofer->fill($request->except("fecha_vto_licencia"));

        if($request->fecha_vto_licencia) {
            $chofer->fecha_vto_licencia = Carbon::createFromFormat("d/m/Y", $request->fecha_vto_licencia);
        }    

        $chofer->save();


        return redirect()->route('choferes.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chofer = Chofer::findOrFail($id);
        $ultimosAlquileres = $chofer->alquileres()->with("vehiculo")->fechaDesc()->limit(8)->get();

        return view("choferes.show")->with([
            "chofer" => $chofer,
            "ultimosAlquileres" => $ultimosAlquileres
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CrearChofer $request, $id)
    {
        $chofer = Chofer::findOrFail($id);

        $chofer->fill($request->except("fecha_vto_licencia"));

        if($chofer->fecha_vto_licencia) {
            $chofer->fecha_vto_licencia = Carbon::createFromFormat("d/m/Y", $request->fecha_vto_licencia);
        }        
        
        $chofer->save();

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
        $chofer = Chofer::findOrFail($id);

        $chofer->delete(); // soft delete

        return redirect()->route('choferes.index');
    }
}
