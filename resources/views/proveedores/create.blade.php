@extends('layouts.main')

@section('title', 'Agregar proveedor')


@section('content')

					<h3 class="page-title"><a href="{{ route('proveedores.index') }}">Proveedores</a> / Agregar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del proveedor</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('proveedores.store') }}" method="POST">
										@csrf

										<div class="form-group @error('nombre') has-error @enderror">
											<label>Nombre*</label>
											<input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
											@error('nombre')
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
										<div class="form-group @error('telefono') has-error @enderror">
											<label>Teléfono</label>
											<input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
											@error('telefono')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group @error('categoria') has-error @enderror">
											<label>Categoría*</label>
											<select class="form-control" name="categoria">
												<option>Seleccionar</option>
												@foreach(App\Proveedor::$nombresCategorias as $keyCategoria => $nombreCategoria)
												<option value="{{ $keyCategoria }}" @if(old('categoria') && old('categoria') == $keyCategoria) selected @endif>{{ $nombreCategoria }}</option>
												@endforeach
											</select>
											@error('categoria')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>
										<div class="form-group">
											Los campos con (*) son obligatorios.
										</div>
										<div style="text-align:right">
											<button class="btn btn-primary">Guardar</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>

						<div class="col-md-6">
						</div>
					</div>



@endsection


