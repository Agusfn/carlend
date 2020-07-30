@extends('layouts.main')

@section('title', 'Alquileres')



@section('content')
					<h3 class="page-title">Alquileres</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de alquileres</h3>

							<div class="right">
								<a href="{{ route('alquileres.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Registrar nuevo alquiler</a>
							</div>
						</div>

						<div class="panel-body">

							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Iniciado recientemente</option>
										<option>Nombre de chofer (A-Z)</option>
										<option>Nombre de vehiculo (A-Z)</option>
										<option>Monto diario (- a +)</option>
										<option>Monto diario (+ a -)</option>
										<option>Saldo (- a +)</option>
										<option>Saldo (+ a -)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar por estado
									<select class="form-control">
										<option>Todos</option>
										<option>Activo</option>
										<option>Finalizado</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar por vehículo
									<select class="form-control">
										<option>Todos</option>
										<option>Fluence (MKA 451)</option>
										<option>Onix (NBX 159)</option>
									</select>
								</div>

							</div>

							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th>ID #</th>
										<th>Estado</th>
										<th>Fecha inicio</th>
										<th>Fecha fin</th>
										<th>Chofer</th>
										<th>Vehículo</th>
										<th>Monto diario</th>
										<th>Saldo</th>
										<th>Ingresos a hoy</th>
										<th>Notas</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><a href="{{ route('alquileres.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>4</td>
										<td><span class="label label-primary" style="font-size: 14px">En curso</span></td>
										<td>1 jul 2020</td>
										<td>-</td>
										<td>Juan Pérez</td>
										<td>Renault Fluence (MKA 451)</td>
										<td>$2.000</td>
										<td><span style="color: #B00">-$4.200</td>
										<td>$2.800</td>
										<td><span class="glyphicon glyphicon-comment" style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="Paga en efectivo dia por medio"></span></td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>3</td>
										<td><span class="label label-default" style="font-size: 14px">Finalizado</span></td>
										<td>25 jun 2020</td>
										<td>7 jul 2020</td>
										<td>Ignacio Gutierrez</td>
										<td>Chevrolet Onix (NBX 159)</td>
										<td>$1.900</td>
										<td><span style="color: #B00">-$50</td>
										<td>$24.700</td>
										<td></td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>2</td>
										<td><span class="label label-default" style="font-size: 14px">Finalizado</span></td>
										<td>20 jun 2020</td>
										<td>29 jun 2020</td>
										<td>Juan Pérez</td>
										<td>Renault Fluence (MKA 451)</td>
										<td>$2.000</td>
										<td><span>$&nbsp;-</td>
										<td>$18.000</td>
										<td><span class="glyphicon glyphicon-comment" style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="Averiguar tema siniestro 25/06"></span></td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>1</td>
										<td><span class="label label-default" style="font-size: 14px">Finalizado</span></td>
										<td>2 jun 2020</td>
										<td>19 jun 2020</td>
										<td>Ignacio Gutierrez</td>
										<td>Chevrolet Onix (NBX 159)</td>
										<td>$1.800</td>
										<td><span>$&nbsp;-</td>
										<td>$30.600</td>
										<td></td>
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