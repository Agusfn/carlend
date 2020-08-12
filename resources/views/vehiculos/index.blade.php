@extends('layouts.main')

@section('title', 'Vehiculos')



@section('content')
					<h3 class="page-title">Vehículos</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de vehículos</h3>

							<div class="right">
								<a href="{{ route('vehiculos.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar</a>
							</div>
						</div>

						<div class="panel-body">


							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Creado recientemente</option>
										<option>Modificado recientemente</option>
										<option>Patente (A-Z)</option>
										<option>Chofer (A-Z)</option>
										<option>Marca (A-Z)</option>
										<option>Año (- a +)</option>
										<option>KMs (- a +)</option>
										<option>KMs (+ a -)</option>
									</select>
								</div>
							</div>

							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>Patente</th>
										<th>Estado</th>
										<th>Chofer</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Año</th>
										<th>Proveedor seguro</th>
										<th>KMs actuales est.</th>
									</tr>
								</thead>
								<tbody>
									@foreach($vehiculos as $vehiculo)
									<tr>
										<td>
											<a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" data-toggle="tooltip" data-placement="top" title="Hay trabajos de mantenimiento que realizar en el vehículo." aria-hidden="true"></i>
										</td>
										<td>{{ $vehiculo->dominio }}</td>
										<td>
											@if($vehiculo->alquilerActual)
											<span class="label label-success" style="font-size: 14px">Alquilado</span>
											@else
											<span class="label label-default" style="font-size: 14px">Sin alquilar</span>
											@endif
										</td>
										<td>
											@if($vehiculo->alquilerActual)
											<a href="{{ route('choferes.show', $vehiculo->alquilerActual->chofer->id) }}">{{ $vehiculo->alquilerActual->chofer->nombre_y_apellido }}</a>
											@else
											-
											@endif
										</td>
										<td>{{ $vehiculo->marca }}</td>
										<td>{{ $vehiculo->modelo }}</td>
										<td>{{ $vehiculo->anio }}</td>
										<td>@if($vehiculo->proveedorSeguro) {{ $vehiculo->proveedorSeguro->nombre }} @else - @endif</td>
										<td>{{ App\Lib\Strings::formatearEntero($vehiculo->kilometraje_prediccion_actual) }}</td>
									</tr>									
									@endforeach									
								</tbody>
							</table>

						</div>
					</div>
@endsection


@section('custom-js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
@endsection