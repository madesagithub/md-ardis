@extends('layouts.mainLayout')

@section('page-content')
{{ $ordens }}

<hr>

<div class="card mb-5">
	<div class="card-body">

		<div class="row">
			<h3 class="h3 mt-2 mb-4">
				AGLOM 12MM (2750x1850)
			</h3>
		</div>

		<div class="card card-children mb-3">
			<div class="card-body">
				<div class="row justify-content-between">
					<div class="col-auto">
						<span class="align-bottom">
							Plano 1
						</span>
					</div>
					<div class="col-auto">
						<button class="btn btn-danger">
							Cancelar
						</button>
						<button class="btn btn-success">
							Finalizar
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-children mb-3">
			<div class="card-body">
				<div class="row justify-content-between">
					<div class="col-auto">
						<span class="align-bottom">
							Plano 2
						</span>
					</div>
					<div class="col-auto">
						<button class="btn btn-danger">
							Cancelar
						</button>
						<button class="btn btn-success">
							Finalizar
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-children">
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
						<button class="btn btn-success">
							Finalizar
						</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="card mb-5">
	<div class="card-body">

		<div class="row">
			<h3 class="h3 mt-2 mb-4">
				FV250522
				
			</h3>
		</div>

		<div class="card card-children mb-3">
			<div class="card-body">
				<div class="row justify-content-between">
					<div class="col-auto">
						<span class="align-bottom">
							Plano 1	AGLOM 12MM (2750x1850)
						</span>
					</div>
					<div class="col-auto">
						<button class="btn btn-danger">
							Cancelar
						</button>
						<button class="btn btn-success">
							Finalizar
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-children mb-3">
			<div class="card-body">
				<div class="row justify-content-between">
					<div class="col-auto">
						<span class="align-bottom">
							Plano 2	AGLOM 12MM (2750x1850)
						</span>
					</div>
					<div class="col-auto">
						<button class="btn btn-danger">
							Cancelar
						</button>
						<button class="btn btn-success">
							Finalizar
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card card-children">
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


@endsection
