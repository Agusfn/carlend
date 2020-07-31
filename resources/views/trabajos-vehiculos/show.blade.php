@extends('layouts.main')

@section('title', 'Detalles de trabajo')

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

					<h3 class="page-title"><a href="{{ route('trabajos-vehiculos.index') }}">Trabajos sobre vehículos</a> / Detalles del trabajo</h3>


					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del trabajo</h3>
								</div>

								<div class="panel-body">


									<div class="alert alert-warning">
										Ingresa la fecha de realización de este trabajo.
									</div>

									<form>
										<div class="form-group">
											<label>ID de trabajo</label>: #1
										</div>
										<div class="form-group">
											<label>Vehículo</label>: <a href="">Renault Fluence (MKA 451)</a>
										</div>
										<div class="form-group">
											<label>Tipo de trabajo</label>: Otro
										</div>

										<div class="form-group">
											<label>Observaciones</label>
											<input type="text" class="form-control" value="Cambio de bujías">
										</div>

										<div class="form-group">
											<label>Proveedor</label>: -
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha pagado</label>: 3 jul 2020
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Costo total ($)</label>: $1.200
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Medio de pago</label>: Tarjeta de crédito
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha realizado</label>
													<input type="text" class="form-control" id="input_fecha_realizado">
												</div>
											</div>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Actualizar trabajo</button>
										</div>
									</form>
									

								</div>
							</div>
						</div>

						
					</div>

@endsection



@section('custom-js')
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#input_fecha_realizado').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				startDate: '-7d',
				endDate: 'today'
			});

			$("#checkbox_inform_job_date_later").change(function() {

				if($(this).prop("checked")) {
					$("#input_fecha_realizado").val('').prop("disabled", true);
				}
				else {
					$("#input_fecha_realizado").prop("disabled", false);
				}

			});


		});
	</script>
@endsection