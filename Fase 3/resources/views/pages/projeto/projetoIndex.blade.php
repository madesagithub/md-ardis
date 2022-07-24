@extends('layouts.mainLayout')

@section('page-content')
<div class="row mb-5">
	@foreach ($projetos as $projeto)
	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			@switch($projeto->status)
				@case(App\Models\Status::CANCELADO)
					<div class="card-header text-danger border-danger">
				@break
				@case(App\Models\Status::ERRO)
					<div class="card-header text-danger border-danger">
				@break
				@case(App\Models\Status::FINALIZADO)
					<div class="card-header text-success border-success">
				@break
				@case(App\Models\Status::PENDENTE)
					<div class="card-header text-white border-white">
				@break
				@case(App\Models\Status::PRODUZINDO)
					<div class="card-header text-warning border-warning">
				@break
			@endswitch
			{{ ucfirst(strtolower($projeto->status)) }}</div>
			<div class="card-body">
				<h5 class="card-title mb-4">{{ $projeto->nome }}</h5>
				<ul class="mb-0">
					<li>{{ $projeto->nome }}</li>
					<li>{{ $projeto->maquina->nome }}</li>
					<li>{{ $projeto->deposito->nome }}</li>
					<li>{{ $projeto->user->name }}</li>
					<li>{{ $projeto->planos->count() }} planos</li>
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
			<div class="card-footer align-self-end">
				@if($projeto->status == App\Models\Status::PENDENTE)
				<a href="{{ route('projeto.start', $projeto) }}" class="btn btn-outline-light">
					Iniciar
				</a>
				@elseif($projeto->status == App\Models\Status::PRODUZINDO)
				<a href="{{ route('projeto.show', $projeto) }}" class="btn btn-outline-light">
					Visualizar
				</a>
				@endif
			</div>
		</div>
	</div>
	@endforeach
</div>

@if($projetosAnteriores->count())
<h2 class="mb-4">Projetos Anteriores</h2>
<div class="row">
	@foreach ($projetosAnteriores as $projeto)
	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			@switch($projeto->status)
				@case(App\Models\Status::CANCELADO)
					<div class="card-header text-danger border-danger">
				@break
				@case(App\Models\Status::ERRO)
					<div class="card-header text-danger border-danger">
				@break
				@case(App\Models\Status::FINALIZADO)
					<div class="card-header text-success border-success">
				@break
				@case(App\Models\Status::PENDENTE)
					<div class="card-header text-white border-white">
				@break
				@case(App\Models\Status::PRODUZINDO)
					<div class="card-header text-warning border-warning">
				@break
			@endswitch
			{{ ucfirst(strtolower($projeto->status)) }}</div>
			<div class="card-body">
				<h5 class="card-title mb-4">{{ $projeto->nome }}</h5>
				<ul class="mb-0">
					<li>{{ $projeto->nome }}</li>
					<li>{{ $projeto->maquina->nome }}</li>
					<li>{{ $projeto->deposito->nome }}</li>
					<li>{{ $projeto->user->name }}</li>
					<li>{{ $projeto->planos->count() }} planos</li>
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
			<div class="card-footer align-self-end">
			@if($projeto->status == App\Models\Status::PENDENTE)
				<a href="{{ route('projeto.start', $projeto) }}" class="btn btn-outline-light">
					Iniciar
				</a>
				@else
				<a href="{{ route('projeto.show', $projeto) }}" class="btn btn-outline-light">
					Visualizar
				</a>
				@endif
			</div>
		</div>
	</div>
	@endforeach
</div>
@endif
@endsection