@extends('layouts.main')

@section('title', 'Detalles de vehiculo')

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist-custom.css">
	<style>
	.ct-series-b .ct-line {
		  /* Set the colour of this series line */
		  stroke: orange;
		  /* Control the thikness of your lines */
		  stroke-width: 2px;
		  /* Create a dashed line with a pattern */
		  stroke-dasharray: 15px 10px;
		}
	</style>
@endsection

@section('content')

					<h3 class="page-title"><a href="{{ route('vehiculos.index') }}">Vehículos</a> / {{ $vehiculo->marca }} {{ $vehiculo->modelo }} ({{ $vehiculo->dominio }})</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group" role="group">
								<button class="btn btn-primary"><i class="fa fa-wrench" aria-hidden="true"></i> Registrar trabajo</button>
								<button class="btn btn-default" style="margin-left: 15px" data-toggle="modal" data-target="#myModal"><i class="fa fa-tachometer" aria-hidden="true"></i> Registrar kilometraje</button>
								<button class="btn btn-danger" style="margin-left: 15px"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar vehículo</button>
							</div>
						</div>
					</div>

					@if(session('success'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Los datos se actualizaron correctamente.
					</div>
					@endif

					<div class="alert alert-warning">
						<ul>
							<li>Se debe registrar el kilometraje correspondiente al mes de julio para actualizar la proyección.</li>
							<li>Se aproxima la fecha para realizar el service al vehículo. Registra el trabajo una vez realizado.</li>
						</ul>
					</div>

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Alquiler del vehículo</h3>
								</div>

								<div class="panel-body">


									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Estado actual</label>:&nbsp;&nbsp;&nbsp;<span class="label label-success" style="font-size: 15px">Alquilado</span>


											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Alquilado a:</label> <a href="">Juan Pérez</a>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Fecha de inicio:</label> 1 jul 2020
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Fecha de finalización:</label> No definida
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Monto diario:</label> $2.000
											</div>
										</div>
										<div class="col-sm-6">
											<a href="../alquileres/detalles.html" class="btn btn-xs btn-primary">Ver detalles del alquiler</a>
										</div>
									</div>


									<h4>Alquileres anteriores (finalizados)</h4>

									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>ID #</th>
												<th>Fecha inicio</th>
												<th>Fecha fin</th>
												<th>Chofer</th>
												<th>Monto diario</th>
												<th>Saldo</th>
												<th>Ingreso total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>2</td>
												<td>20 jun 2020</td>
												<td>29 jun 2020</td>
												<td>Juan Pérez</td>
												<td>$2.000</td>
												<td><span>$&nbsp;-</td>
												<td>$18.000</td>
											</tr>
										</tbody>
									</table>


								</div>
							</div>

						</div>

						<div class="col-lg-6">
							
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Estado del vehículo</h3>
								</div>

								<div class="panel-body">

									<div class="row">
										<div class="col-md-5">

											<h4 style="margin-bottom: 20px">Próximos trabajos estimados</h4>

											<div class="form-group">
												<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" aria-hidden="true"></i> <strong>Service:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="148.000 km">en 1 semana</span>
											</div>
											<div class="form-group">
												<strong>Cambio de bujías:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="182.500 km">en 3 meses</span>
											</div>
											<div class="form-group">
												<strong>Rotación de cubiertas:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="182.500 km">en 3 meses</span>
											</div>
											<div class="form-group">
												<strong>Cambio de cubiertas:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="182.500 km">en 3 meses</span>
											</div>
											<div class="form-group">
												<strong>Correa de distribución:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="195.000 km">en 4 meses</span>
											</div>
											<div class="form-group">
												<strong>Revisión VTV:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="15/01/2021">en 6 meses</span>
											</div>
											<div class="form-group">
												<strong>Revisión GNC:</strong> <span class="underline-dash" data-toggle="tooltip" data-placement="top" title="15/01/2021">en 6 meses</span>
											</div>										</div>
										<div class="col-md-7">

											<div class="form-group">
												<strong>Kilometraje estimado actual:</strong> 145.000
											</div>

											<div class="form-group">
												<strong>Uso actual estimado:</strong> 12.500 KMs/mes
											</div>

											<h4>Proyección de kilometraje</h4>
											<div id="demo-line-chart" class="ct-chart"></div>

										</div>
									</div>

									<h4>Últimos trabajos realizados<a class="btn btn-xs btn-primary" style="margin-left: 20px">Ver todos</a></h4>
									<table class="table">
										<thead>
											<tr>
												<th>Fecha pagado</th>
												<th>Fecha realizado</th>
												<th>Tipo de trabajo</th>
												<th>Proveedor</th>
												<th>Costo</th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<td>3 jul 2020</td>
												<td>-</td>
												<td>Otro</td>
												<td>-</td>
												<td>$1.200</td>
											</tr>
											<tr>
												<td>25 jun 2020</td>
												<td>25 jun 2020</td>
												<td>Reparación</td>
												<td>Mariano mecánico</td>
												<td>$2.000</td>
											</tr>
											<tr>
												<td>10 jun 2020</td>
												<td>10 jun 2020</td>
												<td>Cambio de frenos</td>
												<td>-</td>
												<td>$3.000</td>
											</tr>

											<tr>
												<td>8 may 2020</td>
												<td>8 may 2020</td>
												<td>Service</td>
												<td>Jumax</td>
												<td>$2.500</td>
											</tr>
										</tbody>
									</table>

								</div>
							</div>

						</div>
					</div>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles del vehículo</h3>
						</div>

						<div class="panel-body">

							<a name="formulario-detalles-vehiculo"></a>

							<form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
								@method('PUT')
								@csrf

								<div class="row">
									<div class="col-lg-3">

										<h4 style="margin-bottom: 20px;">Datos del vehículo</h4>

										<div class="form-group @error('dominio') has-error @enderror">
											<label>Dominio (patente)</label>
											<input type="text" class="form-control" name="dominio" value="{{ old('dominio') ?: $vehiculo->dominio }}">
											@error('dominio')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group @error('marca') has-error @enderror">
											<label>Marca</label>
											<input type="text" class="form-control" name="marca" value="{{ old('marca') ?: $vehiculo->marca }}">
											@error('marca')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('modelo') has-error @enderror">
											<label>Modelo</label>
											<input type="text" class="form-control" name="modelo" value="{{ old('modelo') ?: $vehiculo->modelo }}">
											@error('modelo')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('anio') has-error @enderror">
											<label>Año</label>
											<input type="number" class="form-control" name="anio" min="1990" max="2025" value="{{ old('anio') ?: $vehiculo->anio }}">
											@error('anio')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

									</div>

									<div class="col-lg-5">
										
										<h4 style="margin-bottom: 20px;">Mantenimiento</h4>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_service') has-error @enderror">
													<label>KMs cada service</label>
													<input type="number" class="form-control" name="kms_cada_service" value="{{ old('kms_cada_service') ?: $vehiculo->kms_cada_service }}">
													@error('kms_cada_service')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_bujias') has-error @enderror">
													<label>KMs cada cambio bujías</label>
													<input type="number" class="form-control" name="kms_cada_cambio_bujias" value="{{ old('kms_cada_cambio_bujias') ?: $vehiculo->kms_cada_cambio_bujias }}">
													@error('kms_cada_cambio_bujias')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_rotacion_cubiertas') has-error @enderror">
													<label>KMs cada rotación cubiertas</label>
													<input type="number" class="form-control" name="kms_cada_rotacion_cubiertas" value="{{ old('kms_cada_rotacion_cubiertas') ?: $vehiculo->kms_cada_rotacion_cubiertas }}">
													@error('kms_cada_rotacion_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_cubiertas') has-error @enderror">
													<label>KMs cada cambio cubiertas</label>
													<input type="number" class="form-control" name="kms_cada_cambio_cubiertas" value="{{ old('kms_cada_cambio_cubiertas') ?: $vehiculo->kms_cada_cambio_cubiertas }}">
													@error('kms_cada_cambio_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_correa_distr') has-error @enderror">
													<label>KMs cada cambio correa distribución</label>
													<input type="number" class="form-control" name="kms_cada_cambio_correa_distr" value="{{ old('kms_cada_cambio_correa_distr') ?: $vehiculo->kms_cada_cambio_correa_distr }}">
													@error('kms_cada_cambio_correa_distr')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
										</div>



										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('fecha_vto_vtv') has-error @enderror">
													<label>Fecha vencimiento VTV</label>
													<input type="text" class="form-control" name="fecha_vto_vtv" id="input_fecha_vto_vtv" value="{{ old('fecha_vto_vtv') ?: ($vehiculo->fecha_vto_vtv ? $vehiculo->fecha_vto_vtv->format('d/m/Y') : '') }}">
													@error('fecha_vto_vtv')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group @error('fecha_vto_oblea_gnc') has-error @enderror">
													<label>Fecha vto. oblea GNC</label>
													<input type="text" class="form-control" name="fecha_vto_oblea_gnc" id="input_fecha_vto_gnc" value="{{ old('fecha_vto_oblea_gnc') ?: ($vehiculo->fecha_vto_oblea_gnc ? $vehiculo->fecha_vto_oblea_gnc->format('d/m/Y') : '') }}">
													@error('fecha_vto_oblea_gnc')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

									</div>


									<div class="col-lg-4">
										
										<h4 style="margin-bottom: 20px;">Impuesto de patentes</h4>

										<label class="fancy-checkbox" style="margin-bottom: 10px">

											<input type="checkbox" name="debito_patentes" id="checkbox_debito_patentes" @if(old('debito_patentes') || $vehiculo->tieneDebitoAutomPatentes()) checked @endif>

											<span>Débito automático pago de patentes</span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Registrar el pago de patentes automáticamente en el registro de gastos adicionales una vez por mes, pagando con tarjeta de crédito."></span>
										</label>
											
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('costo_mensual_imp_automotor') has-error @enderror">
													<label>Costo ($)</label>
													<input type="number" name="costo_mensual_imp_automotor" step="0.01" min="0" class="form-control" id="input_costo_patentes" value="{{ old('costo_mensual_imp_automotor') ?: $vehiculo->costo_mensual_imp_automotor }}">
													@error('costo_mensual_imp_automotor')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group @error('dia_del_mes_debito_imp_automotor') has-error @enderror">
													<label>Día del mes débito (1-28)</label>
													<input type="number" name="dia_del_mes_debito_imp_automotor" class="form-control" id="input_dia_debito_patentes" value="{{ old('dia_del_mes_debito_imp_automotor') ?: $vehiculo->dia_del_mes_debito_imp_automotor }}">
													@error('dia_del_mes_debito_imp_automotor')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>


										<h4 style="margin: 25px 0 20px;">Seguro automotor</h4>

										<label class="fancy-checkbox" style="margin-bottom: 10px">

											<input type="checkbox" name="debito_seguro" id="checkbox_debito_seguro" @if(old('debito_seguro') || $vehiculo->tieneDebitoAutomSeguro()) checked @endif>

											<span>Débito automático pago de seguros</span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Registrar el pago de seguro automáticamente en el registro de gastos adicionales una vez por mes, pagando con tarjeta de crédito."></span>
										</label>
										</label>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('id_proveedor_seguro') has-error @enderror">
													<label>Proveedor</label>
													<select class="form-control" name="id_proveedor_seguro" id="select_proveedor_seguro">
														<option value="">Seleccionar</option>
														@foreach($proveedoresSeguro as $proveedorSeguro)
														<option value="{{ $proveedorSeguro->id }}" @if($vehiculo->id_proveedor_seguro == $proveedorSeguro->id) selected @endif>{{ $proveedorSeguro->nombre }}</option>
														@endforeach
													</select>
													@error('id_proveedor_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('fecha_vto_poliza_seguro') has-error @enderror">
													<label>Fecha vto. póliza</label>
													<input type="text" name="fecha_vto_poliza_seguro" class="form-control" id="input_fecha_vto_poliza" value="{{ old('fecha_vto_poliza_seguro') ?: ($vehiculo->fecha_vto_poliza_seguro ? $vehiculo->fecha_vto_poliza_seguro->format('d/m/Y') : '') }}">
													@error('fecha_vto_poliza_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('costo_mensual_seguro') has-error @enderror">
													<label>Costo ($)</label>
													<input type="number" name="costo_mensual_seguro" step="0.01" min="0" class="form-control" id="input_costo_seguro" value="{{ old('costo_mensual_seguro') ?: $vehiculo->costo_mensual_seguro }}">
													@error('costo_mensual_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('dia_del_mes_debito_seguro') has-error @enderror">
													<label>Día del mes débito (1-28)</label>
													<input type="number" name="dia_del_mes_debito_seguro" class="form-control" id="input_dia_debito_seguro" value="{{ old('dia_del_mes_debito_seguro') ?: $vehiculo->dia_del_mes_debito_seguro }}">
													@error('dia_del_mes_debito_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

									</div>

								</div>

								<div style="text-align:right">
									<button class="btn btn-primary">Guardar</button>
								</div>
							</form>
							
						</div>
					</div>


@endsection



@section('custom-js')
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script src="../assets/vendor/chartist/js/chartist.min.js"></script>	
	<script>
	$(function() {


		// Config
		$('[data-toggle="tooltip"]').tooltip();

		$('#input_fecha_vto_vtv, #input_fecha_vto_gnc, #input_fecha_vto_poliza').datepicker({
			autoclose: true,
			language: 'es-ES',
			format: 'dd/mm/yyyy',
			startDate: 'tomorrow',
			endDate: '+2y'
		});


		// Events calls
		$("#checkbox_debito_patentes").change(function() {
			$("#input_costo_patentes, #input_dia_debito_patentes").prop("disabled", !$(this).prop("checked"));
		});

		$("#checkbox_debito_seguro").change(function() {
			$("#select_proveedor_seguro, #input_costo_seguro, #input_dia_debito_seguro, #input_fecha_vto_poliza").prop("disabled", !$(this).prop("checked"));
		});



		// Actions
		$("#checkbox_debito_patentes").trigger("change");
		$("#checkbox_debito_seguro").trigger("change");

		@if($errors->any())
		// Saltar a formulario si hay errores.
		location.hash = "#formulario-detalles-vehiculo";
		@endif


		// ******Chart*********

		var options;

		var data = {
			labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
			series: [{
				name: 'series-real',
				data: [80000, 97000, 103000, 116000, 136000, 146000],
			}, {
				name: 'series-projection',
				data: [81000, 93500, 106000, 118500, 131000, 143500, 156000, 168500],
			}]
		};

		// line chart
		options = {
			height: "230px",
			showPoint: true,
			axisX: {
				showGrid: false
			},
			series: {
				'series-projection': {
					showPoint: false,
					color: '#F00'
				},
			},
			lineSmooth: false,
		};

		new Chartist.Line('#demo-line-chart', data, options);






	});
	</script>
@endsection