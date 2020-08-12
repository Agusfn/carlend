@extends('layouts.main')

@section('title', 'Detalles de chofer')

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

					<h3 class="page-title"><a href="{{ route('choferes.index') }}">Choferes</a> / {{ $chofer->nombre_y_apellido }}</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group">
								<button class="btn btn-danger" onclick="if(confirm('¿Confirma eliminar chofer?')) $('#delete-form').submit();"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar chofer</button>
							</div>
							<form action="{{ route('choferes.destroy', $chofer->id) }}" method="POST" id="delete-form" style="display: none">
								@method('DELETE')
								@csrf
							</form>
						</div>
					</div>

					@if(session('success'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Los datos se actualizaron correctamente.
					</div>
					@endif

					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del chofer</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('choferes.update', $chofer->id) }}" method="POST">
										@method('PUT')
										@csrf
										<div class="form-group @error('nombre_y_apellido') has-error @enderror">
											<label>Nombre y apellido</label>
											<input type="text" name="nombre_y_apellido" class="form-control" value="{{ $chofer->nombre_y_apellido }}">
											@error('nombre_y_apellido')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('telefono') has-error @enderror">
											<label>Teléfono</label>
											<input type="text" name="telefono" class="form-control" value="{{ $chofer->telefono }}">
											@error('telefono')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('direccion') has-error @enderror">
											<label>Dirección</label>
											<input type="text" name="direccion" class="form-control" value="{{ $chofer->direccion }}">
											@error('direccion')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('dni') has-error @enderror">
											<label>DNI</label>
											<input type="number" name="dni" class="form-control" value="{{ $chofer->dni }}">
											@error('dni')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('fecha_vto_licencia') has-error @enderror">
											<label>Fecha de vto. de licencia</label>
											<input type="text" name="fecha_vto_licencia" class="form-control" id="input_fecha_vto_licencia" value="{{ $chofer->fecha_vto_licencia ? $chofer->fecha_vto_licencia->format('d/m/Y') : '' }}">
											@error('fecha_vto_licencia')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('notas') has-error @enderror">
											<label>Notas</label>
											<textarea class="form-control" name="notas" style="resize: vertical;">{{ $chofer->notas }}</textarea>
											@error('notas')
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

						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Alquileres con este chofer</h3>
								</div>

								<div class="panel-body">

									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>ID #</th>
												<th>Estado</th>
												<th>Fecha inicio</th>
												<th>Fecha fin</th>
												<th>Vehículo</th>
												<th>Monto diario</th>
												<th>Saldo</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="detalles.html" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>4</td>
												<td><span class="label label-primary" style="font-size: 12px">En curso</span></td>
												<td>1 jul 2020</td>
												<td>-</td>
												<td>Renault Fluence (MKA 451)</td>
												<td>$2.000</td>
												<td><span style="color: #B00">-$4.200</td>
											</tr>
											<tr>
												<td><a href="" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>2</td>
												<td><span class="label label-default" style="font-size: 12px">Finalizado</span></td>
												<td>20 jun 2020</td>
												<td>29 jun 2020</td>
												<td>Renault Fluence (MKA 451)</td>
												<td>$2.000</td>
												<td><span>$&nbsp;-</td>
											</tr>
										</tbody>
									</table>

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