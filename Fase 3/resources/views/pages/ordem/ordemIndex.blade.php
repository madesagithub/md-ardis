@extends('layouts.mainLayout')

@section('page-content')
{{ $ordens }}

<hr>

<div class="card card-plano mb-5">
	<div class="card-body">

		<div class="row text-center">
			<h2 class="h2 mt-3 mb-2">
				FV250522
			</h2>
		</div>

		<hr class="mb-4">

		<div class="card card-material">
			<div class="card-body">

				<div class="row">
					<h4 class="h4 mt-2 mb-4">
						AGLOM 12MM (2750x1850)
					</h4>
				</div>

				<div class="card card-peca mb-3">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto align-self-center">
								<span>
									Plano 1
								</span>
								&nbsp;
								<span>
									Peça
								</span>
								&nbsp;
								<span>
									Ordem
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger ms-1">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-peca mb-3">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto align-self-center">
								<span class="align-self-center">
									Plano 2
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger ms-1">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-peca">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto align-self-center">
								<span>
									Plano 3
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger ms-1">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-material mt-4">
			<div class="card-body">

				<div class="row">
					<h3 class="h3 mt-2 mb-4">
						FV250522
					</h3>
				</div>

				<div class="card card-peca mb-3">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto">
								<span class="align-bottom">
									Plano 1 AGLOM 12MM (2750x1850)
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger ms-1">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-peca mb-3">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto">
								<span class="align-bottom">
									Plano 2 AGLOM 12MM (2750x1850)
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger ms-1">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-peca">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto">
								<span class="align-bottom">
									Plano 3
								</span>
							</div>
							<div class="col-auto">
								<button class="btn btn-danger">
									Cancelar
								</button>
								<button class="btn btn-success ms-1">
									Finalizar
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection