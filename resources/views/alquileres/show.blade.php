@extends('layouts.main')

@section('title', 'Detalles de alquiler')


@section('content')

					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / Alquiler #4</h3>

						<div class="panel panel-headline">
							<div class="panel-body">
								<div class="btn-group">
									<a href="{{ route('alquileres.registrar-pago', 1) }}" class="btn btn-primary"><span class="glyphicon glyphicon-usd"></span> Registrar pago de chofer</a>
									<button class="btn btn-default" style="margin-left: 15px">Terminar alquiler</button>
								</div>
							</div>
						</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del alquiler</h3>
								</div>

								<div class="panel-body">

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-4">
											<label>Estado:</label>&nbsp;&nbsp;&nbsp;<span class="label label-success" style="font-size: 14px;">Activo</span>
										</div>
										<div class="col-md-4">
											<label>Fecha inicio:</label> 1 jul 2020
										</div>
										<div class="col-md-4">
											<label>Fecha fin:</label> No definida
										</div>
									</div>

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-6">
											<label>Chofer:</label> <a href="">Juan Pérez</a>
										</div>
										<div class="col-md-6">
											<label>Vehículo:</label> <a href="">Renault Fluence (MKA 451)</a>
										</div>
									</div>

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-6">
											<label>Precio diario:</label> $2.000
										</div>
										<div class="col-md-6">
											<label>Descuento semanal:</label> Sí&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Si se omite el cobro diario en los días domingo."></span>
										</div>
									</div>

									<form>
										<div class="form-group">
											<label>Notas</label>
											<textarea class="form-control" style="resize: vertical;">Paga en efectivo dia por medio</textarea>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Guardar</button>
										</div>
									</form>

								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Cuenta corriente</h3>
								</div>

								<div class="panel-body">

									<div class="row">
										<div class="col-sm-6">
											<div style="font-size: 17px"><label>Saldo:</label> <span style="color: #B00;">-$4.200</span></div>
										</div>
										<div class="col-sm-6">
											<div style="font-size: 17px"><label>Ingresos totales:</label> $2.800</div>
										</div>
									</div>
									

									<h4>Movimientos</h4>

									<table class="table">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Concepto</th>
												<th>Monto</th>
												<th>Saldo</th>
												<th>Medio de pago</th>
												<th>Coment.</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>5 jul 2020</td>
												<td>Pago de chofer</td>
												<td>$800</td>
												<td><span style="color: #B00;">-$4.200</span></td>
												<td>Transferencia</td>
												<td></td>
											</tr>
											<tr>
												<td>5 jul 2020</td>
												<td>Cobro día de alquiler</td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td><span style="color: #B00;">-$5.000</span></td>
												<td>-</td>
												<td></td>
											</tr>
											<tr>
												<td>4 jul 2020</td>
												<td>Cobro día de alquiler</td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td><span style="color: #B00;">-$3.000</span></td>
												<td>-</td>
												<td></td>
											</tr>
											<tr>
												<td>3 jul 2020</td>
												<td>Descuento</td>
												<td>$1.000</td>
												<td><span style="color: #B00;">-$1.000</span></td>
												<td>-</td>
												<td><span class="glyphicon glyphicon-comment" style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="Descuento por visita taller 03/07"></span></td>
											</tr>
											<tr>
												<td>3 jul 2020</td>
												<td>Cobro día de alquiler</td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td>-</td>
												<td></td>
											</tr>
											<tr>
												<td>2 jul 2020</td>
												<td>Pago de chofer</td>
												<td>$2.000</td>
												<td>$ -</td>
												<td>Efectivo</td>
												<td></td>
											</tr>
											<tr>
												<td>2 jul 2020</td>
												<td>Cobro día de alquiler</td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td><span style="color: #B00;">-$2.000</span></td>
												<td>-</td>
												<td></td>
											</tr>
										</tbody>
									</table>	

								</div>
							</div>
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