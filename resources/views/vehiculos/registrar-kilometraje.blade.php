@extends('layouts.main')

@section('title', 'Registrar kilometraje')



@section('content')
					<h3 class="page-title"><a href="{{ route('vehiculos.index') }}">Vehículos</a> / <a href="{{ route('vehiculos.show', $vehiculo->id) }}">{{ $vehiculo->marca }} {{ $vehiculo->modelo }} ({{ $vehiculo->dominio }})</a> / Registrar kilometraje</h3>


					<div class="row">
						<div class="col-lg-4">
							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Registrar kilometraje</h3>
								</div>

								<div class="panel-body">

									<form action="{{ route('vehiculos.registrar-kilometraje', $vehiculo->id) }}" method="POST">
										@csrf
										<div class="form-group @error('kilometraje') has-error @enderror">
											<label>Kilometraje al {{ $fechaProgramada->isoFormat('d MMM') }}</label>
											<input type="number" min="0" name="kilometraje" class="form-control">
											@error('kilometraje')
												<label class="control-label">{{ $message }}</label>
											@enderror
										</div>

										<div style="text-align:right">
											<button class="btn btn-primary">Registrar kilometraje</button>
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