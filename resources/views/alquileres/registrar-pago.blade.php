@extends('layouts.main')

@section('title', 'Registrar nuevo pago a alquiler')



@section('content')
					<h3 class="page-title"><a href="index.html">Alquileres</a> / <a href="detalles.html">Alquiler #4</a> / Registrar pago o movimiento</h3>


					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del movimiento</h3>
								</div>

								<div class="panel-body">

									<form>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Fecha del movimiento</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Tipo de movimiento</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Pago de chofer</option>
														<option>Descuento</option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Monto ($)</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Medio de pago</label>
													<select class="form-control">
														<option>Seleccionar</option>
														<option>Efectivo</option>
														<option>Transferencia/depósito</option>
														<option>Mercadopago</option>
													</select>
												</div>
											</div>
										</div>
	
										<div class="form-group">
											<label>Comentarios</label>
											<input type="text" class="form-control">
										</div>	

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar movimiento</button>
										</div>
									</form>

								</div>
							</div>
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