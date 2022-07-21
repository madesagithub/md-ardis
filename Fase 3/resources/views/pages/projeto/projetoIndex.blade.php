@extends('layouts.mainLayout')

@section('page-content')
@foreach ($projetos as $projeto)
<div class="row mb-5">
	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			@switch($projeto->status)
				@case($status['CANCELADO'])
				<div class="card-header text-danger border-danger">
				@break
				@case($status['FINALIZADO'])
					<div class="card-header text-success border-success">
				@break
				@case($status['PENDENTE'])
					<div class="card-header text-white border-white">
				@break
				@case($status['PRODUZINDO'])
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
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
			<div class="card-footer align-self-end">
				<a href="{{ route('projeto.show', $projeto) }}" class="btn btn-outline-light">
					Iniciar
				</a>
			</div>
		</div>
	</div>
</div>
@endforeach

<h2 class="mb-4">Projetos Anteriores</h2>
@foreach ($projetos as $projeto)
<div class="row">
	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			<div class="card-header text-warning border-warning">Produzindo</div>
			<div class="card-body">
				<h5 class="card-title mb-4">{{ $projeto->nome }}</h5>
				<ul class="mb-0">
					<li>{{ $projeto->nome }}</li>
					<li>{{ $projeto->maquina->nome }}</li>
					<li>{{ $projeto->deposito->nome }}</li>
					<li>{{ $projeto->user->name }}</li>
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
			<div class="card-footer align-self-end">
				<a href="{{ route('projeto.show', $projeto) }}" class="btn btn-outline-light">
					Iniciar
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			<div class="card-header text-danger border-danger">Cancelado</div>
			<div class="card-body">
				<h5 class="card-title mb-4">{{ $projeto->nome }}</h5>
				<ul>
					<li>{{ $projeto->nome }}</li>
					<li>{{ $projeto->maquina->nome }}</li>
					<li>{{ $projeto->deposito->nome }}</li>
					<li>{{ $projeto->user->name }}</li>
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card text-white bg-dark mb-3">
			<div class="card-header text-success border-success">Finalizado</div>
			<div class="card-body">
				<h5 class="card-title mb-4">{{ $projeto->nome }}</h5>
				<ul>
					<li>{{ $projeto->nome }}</li>
					<li>{{ $projeto->maquina->nome }}</li>
					<li>{{ $projeto->deposito->nome }}</li>
					<li>{{ $projeto->user->name }}</li>
					<li>{{ $projeto->data_processamento }}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection