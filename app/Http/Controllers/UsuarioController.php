<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            "name" => "required|string|min:3|max:50|alpha_dash"
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with("success", true);
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
     * Cambiar contraseña del usuario.
     * @return \Illuminate\Http\Response
     */
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            "password_actual" => "required|password",
            "password" => "required|min:7|confirmed"
        ]);

        $user = Auth::user();

        Auth::logoutOtherDevices($request->password_actual);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with("success", true);
    }  

}
