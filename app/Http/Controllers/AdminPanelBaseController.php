<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Lib\Notificaciones\AdministradorNotificaciones;


class AdminPanelBaseController extends Controller
{
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $notificaciones = AdministradorNotificaciones::obtenerNotificaciones();
        View::share("notificaciones", $notificaciones);
    }

}
