@extends('layouts.main')

@section('title', 'Reporte de choferes')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist-custom.css') }}">
@endsection


@section('content')

					<h3 class="page-title">Reportes / Choferes</h3>
	
					<div class="row" style="margin-bottom: 15px">
						<div class="col-sm-3">
							<h4 style="margin-top: 0">Período</h4>
							<select class="form-control" id="selector-mes-reportes">
								@foreach($mesesDeDatos as $fecha)
								<option value="{{ $fecha->format('Y-m') }}" @if($mesReportado == $fecha->format('Y-m')) selected @endif>{{ $fecha->isoFormat('MMMM Y') }}</option>
								@endforeach
							</select>
						</div>
					</div>	

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Días de alquiler</h3>
								</div>

								<div class="panel-body">

									<div id="rent-days-chart" class="ct-chart"></div>
									
								</div>
							</div>

						</div>

						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Pagos realizados por alquileres</h3>
								</div>

								<div class="panel-body">

									<div id="payments-chart" class="ct-chart"></div>

								</div>
							</div>


						</div>
					</div>



@endsection



@section('custom-js')
	<script src="{{ asset('assets/vendor/chartist/js/chartist.min.js') }}"></script>
	<script>
	$(function() {
		var data, options;

		// gráfico de días de alquiler
		data = {
			labels: {!! json_encode(array_keys($datos['detalle_dias_alquilados'])) !!},
			series: [
			    {!! json_encode(array_values($datos['detalle_dias_alquilados'])) !!}
			]
		};

		options = {
			onlyInteger: true,
			height: 300,
			axisX: {
				showGrid: false
			},
			axisY: {
			    labelInterpolationFnc: function(value) {
			      return value + 'd';
			    }
			}
		};

		new Chartist.Bar('#rent-days-chart', data, options);


		// grafico de total de pagos realizados
		data = {
			labels: {!! json_encode(array_keys($datos['detalle_pagos_de_choferes'])) !!},
			series: [
				{!! json_encode(array_values($datos['detalle_pagos_de_choferes'])) !!}
			]
		};

		options = {
			onlyInteger: true,
			height: 300,
			axisX: {
				showGrid: false
			},
			axisY: {
			    labelInterpolationFnc: function(value) {
			      return '$' + value;
			    }
			}
		};

		new Chartist.Bar('#payments-chart', data, options);


	});
	</script>
@endsection