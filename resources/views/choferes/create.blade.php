@extends('layouts.main')

@section('title', 'Agregar chofer')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('choferes.index') }}">Choferes</a> / Agregar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del chofer</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('choferes.store') }}" method="POST">
										@csrf
										<div class="form-group @error('nombre_y_apellido') has-error @enderror">
											<label>Nombre y apellido</label>
											<input type="text" name="nombre_y_apellido" class="form-control" value="{{ old('nombre_y_apellido') }}">
											@error('nombre_y_apellido')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('telefono') has-error @enderror">
											<label>Teléfono</label>
											<input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
											@error('telefono')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('direccion') has-error @enderror">
											<label>Dirección</label>
											<input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
											@error('direccion')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('dni') has-error @enderror">
											<label>DNI</label>
											<input type="number" name="dni" class="form-control" value="{{ old('dni') }}">
											@error('dni')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('fecha_vto_licencia') has-error @enderror">
											
											<label>Fecha de vto. de licencia <span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Ingresá la fecha para que se te notifique por email y por el sitio 10 días antes del vencimiento, sino dejalo vacío."></span></label>

											<input type="text" name="fecha_vto_licencia" class="form-control" id="input_fecha_vto_licencia" value="{{ old('fecha_vto_licencia') }}">
											@error('fecha_vto_licencia')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('notas') has-error @enderror">
											<label>Notas</label>
											<textarea class="form-control" name="notas" style="resize: vertical;">{{ old('notas') }}</textarea>
											@error('notas')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Agregar chofer</button>
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
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{

			$('#input_fecha_vto_licencia').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: 'tomorrow'
			});


		});
	</script>
@endsection