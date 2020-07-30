@extends('layouts.main')

@section('title', 'Detalles de gasto')



@section('content')

					<h3 class="page-title"><a href="index.html">Gastos adicionales</a> / Gasto #5</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group">
								<button class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar gasto</button>
							</div>
						</div>
					</div>

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
													<label>Fecha</label><br/>
													3 jul 2020
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Tipo de gasto</label><br/>
													Otro
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label>Detalle</label>
													<input type="text" class="form-control" value="Compra bujías">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Vehículo asociado al gasto</label><br/>
											<a href="">Renault Fluence (MKA 451)</a>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Monto ($)</label><br/>
													$1.000
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label>Medio de pago</label><br/>
													Tarjeta de crédito
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Proveedor asociado al gasto</label><br/>
											<a href="">Repuestos José</a>
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

