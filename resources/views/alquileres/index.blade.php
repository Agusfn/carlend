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
										<td>{{ App\Lib\Strings::formatearMoneda($alquiler->precio_diario, 0) }}</td>
										<td><span style="@if($alquiler->saldo_actual < 0) color: #B00 @endif">
											{{ App\Lib\Strings::formatearMoneda($alquiler->saldo_actual, 0) }}
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