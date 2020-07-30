@extends('layouts.main')

@section('title', 'Vehiculos')



@section('content')
					<h3 class="page-title">Vehículos</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de vehículos</h3>

							<div class="right">
								<a href="{{ route('vehiculos.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar</a>
							</div>
						</div>

						<div class="panel-body">


							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Creado recientemente</option>
										<option>Modificado recientemente</option>
										<option>Patente (A-Z)</option>
										<option>Chofer (A-Z)</option>
										<option>Marca (A-Z)</option>
										<option>Año (- a +)</option>
										<option>KMs (- a +)</option>
										<option>KMs (+ a -)</option>
									</select>
								</div>
							</div>

							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>Patente</th>
										<th>Estado</th>
										<th>Chofer</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Año</th>
										<th>Proveedor seguro</th>
										<th>KMs actuales est.</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<a href="{{ route('vehiculos.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" data-toggle="tooltip" data-placement="top" title="Hay trabajos de mantenimiento que realizar en el vehículo." aria-hidden="true"></i>
										</td>
										<td>MKA 451</td>
										<td><span class="label label-success" style="font-size: 14px">Alquilado</td>
										<td><a href="">Juan Pérez</a></td>
										<td>Renault</td>
										<td>Fluence</td>
										<td>2013</td>
										<td>Provincia Seguros</td>
										<td>145.000</td>
									</tr>

									<tr>
										<td>
											<a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" data-toggle="tooltip" data-placement="top" title="Se debe informar el kilometraje de julio de este auto." aria-hidden="true"></i>
										</td>
										<td>NBX 159</td>
										<td><span class="label label-default" style="font-size: 14px">Sin alquilar</td>
										<td>-</td>
										<td>Chevrolet</td>
										<td>Onix</td>
										<td>2015</td>
										<td>-</td>
										<td>122.000</td>
									</tr>									
								</tbody>
							</table>

						</div>
					</div>
@endsection


@section('custom-js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
@endsection