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
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="fecha_desc" {{ request()->orden == "fecha_desc" ? "selected" : "" }}>Realizado recientemente</option>
										<option value="nombre_veh_asc" {{ request()->orden == "nombre_veh_asc" ? "selected" : "" }}>Nombre de vehiculo (A-Z)</option>
										<option value="monto_asc" {{ request()->orden == "monto_asc" ? "selected" : "" }}>Monto (menor a mayor)</option>
										<option value="monto_desc" {{ request()->orden == "monto_desc" ? "selected" : "" }}>Monto (mayor a menor)</option>
										<option value="nombre_prov_asc" {{ request()->orden == "nombre_prov_asc" ? "selected" : "" }}>Nombre de proveedor (A-Z)</option>
										<option value="nombre_prov_desc" {{ request()->orden == "nombre_prov_desc" ? "selected" : "" }}>Nombre de proveedor (Z-A)</option>
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
									Filtrar por tipo de gasto
									<select class="form-control filter-select" name="tipo_gasto" autocomplete="off">
										<option value="todos" {{ request()->tipo_gasto == "todos" ? "selected" : "" }}>Todos</option>
										<option value="seguro_vehiculo" {{ request()->tipo_gasto == "seguro_vehiculo" ? "selected" : "" }}>Seguro de vehículo</option>
										<option value="impuesto_automotor" {{ request()->tipo_gasto == "impuesto_automotor" ? "selected" : "" }}>Impuesto automotor</option>
										<option value="otro" {{ request()->tipo_gasto == "otro" ? "selected" : "" }}>Otro</option>
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
										<th>Monto</th>
										<th>Detalle</th>
										<th>Vehículo</th>
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
										<td>{{ __('tipos_gastos_adicionales.'.$gastoAdicional->tipo) }}</td>
										<td>{{ Strings::formatearMoneda($gastoAdicional->monto, 2) }}</td>
										<td>{{ Str::limit($gastoAdicional->detalle, 40, '...') }}</td>
										<td>{{ $gastoAdicional->vehiculo ? $gastoAdicional->vehiculo->marcaModeloYDominio() : '-' }}</td>
										<td>{{ __('medios_pago.'.$gastoAdicional->medio_pago) }}</td>
										<td>{{ $gastoAdicional->proveedor ? $gastoAdicional->proveedor->nombre : '-' }}</td>
									</tr>
									@endforeach

									@if($gastosAdicionales->count() == 0)
									<tr><td colspan="9" style="text-align: center;">No se registraron gastos adicionales.</td></tr>
									@endif

								</tbody>
							</table>

							<div style="text-align: center;">
								{{ $gastosAdicionales->appends(request()->input())->links() }}
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-md-6">

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Gastos con débito automático</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse compact"><i class="lnr lnr-chevron-up"></i></button>
									</div>
								</div>
								<div class="panel-body">

									<h5>Gastos que se registran automáticamente todos los meses (con tarjeta de crédito)</h5>

									<table class="table">
										<thead>
											<tr>
												<th>Día del mes débito</th>
												<th>Vehiculo</th>
												<th>Tipo de gasto</th>
												<th>Monto</th>
											</tr>
										</thead>
										<tbody>
											@foreach($vehiculosConDebito as $vehiculo)

												@if($vehiculo->tieneDebitoAutomPatentes())
												<tr>
													<td>{{ $vehiculo->dia_del_mes_debito_imp_automotor }}</td>
													<td>{{ $vehiculo->marcaModeloYDominio() }}</td>
													<td>Impuesto automotor</td>
													<td>{{ Strings::formatearMoneda($vehiculo->costo_mensual_imp_automotor, 2) }}</td>
												</tr>
												@endif

												@if($vehiculo->tieneDebitoAutomSeguro())
												<tr>
													<td>{{ $vehiculo->dia_del_mes_debito_seguro }}</td>
													<td>{{ $vehiculo->marcaModeloYDominio() }}</td>
													<td>Seguro</td>
													<td>{{ Strings::formatearMoneda($vehiculo->costo_mensual_seguro, 2) }}</td>
												</tr>
												@endif

											@endforeach

										</tbody>
									</table>

									
								</div>
							</div>

						</div>
					</div>



@endsection

