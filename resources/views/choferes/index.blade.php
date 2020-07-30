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

							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Nombre y apellido</th>
										<th>DNI</th>
										<th>Teléfono</th>
										<th>Dirección</th>
										<th>Comentarios</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><a href="{{ route('choferes.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Juan Pérez</td>
										<td>35554332</td>
										<td>11 6711 4455</td>
										<td>Concordia G.C. 1338</td>
										<td>Recomendado por Marta</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>Ignacio Gutierrez</td>
										<td>31452369</td>
										<td>11 88756978</td>
										<td>Tucumán 2456, Pilar</td>
										<td></td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>
@endsection