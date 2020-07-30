@extends('layouts.main')

@section('title', 'Reporte de balances')


@section('custom-css')
	<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist-custom.css">
@endsection


@section('content')

					<h3 class="page-title">Reportes / Balances</h3>
	
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

									<div class="row" style="margin-bottom: 20px; text-align: right;">
										<div class="col-xs-6">
											<div class="metric">
												<p>
													<span class="number">$25.000</span>
													<span class="title">Ingresos</span>
												</p>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="metric">
												<p>
													<span class="number">$12.000</span>
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
	<script src="../assets/vendor/chartist/js/chartist.min.js"></script>
	<script>
	$(function() {
		var data, options;

		// gráfico de balances
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

		new Chartist.Line('#balance-chart', data, options);


		// gráfico de gastos según tipo
		data = {
			labels: ['Service', 'Reparación', 'Otro trabajo', 'Seguros', 'Patentes', 'Otros gastos'],
			series: [
				[4000, 3000, 1200, 3500, 2000, 1000]
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
			labels: ['Mariano mecánico', 'Repuestos José', 'Provincia Seguros', 'Jumax', 'Otros'],
			series: [
				[6384, 6342, 5437, 2764, 3958]
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