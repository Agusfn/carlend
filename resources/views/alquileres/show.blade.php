@extends('layouts.main')

@section('title', 'Detalles de alquiler')


@section('content')

					<h3 class="page-title"><a href="{{ route('alquileres.index') }}">Alquileres</a> / Alquiler #{{ $alquiler->id }}</h3>

						<div class="panel panel-headline">
							<div class="panel-body">
								<div class="btn-group">
									
									<a href="{{ route('alquileres.registrar-pago', 1) }}" class="btn btn-primary"><span class="glyphicon glyphicon-usd"></span> Registrar pago de chofer</a>

									@if($alquiler->estaEnCurso())
									<button class="btn btn-default" style="margin-left: 15px" onclick="if(confirm('¿Deseás terminar el alquiler? Una vez terminado no se podrá reanudar.')) $('#terminar-alq-form').submit();">Terminar alquiler</button>

									<form id="terminar-alq-form" action="{{ route('alquileres.terminar', $alquiler->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @endif
                                    
								</div>
							</div>
						</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del alquiler</h3>
								</div>

								<div class="panel-body">

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-4">
											<label>Estado:</label>&nbsp;&nbsp;&nbsp;
											@if($alquiler->estaEnCurso())
											<span class="label label-primary" style="font-size: 14px;">En curso</span>
											@elseif($alquiler->estaFinalizado())
											<span class="label label-default" style="font-size: 14px;">Finalizado</span>
											@endif
										</div>
										<div class="col-md-4">
											<label>Fecha inicio:</label> {{ $alquiler->fecha_inicio->isoFormat('D MMM Y') }}
										</div>
										<div class="col-md-4">
											<label>Fecha fin:</label> 
											@if($alquiler->fecha_fin)
											{{ $alquiler->fecha_fin->isoFormat('D MMM Y') }}
											@else
											No definida
											@endif
										</div>
									</div>

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-6">
											<label>Chofer:</label> <a href="{{ route('choferes.show', $alquiler->chofer->id) }}">{{ $alquiler->chofer->nombre_y_apellido }}</a>
										</div>
										<div class="col-md-6">
											<label>Vehículo:</label> <a href="{{ route('vehiculos.show', $alquiler->vehiculo->id) }}">{{ $alquiler->vehiculo->marcaModeloYDominio() }}</a>
										</div>
									</div>

									<div class="row" style="margin-bottom: 30px">
										<div class="col-md-6">
											<label>Precio diario:</label> {{ App\Lib\Strings::formatearMoneda($alquiler->precio_diario, 2) }}
										</div>
										<div class="col-md-6">
											<label>Descuento semanal:</label> @if($alquiler->descuento_semanal) Sí @else No @endif
											&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-question-sign" style="color:#45bac6" data-toggle="tooltip" data-placement="top" title="Si se omite el cobro diario en los días domingo."></span>
										</div>
									</div>

									<form>
										<div class="form-group">
											<label>Notas</label>
											<textarea class="form-control" style="resize: vertical;">{{ $alquiler->notas }}</textarea>
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Guardar</button>
										</div>
									</form>

								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Cuenta corriente</h3>
								</div>

								<div class="panel-body">

									<div class="row">
										<div class="col-sm-6">
											<div style="font-size: 17px">
												<label>Saldo:</label> 
												<span @if($alquiler->saldo_actual < 0) style="color: #B00;" @endif>
													{{ App\Lib\Strings::formatearMoneda($alquiler->saldo_actual, 2) }}
												</span>
											</div>
										</div>
										<div class="col-sm-6">
											<div style="font-size: 17px"><label>Ingresos totales:</label> {{ App\Lib\Strings::formatearMoneda($ingresos, 2) }}</div>
										</div>
									</div>
									

									<h4>Movimientos</h4>

									<table class="table">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Concepto</th>
												<th>Monto</th>
												<th>Saldo</th>
												<th>Medio de pago</th>
												<th>Coment.</th>
											</tr>
										</thead>
										<tbody>
											@foreach($movimientosSaldo as $movimiento)
											<tr>
												<td>{{ $movimiento->fecha_hora->isoFormat('D MMM Y') }}</td>
												<td>
													@if($movimiento->esCobroDeAlquiler())
													Cobro de alquiler
													@elseif($movimiento->esPagoDeChofer())
													Pago de chofer
													@elseif($movimiento->esDescuento())
													Descuento
													@endif
												</td>
												<td><span @if($movimiento->monto < 0) style="color: #B00;" @endif>
													{{ App\Lib\Strings::formatearMoneda($movimiento->monto, 2) }}
												</span></td>
												<td><span @if($movimiento->nuevo_saldo < 0) style="color: #B00;" @endif>
													{{ App\Lib\Strings::formatearMoneda($movimiento->nuevo_saldo, 2) }}
												</span></td>
												<td>
													@if($movimiento->esPagoDeChofer())
														@if($movimiento->esPorMercadopago())
														Mercadopago
														@elseif($movimiento->esEnEfectivo())
														Efectivo
														@elseif($movimiento->esPorTransferencia())
														Transferencia/depósito
														@endif
													@endif
												</td>
												<td>
													@if($movimiento->comentario)
													<span class="glyphicon glyphicon-comment" style="font-size: 18px" data-toggle="tooltip" data-placement="top" title="{{ $movimiento->comentario }}"></span>
													@endif
												</td>
											</tr>
											@endforeach

											@if($movimientosSaldo->count() == 0)
											<tr><td colspan="6" style="text-align: center;">No se encontraron movimientos.</td></tr>
											@endif
										</tbody>
									</table>	

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