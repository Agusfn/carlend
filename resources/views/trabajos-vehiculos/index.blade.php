@extends('layouts.main')

@section('title', 'Trabajos sobre vehículos')



@section('content')
					<h3 class="page-title">Trabajos sobre vehículos</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Listado de trabajos</h3>

							<div class="right">
								<a href="{{ route('trabajos-vehiculos.create') }}" class="btn btn-primary"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Registrar nuevo trabajo</a>
							</div>
						</div>

						<div class="panel-body">

							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Pagado recientemente</option>
										<option>Realizado recientemente</option>
										<option>Patente vehiculo (A-Z)</option>
										<option>Costo (- a +)</option>
										<option>Costo (+ a -)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar medio de pago
									<select class="form-control">
										<option>Todos</option>
										<option>Efectivo</option>
										<option>Tarjeta de crédito</option>
										<option>Transf./depósito</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar tipo de trabajo
									<select class="form-control">
										<option>Todos</option>
										<option>Cambio aceite y filtro</option>
										<option>Cambio de bateria</option>
										<option>Cambio de frenos</option>
										<option>Cambio correa distrib.</option>
										<option>Cambio correa altern.</option>
										<option>Cambio de cubiertas</option>
										<option>Reparación</option>
										<option>Otro</option>
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
										<th>Fecha pagado</th>
										<th>Vehículo</th>
										<th>Tipo de trabajo</th>
										<th>Observaciones</th>
										<th>Proveedor</th>
										<th>Costo</th>
										<th>Medio de pago</th>
										<th>Fecha realizado</th>
									</tr>
								</thead>
								<tbody>

									<tr>
										<td>
											<a href="{{ route('trabajos-vehiculos.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-exclamation-triangle" style="color: orange;font-size: 17px;" data-toggle="tooltip" data-placement="top" title="No se ingresó aún la fecha en la que se realizó el trabajo." aria-hidden="true"></i>
										</td>
										<td>3 jul 2020</td>
										<td>Fluence (MKA 451)</td>
										<td>Otro</td>
										<td>Cambio de bujías</td>
										<td>-</td>
										<td>$1.200</td>
										<td>Tarjeta de crédito</td>
										<td>-</td>
									</tr>
									<tr>
										<td><a href="detalles2.html" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>25 jun 2020</td>
										<td>Fluence (MKA 451)</td>
										<td>Reparación</td>
										<td>Arreglo manguera rota</td>
										<td>Mariano mecánico</td>
										<td>$2.000</td>
										<td>Efectivo</td>
										<td>25 jun 2020</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>10 jun 2020</td>
										<td>Fluence (MKA 451)</td>
										<td>Cambio de piezas de frenos</td>
										<td>En Norauto olivos</td>
										<td>-</td>
										<td>$3.000</td>
										<td>Tarjeta de crédito</td>
										<td>10 jun 2020</td>
									</tr>

									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>8 may 2020</td>
										<td>Fluence (MKA 451)</td>
										<td>Service</td>
										<td></td>
										<td>Jumax</td>
										<td>$2.500</td>
										<td>Efectivo</td>
										<td>8 may 2020</td>
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