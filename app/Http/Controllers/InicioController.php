<?php

namespace App\Http\Controllers;

use App\Alquiler;
use App\TareaPendiente;
use App\TrabajoVehiculo;
use App\Lib\Reportes\Balances;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InicioController extends AdminPanelBaseController
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fechaMesDatos = Carbon::today();

        return view('home')->with([

            // Indicadores numericos de arriba
            "cantAlquileresEnCurso" => Alquiler::enCurso()->count(),
            "trabajosRealizados" => TrabajoVehiculo::validos()->pagadoEnMesYAnio($fechaMesDatos->month, $fechaMesDatos->year)->count(),
            "montoPendientePago" => Alquiler::sumaPendienteDePago(),

            // Grafico e indicadores balances.
            "reporteBalances" => Balances::reporteSoloBalanceMensual($fechaMesDatos->month, $fechaMesDatos->year),

            // Trabajos proximos y alquileres actuales
            "proximasTareas" => TareaPendiente::with(["chofer", "vehiculo"])->aNotificar()->fechaARealizarAsc()->limit(10)->get(),
            "alquileresEnCurso" => Alquiler::with(["chofer", "vehiculo"])->enCurso()->get()
        ]);
    }


}
