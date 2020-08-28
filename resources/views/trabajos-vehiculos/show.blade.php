@extends('layouts.main')

@section('title', 'Detalles de trabajo')

@section('custom-css')
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

					<h3 class="page-title"><a href="{{ route('trabajos-vehiculos.index') }}">Trabajos sobre vehículos</a> / Detalles del trabajo</h3>

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
									<h3 class="panel-title">Detalles del trabajo</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('trabajos-vehiculos.update', $trabajo->id) }}" method="POST">
										@csrf
										@method('PUT')

										<div class="form-group">
											<label>ID de trabajo</label>: #{{ $trabajo->id }}
										</div>
										<div class="form-group">
											<label>Vehículo</label>: 
											@if(!$trabajo->vehiculo->trashed())
											<a href="{{ route('vehiculos.show', $trabajo->vehiculo->id) }}">{{ $trabajo->vehiculo->marcaModeloYDominio() }}</a>
											@else
											{{ $trabajo->vehiculo->marcaModeloYDominio() }}
											@endif
										</div>
										<div class="form-group">
											<label>Tipo de trabajo</label>: {{ __('tipos_trabajos.'.$trabajo->tipo) }}
										</div>

										<div class="form-group @error('observaciones') has-error @enderror">
											<label>Observaciones</label>
											<input type="text" class="form-control" value="{{ $trabajo->observaciones }}" name="observaciones">
											@error('observaciones')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div class="form-group">
											<label>Proveedor</label>: 
											@if($trabajo->proveedor)
												@if(!$trabajo->proveedor->trashed())
												<a href="{{ route('proveedores.show', $trabajo->proveedor->id) }}">{{ $trabajo->proveedor->nombre }}</a>
												@else
												{{ $trabajo->proveedor->nombre }}
												@endif
											@else
											-
											@endif
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha pagado</label>: {{ $trabajo->fecha_pagado->isoFormat('D MMM Y') }}
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Costo total ($)</label>: {{ $trabajo->costo_total > 0 ? Strings::formatearMoneda($trabajo->costo_total, 2) : '-' }}
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Medio de pago</label>: {{ $trabajo->costo_total > 0 ? __('medios_pago.'.$trabajo->medio_pago) : '-' }}
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Fecha realizado</label>: {{ $trabajo->fecha_realizado->isoFormat('D MMM Y') }}
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