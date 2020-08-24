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
									@foreach($gastosAdicionales as $gastoAdicional)
									<tr>
										<td><a href="{{ route('gastos-adicionales.show', $gastoAdicional->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>{{ $gastoAdicional->id }}</td>
										<td>{{ $gastoAdicional->fecha->isoFormat('D MMM Y') }}</td>
										<td>
											@if($gastoAdicional->tipo == 'seguro_vehiculo')
											Seguro de vehículo
											@elseif($gastoAdicional->tipo == 'impuesto_automotor')
											Impuesto automotor
											@elseif($gastoAdicional->tipo == 'otro')
											Otro
											@endif
										</td>
										<td>{{ Str::limit($gastoAdicional->detalle, 40, '...') }}</td>
										<td>{{ $gastoAdicional->vehiculo ? $gastoAdicional->vehiculo->marcaModeloYDominio() : '-' }}</td>
										<td>{{ App\Lib\Strings::formatearMoneda($gastoAdicional->monto, 2) }}</td>
										<td>{{ __('medios_pago.'.$gastoAdicional->medio_pago) }}</td>
										<td>{{ $gastoAdicional->proveedor ? $gastoAdicional->proveedor->nombre : '-' }}</td>
									</tr>
									@endforeach

									@if($gastosAdicionales->count() == 0)
									<tr><td colspan="9" style="text-align: center;">No se registraron gastos adicionales.</td></tr>
									@endif

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

