<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Iniciar sesión - CarLend</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon.png') }}">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="content">
						<div class="header">
							<div class="logo text-center"><img src="{{ asset('assets/img/carlend-logo.png') }}" alt="Carlend Logo" style="width: 100px"></div>
							<p class="lead">Iniciar sesión</p>
						</div>
						<form class="form-auth-small" action="{{ route('login') }}" method="POST">
							@csrf

							<div class="form-group @error('email') has-error @enderror">
								<label for="signin-email" class="control-label sr-only">Email</label>
								<input type="email" name="email" class="form-control" id="signin-email" placeholder="Email" value="{{ old('email') }}" autofocus>
								@error('email')
									<label class="control-label" for="signin-email">{{ $message }}</label>
								@enderror
							</div>

							<div class="form-group @error('password') has-error @enderror">
								<label for="signin-password" class="control-label sr-only">Contraseña</label>
								<input type="password" name="password" class="form-control" id="signin-password" placeholder="Password">
								@error('password')
									<label class="control-label" for="signin-password">{{ $message }}</label>
								@enderror
							</div>

							<div class="form-group clearfix">
								<label class="fancy-checkbox element-left">
									<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
									<span>Recordar inicio de sesión</span>
								</label>
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block">INICIAR SESIÓN</button>
						</form>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
