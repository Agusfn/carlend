@extends('layouts.main')

@section('title', 'Registrar trabajo sobre vehículo')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="index.html">Trabajos sobre vehículos</a> / Registrar nuevo trabajo</h3>

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del trabajo</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="form-group">
											<label>Vehículo</label>
											<select class="form-control">
												<option>Renault Fluence (MKA 451)</option>
												<option>Chevrolet Onix (NBX 159)</option>
											</select>
										</div>
										<div class="form-group">
											<label>Tipo de trabajo</label>
											<select class="form-control">
												<option>Seleccionar</option>
												<option>Cambio de aceite y filtros</option>
												<option>Cambio de bateria</option>
												<option>Cambio de piezas de frenos</option>
												<option>Cambio de correa de distribución</option>
												<option>Cambio de correa alternador</option>
												<option>Cambio de cubiertas</option>
												<option>Reparación</option>
												<option>Otro</option>
											</select>
										</div>

										<div class="form-group">
											<label>Observaciones</label>
											<input type="text" class="form-control">
										</div>

										<div class="form-group">
											<label>Proveedor</label>
											<select class="form-control">
												<option>Seleccionar</option>
												<option>Repuestos José (Casa de repuestos)</option>
												<option>Jumax (Service/Lubricentro)</option>
												<option>Mariano mecánico (Mecánico)</option>
												<option>Otro proveedor no registrado</option>
											</select>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha pagado</label>
													<input type="text" class="form-control" id="input_fecha_pagado">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Costo total ($)</label>
													<input type="number" step="0.01" min="0" class="form-control">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Medio de pago</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Efectivo</option>
														<option>Tarjeta de crédito</option>
														<option>Transferencia bancaria</option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha realizado</label>
													<label class="fancy-checkbox">
														<input type="checkbox" id="checkbox_inform_job_date_later">
														<span>Informar más adelante</span>
													</label>
													<input type="text" class="form-control" id="input_fecha_realizado">
												</div>
											</div>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar trabajo</button>
										</div>
									</form>
									

								</div>
							</div>

						</div>
					</div>



@endsection



@section('custom-js')
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#input_fecha_pagado, #input_fecha_realizado').datepicker({
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