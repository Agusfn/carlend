@extends('layouts.main')

@section('title', 'Registrar alquiler')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / Registrar nuevo alquiler</h3>

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del alquiler</h3>
								</div>

								<div class="panel-body">

									<form>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Fecha de inicio</label>
													<input type="text" class="form-control" value="(fecha de hoy)" readonly="">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Fecha de fin</label>
													<label class="fancy-checkbox">
														<input type="checkbox" id="checkbox_fin_alquiler_indefinido">
														<span>Sin fecha definida (el alquiler se termina manualmente)</span>
													</label>
													<input type="text" class="form-control" id="input_fecha_fin_alquiler">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Chofer</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Ignacio Gutierrez</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Vehículo</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Chevrolet Onix (NBX 159)</option>
													</select>
												</div>
											</div>
										</div>





										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Monto diario de alquiler ($)&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="El alquiler tendrá una cuenta corriente desde donde se descontará este monto diariamente, y paralelamente, se deberán registrar los pagos del chofer manualmente."></span></label>
													<input type="number" step="0.01" min="0" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Descuento semanal</label>
													<label class="fancy-checkbox">
														<input type="checkbox">
														<span>No cobrar el alquiler de los días domingo</span>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Notas</label>
											<textarea class="form-control" style="resize: vertical;"></textarea>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar alquiler</button>
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

			$('#input_fecha_fin_alquiler').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				orientation: 'bottom',
				startDate: '+1d',
				endDate: '+1y'
			});


			$("#checkbox_fin_alquiler_indefinido").change(function() {
				$("#input_fecha_fin_alquiler").prop("disabled", $(this).prop("checked"));
			})

		});


	</script>	
@endsection