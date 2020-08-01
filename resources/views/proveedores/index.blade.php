@extends('layouts.main')

@section('title', 'Proveedores')



@section('content')
					<h3 class="page-title">Proveedores</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de proveedores</h3>

							<div class="right">
								<a href="{{ route('proveedores.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar</a>
							</div>
						</div>

						<div class="panel-body">


							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Creado recientemente</option>
										<option>Modificado recientemente</option>
										<option>Nombre (A-Z)</option>
										<option>Nombre (Z-A)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar categoría
									<select class="form-control">
										<option>Todas</option>
										<option>Casa de repuestos</option>
										<option>Mecánico</option>
										<option>Chapista</option>
										<option>Gomería</option>
										<option>Service</option>
										<option>Cerrajero</option>
										<option>Técnico de gas</option>
										<option>Electrónica</option>
										<option>Aseguradora</option>
									</select>
								</div>
							</div>


							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Nombre</th>
										<th>Dirección</th>
										<th>Teléfono</th>
										<th>Categoría</th>
									</tr>
								</thead>
								<tbody>

									@foreach($proveedores as $proveedor)
									<tr>
										<td><a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>{{ $proveedor->nombre }}</td>
										<td>{{ $proveedor->direccion }}</td>
										<td>{{ $proveedor->telefono }}</td>
										<td>{{ $proveedor->nombreCategoria() }}</td>
									</tr>
									@endforeach

								</tbody>
							</table>

						</div>
					</div>
@endsection