@extends('layouts.main')

@section('title', 'Inicio')


@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist-custom.css') }}">

    <style type="text/css">
        #headline-chart .ct-series-b .ct-area {
            fill: #df5252;
        }
    </style>
@endsection


@section('content')

                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Resumen semanal</h3>
                            <p class="panel-subtitle">Período: 29 jun, 2020 - 5 jul, 2020</p>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-handshake-o"></i></span>
                                        <p>
                                            <span class="number">2</span>
                                            <span class="title">Alquileres actuales</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-wrench"></i></span>
                                        <p>
                                            <span class="number">1</span>
                                            <span class="title">Trabajos realizados en vehículos</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-usd"></i></span>
                                        <p>
                                            <span class="number">$3.520</span>
                                            <span class="title">Pendiente de pago de choferes</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <h4 style="margin: 0 0 20px">Ingresos y gastos</h4>

                            <div class="row">
                                <div class="col-md-9">
                                    <div id="headline-chart" class="ct-chart"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="weekly-summary text-right">
                                        <span class="number">$23.000</span>
                                        <span class="info-label">Ingresos totales</span>
                                    </div>
                                    <div class="weekly-summary text-right">
                                        <span class="number">$9.000</span>
                                        <span class="info-label">Gastos totales</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END OVERVIEW -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- RECENT PURCHASES -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Trabajos sobre vehículos próximos estimados</h3>
                                </div>
                                <div class="panel-body">
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Fecha estimada</th>
                                                <th>Vehículo</th>
                                                <th>Kms estimados</th>
                                                <th>Trabajo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>20 jul 2020</td>
                                                <td>Renault Fluence (MKA 451)</td>
                                                <td>148.000</td>
                                                <td>Service</td>
                                            </tr>
                                            <tr>
                                                <td>15 oct 2020</td>
                                                <td>Renault Fluence (MKA 451)</td>
                                                <td>182.500</td>
                                                <td>Cambio de cubiertas</td>
                                            </tr>
                                            <tr>
                                                <td>5 nov 2020</td>
                                                <td>Renault Fluence (MKA 451)</td>
                                                <td>195.000</td>
                                                <td>Cambio correa de distribución</td>
                                            </tr>
                                            <tr>
                                                <td>15 ene 2021</td>
                                                <td>Renault Fluence (MKA 451)</td>
                                                <td>-</td>
                                                <td>VTV</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!-- END RECENT PURCHASES -->
                        </div>
                        <div class="col-md-6">
                            <!-- MULTI CHARTS -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Alquileres actuales en curso</h3>
                                </div>
                                <div class="panel-body">
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID #</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th>Chofer</th>
                                                <th>Vehículo</th>
                                                <th>Monto diario</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="detalles.html" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
                                                <td>4</td>
                                                <td>1 jul 2020</td>
                                                <td>-</td>
                                                <td>Juan Pérez</td>
                                                <td>Renault Fluence (MKA 451)</td>
                                                <td>$2.000</td>
                                                <td><span style="color: #B00">-$4.200</td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                            <!-- END MULTI CHARTS -->
                        </div>
                    </div>

@endsection


@section('custom-js')
    <script src="{{ asset('assets/vendor/chartist/js/chartist.min.js') }}"></script>
    <script>
    $(function() {
        var data, options;

        // headline charts
        data = {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30],
            series: [
                [2741, 2933, 2416, 2360, 2677, 2219, 2457, 2436, 2549, 2520, 2290, 2737, 2234, 2051, 2147, 2354, 2581, 2795, 2547, 2530, 2653, 2262, 2062, 2248, 2723, 2668, 2970, 2836, 2719],
                [1305, 1155, 1947, 1001, 1349, 1540, 1469, 1420, 1352, 1065, 1116, 1098, 1999, 1485, 1949, 1458, 1512, 1024, 1361, 1365, 1883, 1955, 1624, 1800, 1547, 1796, 1719, 1058, 1294],
            ]
        };

        options = {
            low: 0,
            height: 300,
            showArea: true,
            showLine: false,
            showPoint: false,
            fullWidth: true,
            axisX: {
                showGrid: false
            },
            axisY: {
                labelInterpolationFnc: function(value) {
                  return '$'+value;
                }
            },
            lineSmooth: false,
        };

        new Chartist.Line('#headline-chart', data, options);





        

    });
    </script>
@endsection