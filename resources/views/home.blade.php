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
                            <h3 class="panel-title">Resumen de {{ Carbon\Carbon::today()->isoFormat('MMMM') }}</h3>
                            <p class="panel-subtitle">Período: 1 {{ Carbon\Carbon::today()->isoFormat('MMM Y') }} - {{ Carbon\Carbon::today()->isoFormat('D MMM Y') }}</p>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-handshake-o"></i></span>
                                        <p>
                                            <span class="number">{{ $cantAlquileresEnCurso }}</span>
                                            <span class="title">Alquileres actuales</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-wrench"></i></span>
                                        <p>
                                            <span class="number">{{ $trabajosRealizados }}</span>
                                            <span class="title">Trabajos realizados en vehículos</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-usd"></i></span>
                                        <p>
                                            <span class="number">{{ Strings::formatearMoneda($montoPendientePago, 0) }}</span>
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
                                        <span class="number">{{ Strings::formatearMoneda($reporteBalances['ingreso_total']) }}</span>
                                        <span class="info-label">Ingresos totales</span>
                                    </div>
                                    <div class="weekly-summary text-right">
                                        <span class="number">{{ Strings::formatearMoneda($reporteBalances['gasto_total']) }}</span>
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
                                    <h3 class="panel-title">Próximos trabajos o tareas a realizar</h3>
                                </div>
                                <div class="panel-body">
                                    
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Descripción tarea</th>
                                                <th>Fecha a realizar</th>
                                                <th>Vehículo/Chofer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($proximasTareas as $tareaPendiente)
                                            <tr>
                                                <td>
                                                    @if($tareaPendiente->estaVencida())
                                                    <i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Esta tarea está vencida"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($tareaPendiente->esDeTrabajoVehicular())
                                                        {{ __('tipos_trabajos.'.$tareaPendiente->tipo_trabajo_vehicular) }}
                                                    @elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_RENOV_VTV)
                                                        Renovación de VTV
                                                    @elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_VERIF_GNC)
                                                        Verificación de GNC
                                                    @elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_RENOV_SEGURO)
                                                        Renovación de póliza de seguro
                                                    @elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_RENOV_LICENCIA_CHOFER)
                                                        Renovación de licencia de chofer
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="{{ $tareaPendiente->fecha_a_realizar->isoFormat('D MMM') }}">{{ $tareaPendiente->fecha_a_realizar->diffForHumans() }}</span>
                                                </td>
                                                <td>
                                                    @if($tareaPendiente->vehiculo)
                                                        <a href="{{ route('vehiculos.show', $tareaPendiente->vehiculo->id) }}">{{ $tareaPendiente->vehiculo->marcaModeloYDominio() }}</a>
                                                    @elseif($tareaPendiente->chofer)
                                                        <a href="{{ route('choferes.show', $tareaPendiente->chofer->id) }}">{{ $tareaPendiente->chofer->nombre_y_apellido }}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
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
                                            @foreach($alquileresEnCurso as $alquiler)
                                            <tr>
                                                <td><a href="{{ route('alquileres.show', $alquiler->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
                                                <td>{{ $alquiler->id }}</td>
                                                <td>{{ $alquiler->fecha_inicio->isoFormat('D MMM Y') }}</td>
                                                <td>{{ $alquiler->fecha_fin ? $alquiler->fecha_fin->isoFormat('D MMM Y') : '-' }}</td>
                                                <td>{{ $alquiler->chofer->nombre_y_apellido }}</td>
                                                <td>{{ $alquiler->vehiculo->modeloYDominio() }}</td>
                                                <td>{{ Strings::formatearMoneda($alquiler->precio_diario, 0) }}</td>
                                                <td><span style="@if($alquiler->saldo_actual < 0) color: #B00 @endif">
                                                    {{ Strings::formatearMoneda($alquiler->saldo_actual, 0) }}
                                                </span></td>
                                            </tr>
                                            @endforeach
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
            labels: {!! json_encode(array_keys($reporteBalances['ingresos_diarios'])) !!},
            series: [
                {!! json_encode(array_values($reporteBalances['ingresos_diarios'])) !!},
                {!! json_encode(array_values($reporteBalances['gastos_diarios'])) !!},
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