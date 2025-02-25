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
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="fecha_desc" {{ request()->orden == "fecha_desc" ? "selected" : "" }}>Creado recientemente</option>
										<option value="modif_desc" {{ request()->orden == "modif_desc" ? "selected" : "" }}>Modificado recientemente</option>
										<option value="dominio_asc" {{ request()->orden == "dominio_asc" ? "selected" : "" }}>Patente (A-Z)</option>
										<option value="marca_modelo_asc" {{ request()->orden == "marca_modelo_asc" ? "selected" : "" }}>Marca y modelo (A-Z)</option>
										<option value="anio_asc" {{ request()->orden == "anio_asc" ? "selected" : "" }}>Año (menor a mayor)</option>
									</select>
								</div>
							</div>

							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>Patente</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Estado</th>
										<th>Chofer</th>
										<th>Año</th>
										<th>Proveedor seguro</th>
										<th>KMs actuales est.</th>
									</tr>
								</thead>
								<tbody>
									@foreach($vehiculos as $vehiculo)
									<tr>
										<td>
											<a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
											@if($vehiculo->en_fecha_registro_kms)
											&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-info-circle" style="color: #41b7e6;font-size: 20px;" data-toggle="tooltip" data-placement="top" title="Se debe actualizar el kilometraje del vehículo." aria-hidden="true"></i>
											@endif
										</td>
										<td>{{ $vehiculo->dominio }}</td>
										<td>{{ $vehiculo->marca }}</td>
										<td>{{ $vehiculo->modelo }}</td>
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
										<td>{{ $vehiculo->anio }}</td>
										<td>@if($vehiculo->proveedorSeguro) {{ $vehiculo->proveedorSeguro->nombre }} @else - @endif</td>
										<td>
											@if($vehiculo->puedeEstimarKilometraje())
											{{ Strings::formatearEntero($vehiculo->estimarKilometraje(Carbon\Carbon::today())) }}
											@else
											-
											@endif
										</td>
									</tr>									
									@endforeach		

									@if($vehiculos->count() == 0)
									<tr><td colspan="9" style="text-align: center;">No se encontraron vehículos.</td></tr>
									@endif


								</tbody>
							</table>
							
							<div style="text-align: center;">
								{{ $vehiculos->appends(request()->input())->links() }}
							</div>

						</div>
					</div>
@endsection

