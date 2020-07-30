@extends('layouts.main')

@section('title', 'Reporte de vehículos')


@section('custom-css')
	<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist-custom.css">
@endsection


@section('content')

					<h3 class="page-title">Reportes / Vehículos</h3>
	
					<div class="row" style="margin-bottom: 15px">
						<div class="col-sm-3">
							<h4 style="margin-top: 0">Período</h4>
							<select class="form-control">
								<option>Junio 2020</option>
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

									<div id="balance-chart" class="ct-chart"></div>
									

									<h4>Renault Fluence (MKA 451)</h4>

									<div style="font-size: 16px;"><strong>Ingresos:</strong> $22.500</div>
									<div style="margin-top: 10px">
										<div style="font-size: 16px;margin-bottom: 5px"><strong>Gastos:</strong> $15.000</div>

										<div style="font-size: 14px">Service: $2.500</div>
										<div style="font-size: 14px">Reparacion: $3.500</div>
										<div style="font-size: 14px">Seguro: $6.000</div>
										<div style="font-size: 14px">Patente: $2.000</div>
										<div style="font-size: 14px">Otro gasto: $1.000</div>
									</div>

									<h4 style="margin-top: 30px">Chevrolet Onix (NBX 159)</h4>

									<div style="font-size: 16px;"><strong>Ingresos:</strong> $9.0000</div>
									<div style="margin-top: 10px">
										<div style="font-size: 16px;margin-bottom: 5px"><strong>Gastos:</strong> $5.500</div>

										<div style="font-size: 14px">Service: $1.500</div>
										<div style="font-size: 14px">Reparacion: $1.500</div>
										<div style="font-size: 14px">Seguro: $1.500</div>
										<div style="font-size: 14px">Patente: $1.000</div>
										<div style="font-size: 14px">Otro gasto: $ -</div>
									</div>

								</div>
							</div>

						</div>

						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Tiempo de alquiler</h3>
								</div>

								<div class="panel-body">

									<div id="rent-time-chart" class="ct-chart"></div>

								</div>
							</div>

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Kilómetros recorridos</h3>
								</div>

								<div class="panel-body">

									<div id="car-usage-chart" class="ct-chart"></div>		

								</div>
							</div>



						</div>
					</div>


@endsection



@section('custom-js')
	<script src="../assets/vendor/chartist/js/chartist.min.js"></script>
	<script>
	$(function() {
		var data, options;

		// gréfico de ingresos y gastos de cada vehiculo
		data = {
			labels: ['Renault Fluence', 'Chevrolet Onix'],
			series: [
			    [22500, 15000],
			    [9000, 5500]
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
			}
		};

		new Chartist.Bar('#balance-chart', data, options);


		// grafico de tiempo de alquiler de cada vehiculo
		data = {
			labels: ['Renault Fluence', 'Chevrolet Onix'],
			series: [
				[19, 9]
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
			      return value + ' d';
			    }
			}
		};

		new Chartist.Bar('#rent-time-chart', data, options);


		// grafico de kilometros recorridos
		data = {
			labels: ['Renault Fluence', 'Chevrolet Onix'],
			series: [
				[6384, 4500]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};
		new Chartist.Bar('#car-usage-chart', data, options);

	});
	</script>
@endsection