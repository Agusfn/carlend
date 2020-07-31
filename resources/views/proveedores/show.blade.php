@extends('layouts.main')

@section('title', 'Detalles de proveedor')


@section('content')

					<h3 class="page-title"><a href="{{ route('proveedores.index') }}">Proveedores</a> / Mariano mecánico (ID #4)</h3>

						<div class="panel panel-headline">
							<div class="panel-body">
								<div class="btn-group">
									<button class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar proveedor</button>
								</div>
							</div>
						</div>

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
											<input type="text" class="form-control" value="Mariano mecánico">
										</div>

										<div class="form-group">
											<label>Dirección</label>
											<input type="text" class="form-control" value="Asunción 1453, Tortuguitas">
										</div>
										<div class="form-group">
											<label>Teléfono</label>
											<input type="text" class="form-control" value="11 54210368">
										</div>
										<div class="form-group">
											<label>Categoría</label>
											<select class="form-control">
												<option>Seleccionar</option>
												<option>Casa de repuestos</option>
												<option selected="">Mecánico</option>
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
											<button class="btn btn-primary">Guardar</button>
										</div>
									</form>
									

								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Trabajos recientes</h3>
								</div>

								<div class="panel-body">

									<table class="table">
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
											<tr>
												<td><a href="detalles2.html" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>25 jun 2020</td>
												<td>Fluence (MKA 451)</td>
												<td>Reparación</td>
												<td>$2.000</td>
												<td>Efectivo</td>
												<td>25 jun 2020</td>
											</tr>
										</tbody>
									</table>


								</div>
							</div>
						</div>
					</div>



@endsection

