@extends('layouts.main')

@section('title', 'Agregar gasto')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('gastos-adicionales.index') }}">Gastos adicionales</a> / Registrar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del gasto</h3>
								</div>

								<div class="panel-body">

									<form method="POST" action="{{ route('gastos-adicionales.store') }}">
										@csrf

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group @error('fecha') has-error @enderror">
													<label>Fecha</label>
													<input type="text" class="form-control" id="input_fecha_gasto" name="fecha" value="{{ old('fecha') }}">
													@error('fecha')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group @error('tipo') has-error @enderror">
													<label>Tipo de gasto</label>
													<select class="form-control" name="tipo">
														<option value="">Seleccionar</option>
														<option value="seguro_vehiculo" @if(old('tipo') == 'seguro_vehiculo') selected @endif>Pago de seguro</option>
														<option value="impuesto_automotor" @if(old('tipo') == 'impuesto_automotor') selected @endif>Impuesto automotor</option>
														<option value="otro" @if(old('tipo') == 'otro') selected @endif>Otro</option>
													</select>
													@error('tipo')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group @error('detalle') has-error @enderror">
													<label>Detalle (opcional)</label>
													<input type="text" class="form-control" name="detalle" value="{{ old('detalle') }}">
													@error('detalle')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="form-group @error('id_vehiculo') has-error @enderror">
											<label>Vehículo asociado al gasto</label>
											<select class="form-control" name="id_vehiculo">
												<option value="">Ninguno</option>
												@foreach($vehiculos as $vehiculo)
												<option value="{{ $vehiculo->id }}" @if(old('id_vehiculo') == $vehiculo->id) selected @endif>{{ $vehiculo->marcaModeloYDominio() }}</option>
												@endforeach
											</select>
											@error('id_vehiculo')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group @error('monto') has-error @enderror">
													<label>Monto ($)</label>
													<input type="number" step="0.01" min="0" class="form-control" name="monto" value="{{ old('monto') }}">
													@error('monto')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group @error('medio_pago') has-error @enderror">
													<label>Medio de pago</label>
													<select class="form-control" name="medio_pago">
														<option value="">Seleccionar</option>
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

										<div class="form-group @error('id_proveedor') has-error @enderror">
											<label>Proveedor asociado al gasto</label>
											<select class="form-control" name="id_proveedor">
												<option value="">Ninguno</option>
												@foreach($proveedores as $proveedor)
												<option value="{{ $proveedor->id }}" @if(old('id_proveedor') == $proveedor->id) selected @endif>{{ $proveedor->nombre }}</option>
												@endforeach
											</select>
											@error('id_proveedor')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Guardar</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>

						<div class="col-md-6">
						</div>
					</div>



@endsection



@section('custom-js')
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{

			$('#input_fecha_gasto').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: '-30d',
				endDate: 'today'
			});


			$("#checkbox_fin_alquiler_indefinido").change(function() {
				$("#input_fecha_fin_alquiler").prop("disabled", $(this).prop("checked"));
			})

		});


	</script>
@endsection