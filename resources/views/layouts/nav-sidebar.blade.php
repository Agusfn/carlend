		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li>
							<a href="{{ route('inicio') }}" {{ request()->is('/') ? "class=active" : "" }}><i class="lnr lnr-home"></i> <span>Inicio</span></a>
						</li>
						<li>
							<a href="{{ route('choferes.index') }}" {{ request()->is('choferes*') ? "class=active" : "" }}><i class="lnr lnr-user"></i> <span>Choferes</span></a>
						</li>
						<li>
							<a href="{{ route('proveedores.index') }}" {{ request()->is('proveedores*') ? "class=active" : "" }}><i class="lnr lnr-store"></i> <span>Proveedores</span></a>
						</li>
						<li>
							<a href="{{ route('vehiculos.index') }}" {{ request()->is('vehiculos*') ? "class=active" : "" }}><i class="lnr lnr-car"></i> <span>Vehículos</span></a>
						</li>
						<li>
							<a href="{{ route('trabajos-vehiculos.index') }}" {{ request()->is('trabajos-vehiculos*') ? "class=active" : "" }}><i class="fa fa-wrench" aria-hidden="true"></i> <span>Trabajos en vehiculos</span></a>
						</li>
						<li>
							<a href="{{ route('alquileres.index') }}" {{ request()->is('alquileres*') ? "class=active" : "" }}><i class="fa fa-handshake-o" aria-hidden="true" style="font-size: 15px"></i> <span>Alquileres</span></a>
						</li>
						<li>
							<a href="{{ route('gastos-adicionales.index') }}" {{ request()->is('gastos-adicionales*') ? "class=active" : "" }}><i class="fa fa-usd" aria-hidden="true" style="margin: 0 13px 0 5px;"></i> <span>Gastos adicionales</span></a>
						</li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed {{ request()->is('reportes*') ? 'active' : '' }}"><i class="lnr lnr-chart-bars"></i> <span>Reportes</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a href="{{ route('reportes.balances') }}" class="">Balances</a></li>
									<li><a href="{{ route('reportes.vehiculos') }}" class="">Vehículos</a></li>
									<li><a href="{{ route('reportes.choferes') }}" class="">Choferes</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</div>