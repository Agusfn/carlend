<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends AdminPanelBaseController
{


    /**
     * Mostrar formulario para editar datos de cuenta.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalles()
    {
        return view("cuenta.detalles");
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modificar(Request $request)
    {
    }


    /**
     * Mostrar formulario para editar password.
     *
     * @return \Illuminate\Http\Response
     */
    public function formularioPassword()
    {
        return view("cuenta.cambiar-password");
    }        


    /**
     * [formularioPassword description]
     * @return \Illuminate\Http\Response
     */
    public function cambiarPassword(Request $request)
    {
    }  

}
