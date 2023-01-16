@extends('layouts.mainLayout')

@section('page-content')
<div class="row mb-5">
	@foreach ($retalhos as $retalho)
	<!-- Projeto -->
	<div class="card card-projeto mb-3">
		<div class="card-body">
			<div class="row justify-content-between">
				<div class="col-auto align-self-center">
					<span>
						<b>Plano:</b> <a href="{{ route('plano.show', ['plano' => $retalho->plano->id]) }}">{{ $retalho->plano->id }}</a>
					</span>
					&nbsp;
					<span>
						<b>Material:</b> {{ $retalho->plano->chapa->familia->nome }}
					</span>
					&nbsp;
					&nbsp;
					&nbsp;
					<span>
						<b>Comp:</b> {{ $retalho->comprimento_peca }}
					</span>
					&nbsp; 
					<span>
						<b>Larg:</b> {{ $retalho->largura_peca }} 
					</span>
					&nbsp; 
					<span>
						<b>Espe:</b> {{ $retalho->espessura_peca }} 
					</span>
					&nbsp; 
					<span>
						<b>Qtd. Prod:</b> {{ $retalho->quantidade_produzida }} 
					</span>
					&nbsp; 
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endsection