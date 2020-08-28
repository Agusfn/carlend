@extends('layouts.main')

@section('title', 'Mi cuenta')



@section('content')

					<h3 class="page-title">Mi cuenta</h3>

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
									<h3 class="panel-title">Datos de mi cuenta</h3>
								</div>
								<div class="panel-body">

									<form action="{{ route('cuenta.detalles') }}" method="POST">
										@csrf

										<div class="form-group @error('name') has-error @enderror">
											<div class="row">
												<div class="col-sm-6">Nombre de usuario</div>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
													@error('name')
														<label class="control-label">{{ $message }}</label>
													@enderror
												</div>
											</div>
		                                </div>

										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">E-mail</div>
												<div class="col-sm-6">{{ Auth::user()->email }}</div>
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

