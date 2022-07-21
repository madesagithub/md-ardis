@extends('layouts.mainLayout')

@section('page-content')
<!-- Projeto -->
<div class="card card-projeto mb-5">
	<div class="card-body">

		<!-- Title - projeto -->
		<div class="row text-center" type="button" data-bs-toggle="collapse" data-bs-target="#projetoInformacao{{ $projeto->id }}" aria-expanded="false" aria-controls="projetoInformacao{{ $projeto->id }}">
			<h2 class="h2 mt-3 mb-4">
				{{ $projeto->nome }}
			</h2>
		</div>

		<div class="collapse" id="projetoInformacao{{ $projeto->id }}">
			<ul>
				<li>{{ $projeto->nome }}</li>
				<li>{{ $projeto->maquina->nome }}</li>
				<li>{{ $projeto->deposito->nome }}</li>
				<li>{{ $projeto->user->name }}</li>
				<li>{{ $projeto->data_processamento }}</li>
			</ul>

			<div class="row mb-4 justify-content-center">
				<div class="col-auto">
					<a href="{{ route('projeto.cancelar', ['id' => $projeto->id]) }}" class="btn btn-danger ms-1">
						Cancelar
					</a>
					<a href="{{ route('projeto.confirmar', ['id' => $projeto->id]) }}" class="btn btn-success ms-1">
						Finalizar
					</a>
				</div>
			</div>
		</div>

		<hr class="mt-0 mb-4">

		@foreach ($projeto->planos as $plano)
		<!-- Plano -->
		<div class="card card-chapa mb-4">
			<div class="card-body">

				<div class="row mb-4 justify-content-between">
					<div class="col-auto align-self-center">
						<h4 class="h4 mb-0">
							{{ $plano->numero_layout }} &nbsp; {{ $plano->chapa->descricao }} &nbsp; {{ $plano->aproveitamento }}% &nbsp; Qtd: {{ $plano->quantidade_chapa }}
						</h4>
					</div>

					<div class="col-auto">
						<a href="{{ route('plano.cancelar', ['id' => $plano->id]) }}" class="btn btn-danger ms-1">
							Cancelar
						</a>
						<a href="{{ route('plano.confirmar', ['id' => $plano->id]) }}" class="btn btn-success ms-1">
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
									{{ $ordem->peca->descricao }}
								</span>
								&nbsp;
								<span>
									Quantidade: {{ $ordem->quantidade_programada }}
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
@endsection