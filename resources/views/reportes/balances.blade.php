@extends('layouts.main')

@section('title', 'Reporte de balances')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist-custom.css') }}">

    <style type="text/css">
        #balance-chart .ct-series-b .ct-area {
            fill: #df5252;
        }
    </style>
@endsection


@section('content')

					<h3 class="page-title">Reportes / Balances</h3>
	
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
									<h3 class="panel-title">Ingresos y gastos</h3>
								</div>

								<div class="panel-body">

									<div class="row" style="margin-bottom: 20px; text-align: right;">
										<div class="col-xs-6">
											<div class="metric">
												<p>
													<span class="number">{{ App\Lib\Strings::formatearMoneda($datos['resumen_balances']['ingreso_total'], 2) }}</span>
													<span class="title">Ingresos</span>
												</p>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="metric">
												<p>
													<span class="number">{{ App\Lib\Strings::formatearMoneda($datos['resumen_balances']['gasto_total'], 2) }}</span>
													<span class="title">Gastos</span>
												</p>
											</div>
										</div>
									</div>

									<h4 style="margin-top: 0">Ingresos y gastos diarios</h4>
									<div id="balance-chart" class="ct-chart"></div>
									

								</div>
							</div>

						</div>

						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Desglose de gastos</h3>
								</div>

								<div class="panel-body">

									<h4>Gastos según tipo</h4>
									<div id="expenses-by-type-chart" class="ct-chart"></div>


									<h4>Gastos según proveedor</h4>
									<div id="expenses-by-vendor-chart" class="ct-chart"></div>		

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

		// gráfico de balances
		data = {
			labels: {!! json_encode(array_keys($datos['resumen_balances']['ingresos_diarios'])) !!},
			series: [
				{!! json_encode(array_values($datos['resumen_balances']['ingresos_diarios'])) !!},
				{!! json_encode(array_values($datos['resumen_balances']['gastos_diarios'])) !!},
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

		new Chartist.Line('#balance-chart', data, options);


		// gráfico de gastos según tipo
		data = {
			labels: {!! json_encode(array_keys($datos['gastos_segun_tipo'])) !!},
			series: [
				{!! json_encode(array_values($datos['gastos_segun_tipo'])) !!}
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
			axisY: {
			    labelInterpolationFnc: function(value) {
			      return '$'+value;
			    }
			},
		};

		new Chartist.Bar('#expenses-by-type-chart', data, options);


		// gráfico de gastos según proveedor

		data = {
			labels: {!! json_encode(array_keys($datos['gastos_segun_proveedor'])) !!},
			series: [
				{!! json_encode(array_values($datos['gastos_segun_proveedor'])) !!}
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
			axisY: {
			    labelInterpolationFnc: function(value) {
			      return '$'+value;
			    }
			},
		};

		new Chartist.Bar('#expenses-by-vendor-chart', data, options);

	});
	</script>
@endsection