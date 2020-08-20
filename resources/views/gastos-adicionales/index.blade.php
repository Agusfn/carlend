@extends('layouts.main')

@section('title', 'Gastos adicionales')



@section('content')
					<h3 class="page-title">Gastos adicionales</h3>

					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Registro de gastos adicionales &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6;font-size: 17px" data-toggle="tooltip" data-placement="right" title="Registro de cualquier gasto no encuadrado en trabajos sobre vehículos: pago de seguros, patentes, compra de insumos, etc. Estos servirán para generar reportes completos de balances del negocio."></span></h3>

							<div class="right">
								<a href="{{ route('gastos-adicionales.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;&nbsp;Registrar nuevo gasto</a>
							</div>
						</div>

						<div class="panel-body">

							<div class="clearfix" style="margin-bottom: 10px">
								<div style="float: right;">
									Ordenar por
									<select class="form-control">
										<option>Realizado recientemente</option>
										<option>Nombre de vehiculo (A-Z)</option>
										<option>Monto (- a +)</option>
										<option>Monto (+ a -)</option>
										<option>Nombre de proveedor (A-Z)</option>
										<option>Nombre de proveedor (Z-A)</option>
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
									Filtrar por tipo de gasto
									<select class="form-control">
										<option>Todos</option>
										<option>Pago seguro</option>
										<option>Pago patentes</option>
										<option>Otro</option>
									</select>
								</div>
							</div>

							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>ID #</th>
										<th>Fecha</th>
										<th>Tipo de gasto</th>
										<th>Detalle</th>
										<th>Vehículo</th>
										<th>Monto</th>
										<th>Medio de pago</th>
										<th>Proveedor</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><a href="{{ route('gastos-adicionales.show', 1) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>5</td>
										<td>3 jul 2020</td>
										<td>Otro</td>
										<td>Compra bujías</td>
										<td>Renault Fluence (MKA 451)</td>
										<td>$1.000</td>
										<td>Tarjeta de crédito</td>
										<td>Repuestos José</td>
									</tr>
									<tr>
										<td><a href="" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>4</td>
										<td>16 jun 2020</td>
										<td>Pago de seguro</td>
										<td>-</td>
										<td>Renault Fluence (MKA 451)</td>
										<td>$5.500</td>
										<td>Tarjeta de crédito</td>
										<td>Provincia Seguros</td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>

					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Gastos con débito automático</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse compact"><i class="lnr lnr-chevron-up"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<div class="alert alert-info">
								Actualmente hay 1 gasto que se registra automáticamente cada mes, con tarjeta de crédito:
								<ul>
									<li>El pago de Provincia Seguros por $5.500 del Renault Fluence (MKA 451), el día 16 de cada mes.</li>
								</ul>
							</div>
						</div>
					</div>
@endsection

