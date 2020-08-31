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
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="fecha_pago_desc" {{ request()->orden == "fecha_pago_desc" ? "selected" : "" }}>Pagado recientemente</option>
										<option value="fecha_realizado_desc" {{ request()->orden == "fecha_realizado_desc" ? "selected" : "" }}>Realizado recientemente</option>
										<option value="costo_asc" {{ request()->orden == "costo_asc" ? "selected" : "" }}>Costo (menor a mayor)</option>
										<option value="costo_desc" {{ request()->orden == "costo_desc" ? "selected" : "" }}>Costo (mayor a menor)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar medio de pago
									<select class="form-control filter-select" name="medio_pago" autocomplete="off">
										<option value="todos" {{ request()->medio_pago == "todos" ? "selected" : "" }}>Todos</option>
										<option value="efectivo" {{ request()->medio_pago == "efectivo" ? "selected" : "" }}>Efectivo</option>
										<option value="tarjeta_credito" {{ request()->medio_pago == "tarjeta_credito" ? "selected" : "" }}>Tarjeta de crédito</option>
										<option value="transferencia" {{ request()->medio_pago == "transferencia" ? "selected" : "" }}>Transf./depósito</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar tipo de trabajo
									<select class="form-control filter-select" name="tipo_trabajo" autocomplete="off">
										<option value="todos">Todos</option>
										@foreach($tiposTrabajos as $tipoTrabajo)
										<option value="{{ $tipoTrabajo }}" {{ request()->tipo_trabajo == $tipoTrabajo ? "selected" : "" }}>
											{{ __('tipos_trabajos.'.$tipoTrabajo) }}
										</option>
										@endforeach
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar por vehículo
									<select class="form-control filter-select" name="vehiculo" autocomplete="off">
										<option value="todos">Todos</option>
										@foreach($vehiculos as $vehiculo)
										<option value="{{ $vehiculo->id }}" {{ request()->vehiculo == $vehiculo->id ? "selected" : "" }}>{{ $vehiculo->modeloYDominio() }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th></th>
											<th>Fecha pagado</th>
											<th>Vehículo</th>
											<th>Tipo de trabajo</th>
											
											<th>Costo</th>
											<th>Proveedor</th>
											<th>Observaciones</th>
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
											<td>{{ $trabajo->costo_total > 0 ? Strings::formatearMoneda($trabajo->costo_total, 0) : '-' }}</td>
											<td>{{ $trabajo->proveedor ? $trabajo->proveedor->nombre : '-' }}</td>
											<td>{{ Str::limit($trabajo->observaciones, 25, '...') }}</td>
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

							
							<div style="text-align: center;">
								{{ $trabajosVehiculos->appends(request()->input())->links() }}
							</div>

						</div>
					</div>
@endsection

