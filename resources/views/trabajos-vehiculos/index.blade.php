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

							<table class="table table-striped">
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

									@foreach($trabajosVehiculos as $trabajo)

									<tr>
										<td>
											<a href="{{ route('trabajos-vehiculos.show', $trabajo->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
										</td>
										<td>{{ $trabajo->fecha_pagado->isoFormat('D MMM Y') }}</td>
										<td>{{ $trabajo->vehiculo->marcaModeloYDominio() }}</td>
										<td>{{ __('tipos_trabajos.'.$trabajo->tipo) }}</td>
										<td>{{ Str::limit($trabajo->observaciones, 25, '...') }}</td>
										<td>{{ $trabajo->proveedor ? $trabajo->proveedor->nombre : '-' }}</td>
										<td>{{ $trabajo->costo_total > 0 ? App\Lib\Strings::formatearMoneda($trabajo->costo_total, 0) : '-' }}</td>
										<td>{{ $trabajo->costo_total > 0 ? __('medios_pago.'.$trabajo->medio_pago) : '-' }}</td>
										<td>{{ $trabajo->fecha_realizado->isoFormat('D MMM Y') }}</td>
									</tr>

									@endforeach

									@if($trabajosVehiculos->count() == 0)
									<tr><td colspan="9" style="text-align: center;">No se encontraron trabajos.</td></tr>
									@endif

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