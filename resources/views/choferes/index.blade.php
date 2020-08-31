@extends('layouts.main')

@section('title', 'Choferes')



@section('content')
					<h3 class="page-title">Choferes</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de choferes</h3>

							<div class="right">
								<a href="{{ route('choferes.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar</a>
							</div>
						</div>

						<div class="panel-body">

							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="fecha_desc" {{ request()->orden == "fecha_desc" ? "selected" : "" }}>Creado recientemente</option>
										<option value="modif_desc" {{ request()->orden == "modif_desc" ? "selected" : "" }}>Modificado recientemente</option>
										<option value="nombre_asc" {{ request()->orden == "nombre_asc" ? "selected" : "" }}>Nombre y apellido (A-Z)</option>
										<option value="nombre_desc" {{ request()->orden == "nombre_desc" ? "selected" : "" }}>Nombre y apellido (Z-A)</option>
									</select>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th></th>
											<th>Nombre y apellido</th>
											<th>DNI</th>
											<th>Teléfono</th>
											<th>Dirección</th>
											<th>Estado</th>
											<th>Vehiculo alquilado</th>
											<th>Notas</th>
										</tr>
									</thead>
									<tbody>
										@foreach($choferes as $chofer)
										<tr>
											<td><a href="{{ route('choferes.show', $chofer->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
											<td>{{ $chofer->nombre_y_apellido }}</td>
											<td>{{ $chofer->dni }}</td>
											<td>{{ $chofer->telefono }}</td>
											<td>{{ $chofer->direccion }}</td>
											<td>
												@if($chofer->alquilerActual)
												<span class="label label-success" style="font-size: 13px">Alquilando</span>
												@else
												<span class="label label-default" style="font-size: 13px">Disponible</span>
												@endif
											</td>
											<td>
												@if($chofer->alquilerActual)
												{{ $chofer->alquilerActual->vehiculo->marcaYModelo() }}
												@else
												-
												@endif
											</td>
											<td>{{ Str::limit($chofer->notas, 60, '...') }}</td>
										</tr>
										@endforeach

										@if($choferes->count() == 0)
										<tr><td colspan="6" style="text-align: center;">No se encontraron choferes.</td></tr>
										@endif

									</tbody>
								</table>
							</div>

							<div style="text-align: center;">
								{{ $choferes->appends(request()->input())->links() }}
							</div>
						</div>
					</div>
@endsection