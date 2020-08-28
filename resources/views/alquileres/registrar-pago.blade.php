@extends('layouts.main')

@section('title', 'Registrar nuevo pago a alquiler')
  

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection



@section('content')
					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / <a href="{{ route('alquileres.show', $alquiler->id) }}">Alquiler #{{ $alquiler->id }}</a> / Registrar pago o movimiento</h3>


					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del movimiento</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('alquileres.registrar-pago', $alquiler->id) }}" method="POST" id="pago_form">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('fecha') has-error @enderror">
													<label>Fecha del movimiento</label>
													<input type="text" name="fecha" class="form-control" id="input_fecha_movimiento" value="{{ old('fecha') }}">
													@error('fecha')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('tipo') has-error @enderror">
													<label>Tipo de movimiento</label>
													<select class="form-control" name="tipo" id="select_tipo_movimiento">
														<option value="">Seleccionar</option>
														<option value="pago_de_chofer" @if(old('tipo') == 'pago_de_chofer') selected @endif>Pago de chofer</option>
														<option value="descuento" @if(old('tipo') == 'descuento') selected @endif>Descuento</option>
													</select>
													@error('tipo')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('monto') has-error @enderror">
													<label>Monto ($)</label>
													<input type="number" step="0.01" min="0" name="monto" class="form-control" value="{{ old('monto') }}">
													@error('monto')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('medio_pago') has-error @enderror">
													<label>Medio de pago</label>
													<select class="form-control" name="medio_pago" id="select_medio_pago">
														<option value="">Seleccionar</option>
														<option value="efectivo" @if(old('medio_pago') == 'efectivo') selected @endif>Efectivo</option>
														<option value="transferencia" @if(old('medio_pago') == 'transferencia') selected @endif>Transferencia/depósito</option>
														<option value="mercadopago" @if(old('medio_pago') == 'mercadopago') selected @endif>Mercadopago</option>
													</select>
													@error('medio_pago')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>
	
										<div class="form-group @error('comentario') has-error @enderror">
											<label>Comentarios (opcional)</label>
											<input type="text" class="form-control" name="comentario" value="{{ old('comentario') }}">
											@error('comentario')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>	

										<div style="text-align:right">
											<button class="btn btn-primary" onclick="event.preventDefault();if(confirm('¿Registrar pago? No se puede deshacer.')) $('#pago_form').submit();">Registrar movimiento</button>
										</div>
									</form>

								</div>
							</div>
						</div>

						
					</div>
@endsection




@section('custom-js')
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{

			$('#input_fecha_movimiento').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: '-7d',
				endDate: 'today'
			});


			$("#select_tipo_movimiento").change(function() {

				if($(this).val() == "pago_de_chofer") {
					$("#select_medio_pago").prop("disabled", false);
				}
				else {
					$("#select_medio_pago").prop("disabled", true);
				}

			});


			$("#select_tipo_movimiento").trigger("change");


		});


	</script>	
@endsection