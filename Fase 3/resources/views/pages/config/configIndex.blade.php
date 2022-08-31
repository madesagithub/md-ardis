@extends('layouts.mainLayout')

@section('page-title')
Configurações
@endsection

@section('page-content')
<div class="row mb-5">

	@foreach($configs as $config)
	<div class="card card-peca mb-3">
		<div class="card-body">
			<div class="row justify-content-between">
				<div class="col-auto align-self-center">
					<h5 class="h5">
						{{ $config['name'] }}
					</h5>
					
					<span class="text-secondary">
						{{ $config['description'] }}
					</span>
				</div>
				<div class="col-auto align-self-center">
					@switch($config['value'])
						@case(true)
						<p class="mb-0 font-weight-bold text-success">
							ATIVADO
						</p>
						@break
						@case(false)
						<p class="mb-0 font-weight-bold text-danger">
							DESATIVADO
						</p>
						@break
						@default
						<p class="mb-0 font-weight-bold text-warning">
							ERRO
						</p>
						@break
					@endswitch
				</div>
			</div>
		</div>
	</div>
	@endforeach

</div>
@endsection