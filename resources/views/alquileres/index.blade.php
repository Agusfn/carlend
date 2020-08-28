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
									<select class="form-control filter-select" name="orden" autocomplete="off">
										<option value="fecha_inicio_desc" {{ request()->orden == "fecha_inicio_desc" ? "selected" : "" }}>Iniciado recientemente</option>
										<option value="nombre_chofer_asc" {{ request()->orden == "nombre_chofer_asc" ? "selected" : "" }}>Nombre de chofer (A-Z)</option>
										<option value="nombre_vehiculo_asc" {{ request()->orden == "nombre_vehiculo_asc" ? "selected" : "" }}>Nombre de vehiculo (A-Z)</option>
										<option value="monto_diario_asc" {{ request()->orden == "monto_diario_asc" ? "selected" : "" }}>Monto diario (menor a mayor)</option>
										<option value="monto_diario_desc" {{ request()->orden == "monto_diario_desc" ? "selected" : "" }}>Monto diario (mayor a menor)</option>
										<option value="saldo_asc" {{ request()->orden == "saldo_asc" ? "selected" : "" }}>Saldo (menor a mayor)</option>
										<option value="saldo_desc" {{ request()->orden == "saldo_desc" ? "selected" : "" }}>Saldo (mayor a menor)</option>
									</select>
								</div>

								<div style="float: right; margin-right: 40px">
									Filtrar por estado
									<select class="form-control filter-select" name="estado" autocomplete="off">
										<option value="todos" {{ request()->estado == "todos" ? "selected" : "" }}>Todos</option>
										<option value="en_curso" {{ request()->estado == "en_curso" ? "selected" : "" }}>Activo</option>
										<option value="finalizado" {{ request()->estado == "finalizado" ? "selected" : "" }}>Finalizado</option>
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

							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>ID #</th>
										<th>Estado</th>
										<th>Vehículo</th>
										<th>Fecha inicio</th>
										<th>Fecha fin</th>
										<th>Chofer</th>
										<th>Monto diario</th>
										<th>Saldo</th>
										<th>Notas</th>
									</tr>
								</thead>
								<tbody>
									
									@foreach($alquileres as $alquiler)
									<tr>
										<td><a href="{{ route('alquileres.show', $alquiler->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
										<td>{{ $alquiler->id }}</td>
										<td>
											@if($alquiler->estaEnCurso())
											<span class="label label-primary" style="font-size: 14px">En curso</span>
											@elseif($alquiler->estaFinalizado())
											<span class="label label-default" style="font-size: 14px">Finalizado</span>
											@endif
										</td>
										<td>{{ $alquiler->vehiculo->marcaModeloYDominio() }}</td>
										<td>{{ $alquiler->fecha_inicio->isoFormat('D MMM Y') }}</td>
										<td>{{ $alquiler->fecha_fin ? $alquiler->fecha_fin->isoFormat('D MMM Y') : '-' }}</td>
										<td>{{ $alquiler->chofer->nombre_y_apellido }}</td>
										<td>{{ Strings::formatearMoneda($alquiler->precio_diario, 0) }}</td>
										<td><span style="@if($alquiler->saldo_actual < 0) color: #B00 @endif">
											{{ Strings::formatearMoneda($alquiler->saldo_actual, 0) }}
										</span></td>
										<td>
											@if($alquiler->notas)
											<span class="glyphicon glyphicon-comment" style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="{{ $alquiler->notas }}"></span>
											@endif
										</td>
									</tr>
									@endforeach

									@if($alquileres->count() == 0)
									<tr><td colspan="10" style="text-align: center;">No se encontraron alquileres.</td></tr>
									@endif

								</tbody>
							</table>

							<div style="text-align: center;">
								{{ $alquileres->appends(request()->input())->links() }}
							</div>

						</div>
					</div>

@endsection

