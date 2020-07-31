<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends AdminPanelBaseController
{

    /**
     * Mostrar página de reportes de balances.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarBalances()
    {
        return view("reportes.balances");
    }

    /**
     * Mostrar página de reportes de vehiculos.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarVehiculos()
    {
        return view("reportes.vehiculos");
    }


    /**
     * Mostrar página de reportes de choferes.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarChoferes()
    {
        return view("reportes.choferes");
    }        

}
