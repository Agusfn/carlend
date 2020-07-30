@extends('layouts.main')

@section('title', 'Agregar proveedor')


@section('content')

					<h3 class="page-title"><a href="index.html">Proveedores</a> / Agregar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del proveedor</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="form-group">
											<label>Nombre</label>
											<input type="text" class="form-control">
										</div>

										<div class="form-group">
											<label>Dirección</label>
											<input type="text" class="form-control">
										</div>
										<div class="form-group">
											<label>Teléfono</label>
											<input type="text" class="form-control">
										</div>
										<div class="form-group">
											<label>Categoría</label>
											<select class="form-control">
												<option>Seleccionar</option>
												<option>Casa de repuestos</option>
												<option>Mecánico</option>
												<option>Chapista</option>
												<option>Gomería</option>
												<option>Service/Lubricentro</option>
												<option>Cerrajero</option>
												<option>Técnico de gas</option>
												<option>Electrónica</option>
												<option>Compañía de seguros</option>
											</select>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Agregar proveedor</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>

						<div class="col-md-6">
						</div>
					</div>



@endsection


