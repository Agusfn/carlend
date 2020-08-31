@extends('layouts.main')

@section('title', 'Detalles de proveedor')


@section('content')

					<h3 class="page-title"><a href="{{ route('proveedores.index') }}">Proveedores</a> / {{ $proveedor->nombre }} (ID #{{ $proveedor->id }})</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group">
								<button class="btn btn-danger" onclick="if(confirm('¿Confirma eliminar el proveedor? No se puede deshacer.')) $('#delete-form').submit();"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar proveedor</button>
							</div>
							<form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" id="delete-form" style="display: none">
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
						<div class="col-md-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del proveedor</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
										@method('PUT')
										@csrf

										<div class="form-group @error('nombre') has-error @enderror">
											<label>Nombre</label>
											<input type="text" name="nombre" class="form-control" value="{{ $proveedor->nombre }}">
											@error('nombre')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group @error('direccion') has-error @enderror">
											<label>Dirección</label>
											<input type="text" name="direccion" class="form-control" value="{{ $proveedor->direccion }}">
											@error('direccion')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('telefono') has-error @enderror">
											<label>Teléfono</label>
											<input type="text" name="telefono" class="form-control" value="{{ $proveedor->telefono }}">
											@error('telefono')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('categoria') has-error @enderror">
											<label>Categoría</label>
											<select class="form-control" name="categoria">
												<option>Seleccionar</option>
												@foreach(App\Proveedor::$nombresCategorias as $keyCategoria => $nombreCategoria)
												<option value="{{ $keyCategoria }}" @if($proveedor->categoria == $keyCategoria) selected @endif>{{ $nombreCategoria }}</option>
												@endforeach
											</select>
											@error('categoria')
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

						<div class="col-md-6">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Trabajos recientes con este proveedor</h3>
								</div>

								<div class="panel-body">

									<div class="table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th></th>
													<th>Fecha pagado</th>
													<th>Vehículo</th>
													<th>Tipo de trabajo</th>
													<th>Costo</th>
													<th>Medio de pago</th>
													<th>Fecha realizado</th>
												</tr>
											</thead>
											<tbody>
												@foreach($ultimosTrabajos as $trabajo)
												<tr>
													<td><a href="{{ route('trabajos-vehiculos.show', $trabajo->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
													<td>{{ $trabajo->fecha_pagado->isoFormat('D MMM') }}</td>
													<td>{{ $trabajo->vehiculo->marcaYModelo() }}</td>
													<td>{{ __('tipos_trabajos.'.$trabajo->tipo) }}</td>
													<td>{{ $trabajo->costo_total > 0 ? Strings::formatearMoneda($trabajo->costo_total, 0) : '-' }}</td>
													<td>{{ $trabajo->costo_total > 0 ? __('medios_pago.'.$trabajo->medio_pago) : '-' }}</td>
													<td>{{ $trabajo->fecha_realizado->isoFormat('D MMM') }}</td>
												</tr>
												@endforeach

												@if($ultimosTrabajos->count() == 0)
												<tr><td colspan="7" style="text-align: center;">No se encontraron trabajos.</td></tr>
												@endif
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
					</div>



@endsection

