@extends('layouts.main')

@section('title', 'Registrar nuevo pago a alquiler')
  

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection



@section('content')
					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / <a href="detalles.html">Alquiler #4</a> / Registrar pago o movimiento</h3>


					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del movimiento</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('alquileres.registrar-pago', $alquiler->id) }}" method="POST">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('fecha') has-error @enderror">
													<label>Fecha del movimiento</label>
													<input type="text" name="fecha" class="form-control" id="input_fecha_movimiento">
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
														<option value="{{ App\MovimientoAlquiler::TIPO_PAGO_DE_CHOFER }}">Pago de chofer</option>
														<option value="{{ App\MovimientoAlquiler::TIPO_DESCUENTO }}">Descuento</option>
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
													<input type="number" step="0.01" min="0" name="monto" class="form-control">
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
														<option value="{{ App\MovimientoAlquiler::MEDIO_PAGO_EFECTIVO }}">Efectivo</option>
														<option value="{{ App\MovimientoAlquiler::MEDIO_PAGO_TRANSFERENCIA }}">Transferencia/depósito</option>
														<option value="{{ App\MovimientoAlquiler::MEDIO_PAGO_MERCADOPAGO }}">Mercadopago</option>
													</select>
													@error('medio_pago')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>
	
										<div class="form-group @error('comentario') has-error @enderror">
											<label>Comentarios</label>
											<input type="text" class="form-control" name="comentario">
											@error('comentario')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>	

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar movimiento</button>
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

			$('[data-toggle="tooltip"]').tooltip();

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