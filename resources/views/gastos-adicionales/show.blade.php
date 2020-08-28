@extends('layouts.main')

@section('title', 'Detalles de gasto')



@section('content')

					<h3 class="page-title"><a href="{{ route('gastos-adicionales.index') }}">Gastos adicionales</a> / Gasto #{{ $gasto->id }}</h3>

					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="btn-group">
								<button class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar gasto</button>
							</div>
						</div>
					</div>

					@if(session('success'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Los datos se actualizaron correctamente.
					</div>
					@endif

					<div class="row">
						<div class="col-md-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del gasto</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('gastos-adicionales.update', $gasto->id) }}" method="POST">
										@method('PUT')
										@csrf

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Fecha</label><br/>
													{{ $gasto->fecha->isoFormat('D MMM Y') }}
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Tipo de gasto</label><br/>
													@if($gasto->tipo == 'seguro_vehiculo')
													Pago de seguro
													@elseif($gasto->tipo == 'impuesto_automotor')
													Impuesto automotor
													@elseif($gasto->tipo == 'otro')
													Otro
													@endif
													Otro
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group @error('detalle') has-error @enderror">
													<label>Detalle</label>
													<input type="text" class="form-control" name="detalle" value="{{ $gasto->detalle }}">
													@error('detalle')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Vehículo asociado al gasto</label><br/>
											@if($gasto->vehiculo)
												@if(!$gasto->vehiculo->trashed())
												<a href="{{ route('vehiculos.show', $gasto->vehiculo->id) }}">{{ $gasto->vehiculo->marcaModeloYDominio() }}</a>
												@else
												{{ $gasto->vehiculo->marcaModeloYDominio() }}
												@endif
											@else
											-
											@endif
										</div>

										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label>Monto ($)</label><br/>
													{{ Strings::formatearMoneda($gasto->monto,2) }}
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label>Medio de pago</label><br/>
													@if($gasto->medio_pago == 'efectivo')
													Efectivo
													@elseif($gasto->medio_pago == 'tarjeta_credito')
													Tarjeta de crédito
													@elseif($gasto->medio_pago == 'transferencia')
													Transferencia bancaria
													@endif
												</div>
											</div>
										</div>

										<div class="form-group">
											<label>Proveedor asociado al gasto</label><br/>
											@if($gasto->proveedor)
												@if(!$gasto->proveedor->trashed())
												<a href="{{ route('proveedores.show', $gasto->proveedor->id) }}">{{ $gasto->proveedor->nombre }}</a>
												@else
												{{ $gasto->proveedor->nombre }}
												@endif
											@else
											-
											@endif
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

