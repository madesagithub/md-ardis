@extends('layouts.mainLayout')

@section('page-content')

<!-- <hr> -->

@foreach ($projetos as $projeto)
<!-- Projeto -->
<div class="card card-projeto mb-5">
	<div class="card-body">
		
		<!-- Title - projeto -->
		<div class="row text-center">
			<h2 class="h2 mt-3 mb-2">
				{{ $projeto->nome }}
			</h2>
		</div>

		<hr class="mb-4">

		@foreach ($projeto->planos as $plano)
		<!-- Plano -->
		<div class="card card-chapa mb-4">
			<div class="card-body">

				<div class="row mb-4 justify-content-between">
					<div class="col-auto align-self-center">
						<h4 class="h4 mb-0">
							{{ $plano->numero }} &nbsp; {{ $plano->chapa->descricao }} &nbsp; {{ $plano->aproveitamento }}%	
						</h4>
					</div>

					<div class="col-auto">
						<a href="{{ route('plano.cancelar', ['id' => $plano->id]) }}" class="btn btn-danger ms-1" >
							Cancelar
						</a>
						<a href="{{ route('plano.confirmar', ['id' => $plano->id]) }}" class="btn btn-success ms-1" >
							Finalizar
						</a>
					</div>
				</div>

			
				@foreach ($plano->ordens as $ordem)
				<!-- Ordem -->
				<div class="card card-peca mb-3">
					<div class="card-body">
						<div class="row justify-content-between">
							<div class="col-auto align-self-center">
								<span>
									{{ $ordem->id }}
								</span>
								&nbsp;
								<span>
									{{ $ordem->peca->descricao }}
								</span>
								&nbsp;
								<span>
									{{ $ordem->quantidade_programada }}
								</span>
							</div>
						</div>
					</div>
				</div>
				@endforeach

			</div>
		</div>
		@endforeach		
	</div>
</div>
@endforeach













@endsection