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
									<tr>
										<td><a href="{{ route('proveedores.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Mariano mecánico</td>
										<td>Asunción 1453, Tortuguitas</td>
										<td>11 54210368</td>
										<td>Mecánico</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Repuestos José</td>
										<td>Ruta 26 y Lisandro de la Torre, Del Viso</td>
										<td>0230-4476654</td>
										<td>Casa de repuestos</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Provincia Seguros</td>
										<td>Ruta 8 y Las Magnolias, Pilar</td>
										<td>0230-2123452</td>
										<td>Compañía de seguros</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Jumax</td>
										<td>Colectora Oeste Ramal Pilar 1441</td>
										<td>11 69945302</td>
										<td>Service/Lubricentro</td>
									</tr>

								</tbody>
							</table>

						</div>
					</div>
@endsection