		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.html"><img src="{{ asset('assets/img/carlend-logo.png') }}" alt="Carlend Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">4</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Informá el kilometraje de julio del Renault Fluence</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Hay trabajos que realizar en el Renault Fluence</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Informá el kilometraje de julio del Chevrolet Onix</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>El alquiler #2 tiene $4.200 pendientes de pago</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('cuenta.detalles') }}"><i class="lnr lnr-user"></i> <span>Mi cuenta</span></a></li>
								<li>
									<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<i class="lnr lnr-exit"></i> <span>Cerrar sesión</span>
									</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>