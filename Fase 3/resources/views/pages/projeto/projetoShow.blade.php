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

		<!-- Data - projeto -->
		<div class="collapse" id="projetoInformacao{{ $projeto->id }}">
			<ul>
				<li>{{ $projeto->nome }}</li>
				<li>{{ $projeto->maquina->nome }}</li>
				<li>{{ $projeto->deposito->nome }}</li>
				<li>{{ $projeto->user->name }}</li>
				<li>{{ $projeto->data_processamento }}</li>
			</ul>

			<!-- Buttons - projeto -->
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

		<!-- Planos ativos -->
		@foreach ($projeto->planos->where('active', true) as $plano)
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
						<a href="{{ route('plano.cancelar', ['id' => $plano->id]) }}" class="text-decoration-none">
							<button type="button" class="btn btn-danger ms-1">
								Cancelar
							</button>
						</a>
						<a href="{{ route('plano.confirmar', ['id' => $plano->id]) }}" class="text-decoration-none">
							<button type="button" class="btn btn-success ms-1">
								Finalizar
							</button>
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

		<!-- Planos desativados -->
		@foreach ($projeto->planos->where('active', false) as $plano)
		<!-- Plano -->
		<div class="card card-chapa mb-4">
			<div class="card-body">
				@if ($plano->status == App\Models\Status::ERRO)
				<div class="row mb-4 justify-content-between">
				@else
				<div class="row justify-content-between">
				@endif
					<div class="col-auto align-self-center">
						<h4 class="h4 mb-0">
							{{ $plano->numero_layout }} &nbsp; {{ $plano->chapa->descricao }} &nbsp; {{ $plano->aproveitamento }}% &nbsp; Qtd: {{ $plano->quantidade_chapa }}
						</h4>
					</div>
					<div class="col-auto align-self-center">
						<div class="row">
							@switch($plano->status)
								@case(App\Models\Status::CANCELADO)
									<p class="mb-0 font-weight-bold text-danger">	
								@break
								@case(App\Models\Status::ERRO)
									<p class="mb-0 font-weight-bold text-danger" >
								@break
								@case(App\Models\Status::FINALIZADO)
									<p class="mb-0 font-weight-bold text-success">
								@break
								@case(App\Models\Status::PENDENTE)
									<p class="mb-0 font-weight-bold text-white">
								@break
								@case(App\Models\Status::PRODUZINDO)
									<p class="mb-0 font-weight-bold text-warning">
								@break
							@endswitch
								{{ $plano->status }}
							</p>
						</div>
					</div>
				</div>

				@if ($plano->status == App\Models\Status::ERRO)
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
								<div class="col-auto">
									<div class="row">
										<div class="col-auto align-self-center">
											@switch($ordem->status)
												@case(App\Models\Status::CANCELADO)
													<p class="mb-0 font-weight-bold text-danger">
														{{ $ordem->status }}
													</p>
												@break
												@case(App\Models\Status::ERRO)
													<p class="mb-0 font-weight-bold text-danger">
														{{ $ordem->status }}
														@if ($ordem->status()->reason)
															<i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $ordem->status()->reason }}"></i>
														@endif
													</p>
												@break
												@case(App\Models\Status::FINALIZADO)
													<p class="mb-0 font-weight-bold text-success">
														{{ $ordem->status }}
													</p>
												@break
												@case(App\Models\Status::PENDENTE)
													<p class="mb-0 font-weight-bold text-white">
														{{ $ordem->status }}
													</p>
												@break
												@case(App\Models\Status::PRODUZINDO)
													<p class="mb-0 font-weight-bold text-warning">
														{{ $ordem->status }}
													</p>
												@break
											@endswitch
										</div>
										@if($ordem->status == App\Models\Status::ERRO)
										<div class="col-auto">
											<a href="{{ route('ordem.cancelar', ['id' => $ordem->id]) }}" class="text-decoration-none">
												<button type="button" class="btn btn-danger ms-1">
													Cancelar
												</button>
											</a>
											<a href="{{ route('ordem.confirmar', ['id' => $ordem->id]) }}" class="text-decoration-none">
												<button type="button" class="btn btn-success ms-1">
													Finalizar
												</button>
											</a>
										</div>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				@endif
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@push('footer-scripts')
<script>
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
@endpush