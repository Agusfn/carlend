<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Proveedor;

class ProveedoresController extends AdminPanelBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::all();

        return view("proveedores.index")->with("proveedores", $proveedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("proveedores.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "direccion" => "",
            "telefono" => "",
            "categoria" => [
                "required",
                Rule::in(array_keys(Proveedor::$nombresCategorias))
            ]
        ]);

        Proveedor::create($request->all());

        return redirect()->route("proveedores.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view("proveedores.show")->with("proveedor", $proveedor);
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
            "nombre" => "required",
            "direccion" => "",
            "telefono" => "",
            "categoria" => [
                "required",
                Rule::in(array_keys(Proveedor::$nombresCategorias))
            ]
        ]);

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->fill($request->all());
        $proveedor->save();

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
        $proveedor = Proveedor::findOrFail($id);
        
        $proveedor->delete();

        return redirect()->route("proveedores.index");
    }
}
