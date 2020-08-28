@extends('layouts.main')

@section('title', 'Mi cuenta')



@section('content')

					<h3 class="page-title"><a href="{{ route('cuenta.detalles') }}">Mi cuenta</a> / Cambiar contraseña</h3>

					@if(session('success'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Los datos se actualizaron correctamente.
					</div>
					@endif

					<div class="row">
						<div class="col-lg-6">

							<div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Cambiar contraseña</h3>
								</div>
								<div class="panel-body">

									<form action="{{ route('cuenta.cambiar-password') }}" method="POST">
										@csrf

										<div class="form-group @error('password_actual') has-error @enderror">
											<div class="row" style="margin-bottom: 15px">
												<div class="col-sm-6">Contraseña actual</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="password_actual" value="{{ old('password_actual') }}">
													@error('password_actual')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
		                                </div>


										<div class="form-group @error('password') has-error @enderror">
											<div class="row" style="margin-bottom: 15px">
												<div class="col-sm-6">Contraseña nueva</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="password" value="{{ old('password') }}">
													@error('password')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
		                                </div>



										<div class="form-group @error('password_confirmation') has-error @enderror">
											<div class="row" style="margin-bottom: 15px">
												<div class="col-sm-6">Repetir contraseña nueva</div>
												<div class="col-sm-6">
													<input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
													@error('password_confirmation')
														<label class="control-label">{{ $message }}</label>
													@enderror
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


