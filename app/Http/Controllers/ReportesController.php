<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Reportes\Balances;
use App\Lib\Reportes\Choferes;
use App\Lib\Reportes\Vehiculos;
use App\Lib\Reportes\UtilidadesReportes;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;


class ReportesController extends AdminPanelBaseController
{

    /**
     * Fecha en formato Carbon
     * @var Carbon
     */
    private $fechaMesReporte;


    public function __construct(Request $request)
    {
        parent::__construct();

        $mesesPosibles = UtilidadesReportes::obtenerMesesDeDatosDisponibles();
        
        if($request->has("mes") && strtotime($request->mes))
            $this->fechaMesReporte = Carbon::create($request->mes);
        else
            $this->fechaMesReporte = $mesesPosibles[0];

        View::share([
            "mesesDeDatos" => $mesesPosibles,
            "mesReportado" => $this->fechaMesReporte->format("Y-m")
        ]);
    }


    /**
     * Mostrar página de reportes de balances.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarBalances()
    {
        return view("reportes.balances")->with([
            "datos" => Balances::generarReporte($this->fechaMesReporte->month, $this->fechaMesReporte->year)
        ]);
    }

    /**
     * Mostrar página de reportes de vehiculos.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarVehiculos()
    {
        return view("reportes.vehiculos")->with([
            "datos" => Vehiculos::generarReporte($this->fechaMesReporte->month, $this->fechaMesReporte->year)
        ]);
    }


    /**
     * Mostrar página de reportes de choferes.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarChoferes()
    {
        return view("reportes.choferes")->with([
            "datos" => Choferes::generarReporte($this->fechaMesReporte->month, $this->fechaMesReporte->year)
        ]);
    }        

}
