@extends('layouts.main')

@section('title', 'Registrar alquiler')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / Registrar nuevo alquiler</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del alquiler</h3>
								</div>

								<div class="panel-body">

									<form method="POST" action="{{ route('alquileres.store') }}">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Fecha de inicio</label>
													<input type="text" class="form-control" value="{{ Carbon\Carbon::today()->format('d/m/Y') }}" readonly="">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('fecha_fin') has-error @enderror">
													
													<label>Fecha de fin</label>
													
													<label class="fancy-checkbox">
														<input type="checkbox" name="alquiler_indefinido" id="checkbox_fin_alquiler_indefinido" @if(old('alquiler_indefinido')) checked @endif>
														<span>Sin fecha definida (el alquiler se termina manualmente)</span>
													</label>
													
													<input type="text" name="fecha_fin" class="form-control" id="input_fecha_fin_alquiler" value="{{ old('fecha_fin') }}">
													
													@error('fecha_fin')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('id_chofer') has-error @enderror">
													<label>Chofer</label>
													
													<select class="form-control" name="id_chofer">
														<option value="">Seleccionar</option>
														
														@foreach($choferesDisponibles as $chofer)
															<option value="{{ $chofer->id }}" @if(old('id_chofer') == $chofer->id) selected @endif>{{ $chofer->nombre_y_apellido }}</option>
														@endforeach

													</select>

													@error('id_chofer')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group @error('id_vehiculo') has-error @enderror">
													<label>Vehículo</label>
													
													<select class="form-control" name="id_vehiculo">
														<option value="">Seleccionar</option>

														@foreach($vehiculosDisponibles as $vehiculo)
															<option value="{{ $vehiculo->id }}" @if(old('id_vehiculo') == $vehiculo->id) selected @endif>{{ $vehiculo->marcaModeloYDominio() }}</option>
														@endforeach

													</select>

													@error('id_vehiculo')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>





										<div class="row">
											<div class="col-sm-6">
												<div class="form-group @error('precio_diario') has-error @enderror">
													<label>Monto diario de alquiler ($)&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="El alquiler tendrá una cuenta corriente desde donde se descontará este monto diariamente, y paralelamente, se deberán registrar los pagos del chofer manualmente."></span></label>
													
													<input type="number" name="precio_diario" step="0.01" min="0" class="form-control" value="{{ old('precio_diario') }}">
													
													@error('precio_diario')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Descuento semanal</label>
													<label class="fancy-checkbox">
														<input type="checkbox" name="descuento_semanal" @if(old('descuento_semanal')) checked @endif>
														<span>No cobrar el alquiler de los días domingo</span>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group @error('notas') has-error @enderror">
											<label>Notas</label>
											<textarea class="form-control" name="notas" style="resize: vertical;">{{ old('notas') }}</textarea>
											@error('notas')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar alquiler</button>
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


			// Config
			$('[data-toggle="tooltip"]').tooltip();

			$('#input_fecha_fin_alquiler').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: '+1d',
				endDate: '+1y'
			});


			$("#checkbox_fin_alquiler_indefinido").change(function() {
				$("#input_fecha_fin_alquiler").prop("disabled", $(this).prop("checked"));
			})


			// Actions
			$("#checkbox_fin_alquiler_indefinido").trigger("change");

		});


	</script>	
@endsection