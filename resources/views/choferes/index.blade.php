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
									<select class="form-control">
										<option>Creado recientemente</option>
										<option>Modificado recientemente</option>
										<option>Nombre y apellido (A-Z)</option>
										<option>Nombre y apellido (Z-A)</option>
									</select>
								</div>
							</div>

							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>Nombre y apellido</th>
										<th>DNI</th>
										<th>Teléfono</th>
										<th>Dirección</th>
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
										<td>{{ Str::limit($chofer->notas, 60, '...') }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>

						</div>
					</div>
@endsection