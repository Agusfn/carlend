@extends('layouts.main')

@section('title', 'Detalles de chofer')

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

					<h3 class="page-title"><a href="index.html">Choferes</a> / Juan Pérez</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group">
								<button class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar chofer</button>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del chofer</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="form-group">
											<label>Nombre y apellido</label>
											<input type="text" class="form-control" value="Juan Pérez">
										</div>
										<div class="form-group">
											<label>Teléfono</label>
											<input type="text" class="form-control" value="11 6711 4455">
										</div>
										<div class="form-group">
											<label>Dirección</label>
											<input type="text" class="form-control" value="Concordia G.C. 1338">
										</div>
										<div class="form-group">
											<label>DNI</label>
											<input type="number" class="form-control" value="35554332">
										</div>
										<div class="form-group">
											<label>Fecha de vto. de licencia</label>
											<input type="number" class="form-control" id="input_fecha_vto_licencia" value="29/07/2022">
										</div>
										<div class="form-group">
											<label>Notas</label>
											<textarea class="form-control" style="resize: vertical;">Recomendado por Marta</textarea>
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
									<h3 class="panel-title">Alquileres con este chofer</h3>
								</div>

								<div class="panel-body">

									<table class="table">
										<thead>
											<tr>
												<th></th>
												<th>ID #</th>
												<th>Estado</th>
												<th>Fecha inicio</th>
												<th>Fecha fin</th>
												<th>Vehículo</th>
												<th>Monto diario</th>
												<th>Saldo</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a href="detalles.html" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>4</td>
												<td><span class="label label-primary" style="font-size: 12px">En curso</span></td>
												<td>1 jul 2020</td>
												<td>-</td>
												<td>Renault Fluence (MKA 451)</td>
												<td>$2.000</td>
												<td><span style="color: #B00">-$4.200</td>
											</tr>
											<tr>
												<td><a href="" class="btn btn-primary btn-xs"><i class="fa fa-search-plus" aria-hidden="true"></i></a></td>
												<td>2</td>
												<td><span class="label label-default" style="font-size: 12px">Finalizado</span></td>
												<td>20 jun 2020</td>
												<td>29 jun 2020</td>
												<td>Renault Fluence (MKA 451)</td>
												<td>$2.000</td>
												<td><span>$&nbsp;-</td>
											</tr>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>


@endsection



@section('custom-js')
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{

			$('#input_fecha_vto_licencia').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: 'tomorrow'
			});


		});
	</script>
@endsection