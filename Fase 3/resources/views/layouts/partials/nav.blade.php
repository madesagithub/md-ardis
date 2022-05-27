<header class="p-3 mb-5 bg-dark text-white">
	<div class="container">
		<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
			<!-- <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
				<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
					<use xlink:href="#bootstrap" />
				</svg>
			</a> -->

			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
				<li><a href="#" class="nav-link px-2 text-secondary {{ Route::currentRouteName() === 'estrutura.buscar' ? 'active' : null }}">Home</a></li>
				<li><a href="{{ route('projeto.index') }}" class="nav-link px-2 text-white">Projetos</a></li>
				<li><a href="{{ route('ordem.index') }}" class="nav-link px-2 text-white">Ordens</a></li>
				<li><a href="{{ route('material.index') }}" class="nav-link px-2 text-white">Materiais</a></li>
				<li><a href="{{ route('peca.index') }}" class="nav-link px-2 text-white">Peças</a></li>
				<li><a href="{{ route('maquina.index') }}" class="nav-link px-2 text-white">Maquinas</a></li>
			</ul>

			<!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
				<input type="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search..." aria-label="Search">
			</form> -->

			<!-- <div class="text-end">
				<button type="button" class="btn btn-outline-light me-2">Login</button>
				<button type="button" class="btn btn-warning">Sign-up</button>
			</div> -->
		</div>
	</div>
</header>