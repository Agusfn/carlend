@extends('layouts.main')

@section('title', 'Mi cuenta')



@section('content')

					<h3 class="page-title"><a href="{{ route('cuenta.detalles') }}">Mi cuenta</a> / Cambiar contraseña</h3>

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Cambiar contraseña</h3>
								</div>
								<div class="panel-body">

									<form action="" method="POST">

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">Contraseña actual</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="current_password" style="margin-bottom: 15px">
												</div>
											</div>
		                                </div>


										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">Contraseña nueva</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="new_password" style="margin-bottom: 15px">
												</div>
											</div>
		                                </div>



										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">Repetir contraseña nueva</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="new_password_confirmation" style="margin-bottom: 15px">
												</div>
											</div>
		                                </div>


										<div style="text-align: right; margin-top: 30px">
											<input type="submit" class="btn btn-primary" value="Cambiar contraseña">
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