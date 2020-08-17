@extends('layouts.main')

@section('title', 'Registrar trabajo sobre vehículo')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('trabajos-vehiculos.index') }}">Trabajos sobre vehículos</a> / Registrar nuevo trabajo</h3>

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del trabajo</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('trabajos-vehiculos.store') }}" method="POST">
										@csrf
										<div class="form-group @error('id_vehiculo') has-error @enderror">
											<label>Vehículo</label>
											<select class="form-control" name="id_vehiculo">
												<option value="">Seleccionar</option>
												@foreach($vehiculos as $vehiculo)
												<option value="{{ $vehiculo->id }}" @if(old('id_vehiculo') == $vehiculo->id || request()->input('veh_id') == $vehiculo->id) selected @endif>{{ $vehiculo->marcaModeloYDominio() }}</option>
												@endforeach
											</select>
											@error('id_vehiculo')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('tipo') has-error @enderror">
											<label>Tipo de trabajo</label>

											<select class="form-control" name="tipo">
												<option value="">Seleccionar</option>

												@foreach(App\TrabajoVehiculo::$tiposTrabajos as $tipoTrabajo)
												<option value="{{ $tipoTrabajo }}" @if(old('tipo') == $tipoTrabajo) selected @endif>{{ __('tipos_trabajos.'.$tipoTrabajo) }}</option>
												@endforeach

											</select>

											@error('tipo')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group @error('observaciones') has-error @enderror">
											<label>Observaciones</label>
											<input type="text" name="observaciones" class="form-control" placeholder="Opcional" value="{{ old('observaciones') }}">
											@error('observaciones')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group @error('id_proveedor') has-error @enderror">
											<label>Proveedor</label>

											<select class="form-control" name="id_proveedor">
												<option value="">Ninguno / no registrado</option>
												
												@foreach($proveedores as $proveedor)
												<option value="{{ $proveedor->id }}" @if(old('id_proveedor') == $proveedor->id) selected @endif>{{ $proveedor->nombre }}</option>
												@endforeach
												
											</select>

											@error('id_proveedor')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group @error('fecha_pagado') has-error @enderror">
													<label>Fecha pagado</label>
													<input type="text" class="form-control" name="fecha_pagado" id="input_fecha_pagado" value="{{ old('fecha_pagado') }}">
													@error('fecha_pagado')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group @error('costo_total') has-error @enderror">
													<label>Costo total ($)</label>
													<input type="number" step="0.01" min="0" class="form-control" name="costo_total" value="{{ old('costo_total') }}">
													@error('costo_total')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group @error('medio_pago') has-error @enderror">
													<label>Medio de pago</label>
													<select class="form-control" name="medio_pago">
														<option>Seleccionar</option>
														<option value="efectivo" @if(old('medio_pago') == 'efectivo') selected @endif>Efectivo</option>
														<option value="tarjeta_credito" @if(old('medio_pago') == 'tarjeta_credito') selected @endif>Tarjeta de crédito</option>
														<option value="transferencia" @if(old('medio_pago') == 'transferencia') selected @endif>Transferencia bancaria</option>
													</select>
													@error('medio_pago')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group @error('fecha_realizado') has-error @enderror">
													<label>Fecha realizado el trabajo</label>
													<!--label class="fancy-checkbox">
														<input type="checkbox" id="checkbox_inform_job_date_later">
														<span>Informar más adelante</span>
													</label-->
													<input type="text" class="form-control" name="fecha_realizado" id="input_fecha_realizado" value="{{ old('fecha_realizado') }}">
													@error('fecha_realizado')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group @error('kms_vehiculo_estimados') has-error @enderror">
													<label>Kms del vehículo&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Este campo es opcional sólo si el vehículo seleccionado ya tiene curva de predicción de kilometraje. Pero se aconseja ingresar el kilometraje real para mayor precisión."></span></label>
													<input type="number" min="0" class="form-control" name="kms_vehiculo_estimados" value="{{ old('kms_vehiculo_estimados') }}">
													@error('kms_vehiculo_estimados')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar trabajo</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>
					</div>



@endsection



@section('custom-js')
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('[data-toggle="tooltip"]').tooltip();

			$('#input_fecha_pagado, #input_fecha_realizado').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				startDate: '-7d',
				endDate: 'today'
			});

			/*$("#checkbox_inform_job_date_later").change(function() {

				if($(this).prop("checked")) {
					$("#input_fecha_realizado").val('').prop("disabled", true);
				}
				else {
					$("#input_fecha_realizado").prop("disabled", false);
				}

			});*/


		});
	</script>
@endsection