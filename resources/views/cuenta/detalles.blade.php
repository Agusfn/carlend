@extends('layouts.main')

@section('title', 'Mi cuenta')



@section('content')

					<h3 class="page-title">Mi cuenta</h3>

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Datos de mi cuenta</h3>
								</div>
								<div class="panel-body">

									<form action="" method="POST">

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">Nombre de usuario</div>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="name" value="Samuel">
												</div>
											</div>
		                                </div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">E-mail</div>
												<div class="col-sm-6">mi-email@gmail.com</div>
											</div>
		                                </div>


										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">Password</div>
												<div class="col-sm-6">********** (<a href="{{ route('cuenta.cambiar-password') }}">cambiar</a>)</div>
											</div>
		                                </div>


										<div style="text-align: right; margin-top: 30px">
											<input type="submit" class="btn btn-primary" value="Guardar">
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