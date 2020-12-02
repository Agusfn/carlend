@extends('layouts.main')

@section('title', 'Agregar vehículo')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('vehiculos.index') }}">Vehículos</a> / Agregar</h3>


					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles del vehículo</h3>
						</div>

						<div class="panel-body">

							<form action="{{ route('vehiculos.store') }}" method="POST">
								@csrf

								<div class="row">
									<div class="col-lg-4">

										<h4 style="margin-bottom: 20px;">Datos del vehículo</h4>

										<div class="form-group @error('dominio') has-error @enderror">
											<label>Dominio (patente)*</label>
											<input type="text" class="form-control" name="dominio" value="{{ old('dominio') }}">
											@error('dominio')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group @error('marca') has-error @enderror">
											<label>Marca*</label>
											<input type="text" class="form-control" name="marca" value="{{ old('marca') }}">
											@error('marca')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('modelo') has-error @enderror">
											<label>Modelo*</label>
											<input type="text" class="form-control" name="modelo" value="{{ old('modelo') }}">
											@error('modelo')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('anio') has-error @enderror">
													<label>Año*</label>
													<input type="number" class="form-control" name="anio" min="1990" max="2025" value="{{ old('anio') }}">
													@error('anio')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kilometraje_actual') has-error @enderror">
													<label>Kilometraje actual*</label>
													<input type="number" name="kilometraje_actual" class="form-control" value="{{ old('kilometraje_actual') }}">
													@error('kilometraje_actual')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>



									</div>

									<div class="col-lg-4">
										
										<h4 style="margin-bottom: 20px;">Mantenimiento</h4>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_service') has-error @enderror">
													<label>KMs c/ service</label>
													<input type="number" class="form-control" name="kms_cada_service" value="{{ old('kms_cada_service') }}">
													@error('kms_cada_service')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_ult_service') has-error @enderror">
													<label>KMs ult. service*</label>
													<input type="number" name="kms_ult_service" class="form-control" value="{{ old('kms_ult_service') }}">
													@error('kms_ult_service')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_bujias') has-error @enderror">
													<label>KMs c/ cambio bujías</label>
													<input type="number" class="form-control" name="kms_cada_cambio_bujias" value="{{ old('kms_cada_cambio_bujias') }}">
													@error('kms_cada_cambio_bujias')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_ult_cambio_bujias') has-error @enderror">
													<label>KMs ult. cambio bujías*</label>
													<input type="number" name="kms_ult_cambio_bujias" class="form-control" value="{{ old('kms_ult_cambio_bujias') }}">
													@error('kms_ult_cambio_bujias')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_rotacion_cubiertas') has-error @enderror">
													<label>KMs c/ rotación cubiertas</label>
													<input type="number" class="form-control" name="kms_cada_rotacion_cubiertas" value="{{ old('kms_cada_rotacion_cubiertas') }}">
													@error('kms_cada_rotacion_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_ult_rotacion_cubiertas') has-error @enderror">
													<label>KMs ult. rotación*</label>
													<input type="number" name="kms_ult_rotacion_cubiertas" class="form-control" value="{{ old('kms_ult_rotacion_cubiertas') }}">
													@error('kms_ult_rotacion_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_cubiertas') has-error @enderror">
													<label>KMs c/ cambio cubiertas</label>
													<input type="number" class="form-control" name="kms_cada_cambio_cubiertas" value="{{ old('kms_cada_cambio_cubiertas') }}">
													@error('kms_cada_cambio_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_ult_cambio_cubiertas') has-error @enderror">
													<label>KMs ult. cambio cubiertas*</label>
													<input type="number" class="form-control" name="kms_ult_cambio_cubiertas" value="{{ old('kms_ult_cambio_cubiertas') }}">
													@error('kms_ult_cambio_cubiertas')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('kms_cada_cambio_correa_distr') has-error @enderror">
													<label>KMs c/ cambio correa distr.</label>
													<input type="number" class="form-control" name="kms_cada_cambio_correa_distr" value="{{ old('kms_cada_cambio_correa_distr') }}">
													@error('kms_cada_cambio_correa_distr')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>	
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('kms_ult_cambio_correa_distr') has-error @enderror">
													<label>KMs ult. cambio correa*</label>
													<input type="number" name="kms_ult_cambio_correa_distr" class="form-control" value="{{ old('kms_ult_cambio_correa_distr') }}">
													@error('kms_ult_cambio_correa_distr')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('fecha_vto_vtv') has-error @enderror">
													<label>Fecha vencimiento VTV</label>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Ingresa la fecha para recibir una notificación una semana antes del vencimiento, dejalo vacío para no recibirla."></span>
													<input type="text" class="form-control" name="fecha_vto_vtv" id="input_fecha_vto_vtv" value="{{ old('fecha_vto_vtv') }}">
													@error('fecha_vto_vtv')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group @error('fecha_vto_oblea_gnc') has-error @enderror">
													<label>Fecha vto. oblea GNC</label>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Ingresa la fecha para recibir una notificación una semana antes del vencimiento, dejalo vacío para no recibirla."></span>
													<input type="text" class="form-control" name="fecha_vto_oblea_gnc" id="input_fecha_vto_gnc" value="{{ old('fecha_vto_oblea_gnc') }}">
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
												<input type="checkbox" name="debito_patentes" id="checkbox_debito_patentes" @if(old('debito_patentes')) checked @endif>

												<span>Débito automático pago de patentes</span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Registrar el pago de patentes automáticamente en el registro de gastos adicionales una vez por mes, pagando con tarjeta de crédito."></span>
											</label>
											
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('costo_mensual_imp_automotor') has-error @enderror">
													<label>Costo ($)</label>
													<input type="number" name="costo_mensual_imp_automotor" step="0.01" min="0" class="form-control" id="input_costo_patentes" value="{{ old('costo_mensual_imp_automotor') }}">
													@error('costo_mensual_imp_automotor')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group @error('dia_del_mes_debito_imp_automotor') has-error @enderror">
													<label>Día del mes débito (1-28)</label>
													<input type="number" name="dia_del_mes_debito_imp_automotor" class="form-control" id="input_dia_debito_patentes" value="{{ old('dia_del_mes_debito_imp_automotor') }}">
													@error('dia_del_mes_debito_imp_automotor')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>


										<h4 style="margin: 25px 0 20px;">Seguro automotor</h4>

											<label class="fancy-checkbox" style="margin-bottom: 10px">

												<input type="checkbox" name="debito_seguro" id="checkbox_debito_seguro" @if(old('debito_seguro')) checked @endif>

												<span>Débito automático pago de seguros</span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Registrar el pago de seguro automáticamente en el registro de gastos adicionales una vez por mes, pagando con tarjeta de crédito."></span>
											</label>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('id_proveedor_seguro') has-error @enderror">
													<label>Proveedor</label>
													<select class="form-control" name="id_proveedor_seguro" id="select_proveedor_seguro">
														<option value="">Seleccionar</option>
														@foreach($proveedoresSeguro as $proveedorSeguro)
														<option value="{{ $proveedorSeguro->id }}" @if(old('id_proveedor_seguro') == $proveedorSeguro->id) selected @endif>{{ $proveedorSeguro->nombre }}</option>
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
													<input type="text" name="fecha_vto_poliza_seguro" class="form-control" id="input_fecha_vto_poliza" value="{{ old('fecha_vto_poliza_seguro') }}">
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
													<input type="number" name="costo_mensual_seguro" step="0.01" min="0" class="form-control" id="input_costo_seguro" value="{{ old('costo_mensual_seguro') }}">
													@error('costo_mensual_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('dia_del_mes_debito_seguro') has-error @enderror">
													<label>Día del mes débito (1-28)</label>
													<input type="number" name="dia_del_mes_debito_seguro" class="form-control" id="input_dia_debito_seguro" value="{{ old('dia_del_mes_debito_seguro') }}">
													@error('dia_del_mes_debito_seguro')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

									</div>

								</div>
										<div class="form-group">
											Los campos con (*) son obligatorios.
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
	<script type="text/javascript">
		$(document).ready(function() {

			// Config
			$('#input_fecha_vto_vtv, #input_fecha_vto_gnc, #input_fecha_vto_poliza').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				startDate: 'tomorrow',
				endDate: '+2y'
			});

			// Event calls
			$("#checkbox_debito_patentes").change(function() {
				$("#input_costo_patentes, #input_dia_debito_patentes").prop("disabled", !$(this).prop("checked"));
			});

			$("#checkbox_debito_seguro").change(function() {
				$("#select_proveedor_seguro, #input_costo_seguro, #input_dia_debito_seguro, #input_fecha_vto_poliza").prop("disabled", !$(this).prop("checked"));
			});


			// Actions
			$("#checkbox_debito_patentes").trigger("change");
			$("#checkbox_debito_seguro").trigger("change");


		});
	</script>
@endsection