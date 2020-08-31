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
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="creado_desc" {{ request()->orden == 'creado_desc' ? "selected" : "" }}>Creado recientemente</option>
										<option value="modif_desc" {{ request()->orden == 'modif_desc' ? "selected" : "" }}>Modificado recientemente</option>
										<option value="nombre_asc" {{ request()->orden == 'nombre_asc' ? "selected" : "" }}>Nombre (A-Z)</option>
										<option value="nombre_desc" {{ request()->orden == 'nombre_desc' ? "selected" : "" }}>Nombre (Z-A)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar categoría
									<select class="form-control filter-select" name="categoria" autocomplete="off">
										<option value="todas">Todas</option>
										@foreach($categoriasProveedores as $codCategoria => $nombreCategoria)
										<option value="{{ $codCategoria }}" {{ request()->categoria == $codCategoria ? "selected" : "" }}>{{ $nombreCategoria }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th></th>
											<th>Nombre</th>
											<th>Dirección</th>
											<th>Teléfono</th>
											<th>Categoría/tipo proveedor</th>
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

										@if($proveedores->count() == 0)
										<tr><td colspan="5" style="text-align: center;">No se encontraron proveedores.</td></tr>
										@endif

									</tbody>
								</table>
							</div>
							<div style="text-align: center;">
								{{ $proveedores->appends(request()->input())->links() }}
							</div>

						</div>
					</div>
@endsection