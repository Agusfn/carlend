@extends('layouts.main')

@section('title', 'Agregar vehículo')


@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection


@section('content')

					<h3 class="page-title"><a href="{{ route('vehiculos.index') }}">Vehículos</a> / Agregar</h3>


					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles del vehículo</h3>
						</div>

						<div class="panel-body">


							<div class="row">
								<div class="col-lg-4">

									<h4 style="margin-bottom: 20px;">Datos del vehículo</h4>

									<div class="form-group">
										<label>Patente</label>
										<input type="text" class="form-control">
									</div>

									<div class="form-group">
										<label>Marca</label>
										<input type="text" class="form-control">
									</div>
									<div class="form-group">
										<label>Modelo</label>
										<input type="text" class="form-control">
									</div>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>Año</label>
												<input type="number" class="form-control">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>Kilometraje actual</label>
												<input type="number" class="form-control">
											</div>
										</div>
									</div>



								</div>

								<div class="col-lg-4">
									
									<h4 style="margin-bottom: 20px;">Mantenimiento</h4>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs c/ service</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs ult. service</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs c/ cambio bujías</label>
												<input type="number" class="form-control" value="">
											</div>	
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs ult. cambio bujías</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs c/ rotación cubiertas</label>
												<input type="number" class="form-control" value="">
											</div>	
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs ult. rotación</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs c/ cambio cubiertas</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs ult. cambio cubiertas</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs c/ cambio correa distr.</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label>KMs ult. cambio correa</label>
												<input type="number" class="form-control" value="">
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-xs-6">
											<div class="form-group">
												<label>Fecha vencimiento VTV</label>
												<input type="text" class="form-control" id="input_fecha_vto_vtv" value="">
											</div>
										</div>

										<div class="col-xs-6">
											<div class="form-group">
												<label>Fecha vto. oblea GNC</label>
												<input type="text" class="form-control" id="input_fecha_vto_gnc" value="">
											</div>
										</div>
									</div>



								</div>


								<div class="col-lg-4">
									
									<h4 style="margin-bottom: 20px;">Impuesto de patentes</h4>

									<label class="fancy-checkbox" style="margin-bottom: 10px">
										<input type="checkbox" id="checkbox_debito_patentes">
										<span>Débito automático pago de patentes</span>
									</label>
										
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Costo ($)</label>
												<input type="number" step="0.01" min="0" class="form-control" id="input_costo_patentes" value="" disabled="">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Día del mes débito (1-28)</label>
												<input type="number" class="form-control" id="input_dia_debito_patentes" value="" disabled="">
											</div>
										</div>
									</div>


									<h4 style="margin: 25px 0 20px;">Seguro automotor</h4>

									<label class="fancy-checkbox" style="margin-bottom: 10px">
										<input type="checkbox" id="checkbox_debito_seguro">
										<span>Débito automático pago de seguros</span>
									</label>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Proveedor</label>
												<select class="form-control" id="select_proveedor_seguro" disabled="">
													<option>Seleccionar</option>
													<option>Provincia Seguros</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Fecha vto. póliza</label>
												<input type="text" class="form-control" id="input_fecha_vto_poliza" value="" disabled="">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Costo ($)</label>
												<input type="number" step="0.01" min="0" class="form-control" id="input_costo_seguro" value="" disabled="">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Día del mes débito (1-28)</label>
												<input type="number" class="form-control" id="input_dia_debito_seguro" value="" disabled="">
											</div>
										</div>
									</div>

								</div>

							</div>


							<form>


								<div style="text-align:right">
									<button class="btn btn-primary">Guardar</button>
								</div>
							</form>
							
						</div>
					</div>



@endsection



@section('custom-js')
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#input_fecha_vto_vtv, #input_fecha_vto_gnc, #input_fecha_vto_poliza').datepicker({
				autoclose: true,
				language: 'es-ES',
				format: 'dd/mm/yyyy',
				startDate: 'tomorrow',
				endDate: '+2y'
			});


			$("#checkbox_debito_patentes").change(function() {
				$("#input_costo_patentes, #input_dia_debito_patentes").prop("disabled", !$(this).prop("checked"));
			});

			$("#checkbox_debito_seguro").change(function() {
				$("#select_proveedor_seguro, #input_costo_seguro, #input_dia_debito_seguro, #input_fecha_vto_poliza").prop("disabled", !$(this).prop("checked"));
			});


		});
	</script>
@endsection