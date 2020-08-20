@extends('layouts.main')

@section('title', $vehiculo->marcaModeloYDominio())

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

								<a href="{{ route('trabajos-vehiculos.create').'?veh_id='.$vehiculo->id }}" class="btn btn-primary"><i class="fa fa-wrench" aria-hidden="true"></i> Registrar trabajo</a>

								@if($puedeRegistrarKms)
								<a href="{{ route('vehiculos.registrar-kilometraje', $vehiculo->id) }}" class="btn btn-default" style="margin-left: 15px"><i class="fa fa-tachometer" aria-hidden="true"></i> Registrar kilometraje</a>
								@endif
								
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

					@if($puedeRegistrarKms)
					<div class="alert alert-warning">Se debe registrar el kilometraje correspondiente al mes de julio para actualizar la proyección</div>
					@endif

					<div class="row">
						<div class="col-lg-6">

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Alquiler del vehículo</h3>
								</div>

								<div class="panel-body">


									@if($vehiculo->alquilerActual)

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Estado actual</label>:&nbsp;&nbsp;&nbsp;<span class="label label-success" style="font-size: 15px">Alquilado</span>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Alquilado a:</label> <a href="{{ route('choferes.show', $vehiculo->alquilerActual->chofer->id) }}">{{ $vehiculo->alquilerActual->chofer->nombre_y_apellido }}</a>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Fecha de inicio:</label> {{ $vehiculo->alquilerActual->fecha_inicio->isoFormat('D MMM Y') }}
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Fecha de finalización:</label> 
												@if($vehiculo->alquilerActual->fecha_fin)
												{{ $vehiculo->alquilerActual->fecha_fin->isoFormat('D MMM Y') }}
												@else
												No definida
												@endif
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Monto diario:</label> {{ App\Lib\Strings::formatearMoneda($vehiculo->alquilerActual->precio_diario, 2) }}
											</div>
										</div>
										<div class="col-sm-6">
											<a href="{{ route('alquileres.show', $vehiculo->alquilerActual->id) }}" class="btn btn-xs btn-primary">Ver detalles del alquiler</a>
										</div>
									</div>

									@else

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Estado actual</label>:&nbsp;&nbsp;&nbsp;<span class="label label-default" style="font-size: 15px">Sin alquilar</span>
											</div>
										</div>
									</div>

									@endif

									<h4>Alquileres anteriores (finalizados)</h4>

									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>ID #</th>
												<th>Fecha inicio</th>
												<th>Fecha fin</th>
												<th>Chofer</th>
												<th>Monto diario</th>
												<th>Saldo</th>
											</tr>
										</thead>
										<tbody>
											@foreach($ultimosAlquileres as $alquiler)
											<tr>
												<td><a href="{{ route('alquileres.show', $alquiler->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>{{ $alquiler->id }}</td>
												<td>{{ $alquiler->fecha_inicio->isoFormat('D MMM') }}</td>
												<td>{{ $alquiler->fecha_fin ? $alquiler->fecha_fin->isoFormat('D MMM') : '-' }}</td>
												<td>{{ $alquiler->chofer->nombre_y_apellido }}</td>
												<td>{{ App\Lib\Strings::formatearMoneda($alquiler->precio_diario, 0) }}</td>
												<td>
													<span style="@if($alquiler->saldo_actual < 0) color: #B00 @endif">
														{{ App\Lib\Strings::formatearMoneda($alquiler->saldo_actual, 0) }}
													</span>
												</td>
											</tr>
											@endforeach

											@if($ultimosAlquileres->count() == 0)
											<tr><td colspan="7" style="text-align: center;">No se encontraron alquileres anteriores.</td></tr>
											@endif
										</tbody>
									</table>


								</div>
							</div>


							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Últimos trabajos realizados</h3>
									<div class="right"><a href="{{ route('trabajos-vehiculos.index') }}" class="btn btn-xs btn-primary" style="margin-left: 20px">Ver todos</a></div>
								</div>

								<div class="panel-body">
									
									<table class="table table-striped">
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
											@foreach($ultimosTrabajos as $trabajo)
											<tr>
												<td>{{ $trabajo->fecha_pagado->isoFormat('D MMM') }}</td>
												<td>{{ $trabajo->fecha_realizado->isoFormat('D MMM') }}</td>
												<td>{{ __('tipos_trabajos.'.$trabajo->tipo) }}</td>
												<td>{{ $trabajo->proveedor ? $trabajo->proveedor->nombre : '-' }}</td>
												<td>{{ App\Lib\Strings::formatearMoneda($trabajo->costo, 0) }}</td>
											</tr>
											@endforeach

											@if($ultimosTrabajos->count() == 0)
											<tr><td colspan="5" style="text-align: center;">No se encontraron trabajos.</td></tr>
											@endif
										</tbody>
									</table>


								</div>
							</div>


						</div>

						<div class="col-lg-6">


							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Uso del vehículo y proyección</h3>
								</div>

								<div class="panel-body">
									
									@if($vehiculo->puedeEstimarKilometraje())
									<div class="row" style="margin-bottom: 20px">
										<div class="col-sm-6">
											<strong>Kilometraje estimado actual:</strong> {{ App\Lib\Strings::formatearEntero($vehiculo->kilometrajeEstimadoActual()) }}
										</div>
										<div class="col-sm-6">
											<strong>Uso actual estimado:</strong> {{ App\Lib\Strings::formatearEntero($vehiculo->usoKmsMensualEstimado()) }} KMs/mes
										</div>
									</div>

									<div id="grafico-uso-vehiculo" class="ct-chart"></div>
									@else

									Debés ingresar al menos un registro de kilometraje para calcular el uso estimado del vehículo, las notificaciones de trabajos de mantenimiento programados no se mostrarán hasta entonces.<br/><br/>
									
									@endif

									La fecha del próximo ingreso de kilometraje es: {{ $fechaSgteRegistroKm->isoFormat('D MMM Y') }}
								</div>
							</div>

						
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Próximos trabajos o tareas estimadas</h3>
								</div>

								<div class="panel-body">


									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>Descripción</th>
												<th>Fecha a realizar</th>
												<th>Kms estim.</th>
											</tr>
										</thead>
										<tbody>
											@foreach($vehiculo->tareasPendientes as $tareaPendiente)
											<tr>
												<td>
													@if($tareaPendiente->enPeriodoDeNotificacion())
													<i class="fa fa-info-circle" style="color: #41b7e6;font-size: 17px;" aria-hidden="true"></i>
													@elseif($tareaPendiente->estaVencida())
													<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" aria-hidden="true"></i>
													@endif
												</td>
												<td>
													@if($tareaPendiente->esDeTrabajoVehicular())

														{{ __('tipos_trabajos.'.$tareaPendiente->tipo_trabajo_vehicular) }}

													@else

														@if($tareaPendiente->tipo == App\TareaPendiente::TIPO_RENOV_VTV)
														Renovación de VTV
														@elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_VERIF_GNC)
														Verificación de GNC
														@elseif($tareaPendiente->tipo == App\TareaPendiente::TIPO_RENOV_SEGURO)
														Renovación de póliza de seguro
														@endif

													@endif
												</td>

												<td><span class="underline-dash" data-toggle="tooltip" data-placement="top" title="{{ $tareaPendiente->fecha_a_realizar->isoFormat('D MMM') }}">{{ $tareaPendiente->fecha_a_realizar->diffForHumans() }}</span></td>

												<td>{{ $tareaPendiente->kilometraje_estimado ? App\Lib\Strings::formatearEntero($tareaPendiente->kilometraje_estimado) : '' }}</td>
											</tr>
											@endforeach

											@if($vehiculo->tareasPendientes->count() == 0)
											<tr><td colspan="4" style="text-align: center;">No se encontraron tareas pendientes próximas para este vehículo.</td></tr>
											@endif
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
										
										<h4 style="margin-bottom: 20px;">Mantenimiento programado &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Ingresá la frecuencia en kms de algún tipo de trabajo para activar las notificaciones cuando se aproxime la fecha estimada. Dejala vacía para desactivar las notificaciones."></span></h4>

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

										<h4 style="margin-bottom: 20px;">Verificaciones&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Ingresa la fecha para recibir una notificación una semana antes del vencimiento, dejalo vacío para no recibirla."></span></h4>


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
	<script src="{{ asset('assets/vendor/chartist/js/chartist.min.js') }}"></script>	
	<script>
	$(function() {


		// Config

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

		@if($datosKilometraje)

			var data = {
				labels: {!! json_encode($datosKilometraje['fechas']) !!},
				series: [{
					name: 'series-real',
					data: {{ json_encode($datosKilometraje['kms_registrados']) }},
				}, {
					name: 'series-projection',
					data: {{ json_encode($datosKilometraje['kms_estimados']) }},
				}]
			};

		@else
			var data = null;
		@endif
		


		// line chart
		options = {
			height: "230px",
			showPoint: true,
			axisX: {
				showGrid: false
			},
			axisY: {
				offset: 70,
			    labelInterpolationFnc: function(value) {
			      return value/1000 + "mil km";
			    }
			},
			series: {
				'series-projection': {
					showPoint: false,
					color: '#F00'
				},
			},
			lineSmooth: false

		};

		new Chartist.Line('#grafico-uso-vehiculo', data, options);






	});
	</script>
@endsection