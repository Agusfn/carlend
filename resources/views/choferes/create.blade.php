@extends('layouts.main')

@section('title', 'Agregar chofer')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="index.html">Choferes</a> / Agregar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del chofer</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="form-group">
											<label>Nombre y apellido</label>
											<input type="text" class="form-control">
										</div>
										<div class="form-group">
											<label>Teléfono</label>
											<input type="text" class="form-control">
										</div>
										<div class="form-group">
											<label>Dirección</label>
											<input type="text" class="form-control">
										</div>
										<div class="form-group">
											<label>DNI</label>
											<input type="number" class="form-control">
										</div>
										<div class="form-group">
											<label>Fecha de vto. de licencia</label>
											<input type="number" class="form-control" id="input_fecha_vto_licencia" value="29/07/2022">
										</div>
										<div class="form-group">
											<label>Notas</label>
											<textarea class="form-control" style="resize: vertical;"></textarea>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Agregar chofer</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>

						<div class="col-md-6">
						</div>
					</div>



@endsection



@section('custom-js')
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
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