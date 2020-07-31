@extends('layouts.main')

@section('title', 'Agregar gasto')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('gastos-adicionales.index') }}">Gastos adicionales</a> / Registrar</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del gasto</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Fecha</label>
													<input type="text" class="form-control" id="input_fecha_gasto">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Tipo de gasto</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Pago de seguro</option>
														<option>Impuesto automotor</option>
														<option>Otro</option>
													</select>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label>Detalle (opcional)</label>
													<input type="text" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Vehículo asociado al gasto</label>
											<select class="form-control">
												<option>Ninguno</option>
												<option>Renault Fluence (MKA 451)</option>
												<option>Chevrolet Onix (NBX 159)</option>
											</select>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Monto ($)</label>
													<input type="number" step="0.01" min="0" class="form-control">
												</div>
											</div>
											<div class="col-xs-6">
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

										<div class="form-group">
											<label>Proveedor asociado al gasto</label>
											<select class="form-control">
												<option>Ninguno</option>
												<option>Repuestos José (Casa de repuestos)</option>
												<option>Provincia Seguros (Compañía de seguros)</option>
												<option>Jumax (Service/Lubricentro)</option>
												<option>Mariano mecánico (Mecánico)</option>
											</select>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Guardar</button>
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
			$('[data-toggle="tooltip"]').tooltip();

			$('#input_fecha_gasto').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: '-30d',
				endDate: 'today'
			});


			$("#checkbox_fin_alquiler_indefinido").change(function() {
				$("#input_fecha_fin_alquiler").prop("disabled", $(this).prop("checked"));
			})

		});


	</script>
@endsection