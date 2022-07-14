<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    public function cancelar($id)
	{
		$plano = Plano::find($id);
		// dd($plano);

		// $url = $this->getUrlApiTotvs($id);
		$url = $this->getUrlApiTotvs($plano, 'cancel');
		// return back();
	}

	public function getUrlApiTotvs(Plano $plano, $action)
	{
		# Item a ser movimentado estoque
		$chapa = $plano->chapa->codigo;

		if ($action == 'cancel') {
			# Depósito de origem
			$depOrigem = 'ALM';

			# Local de origem
			$fabrica = preg_replace('~[^A-Z]~', '', $plano->projeto->maquina->fabrica->nome);

			if ($fabrica == 'FB') {
				$locOrigem = 'ALMB-A';
			} elseif ($fabrica == 'FV') {
				$locOrigem = 'ALMV-A';
			}

			# dep_dest à deposito destino
			$depDestino = 'FAB';

			# Local destino
			$locDestino = '';

		} elseif ($action == 'confirm') {
			# Depósito de origem
			$depOrigem = 'ALM';

			# Local de origem
			$fabrica = preg_replace('~[^A-Z]~', '', $plano->projeto->maquina->fabrica->nome);

			if ($fabrica == 'FB') {
				$locOrigem = 'ALMB-A';
			} elseif ($fabrica == 'FV') {
				$locOrigem = 'ALMV-A';
			}

			# dep_dest à deposito destino
			$depDestino = 'FAB';

			# Local destino
			$locDestino = '';
		}

		foreach ($plano->ordens as $ordem) {

			# Quantidade deve ser na unidade de medida cadastrada no sistema
			$quantidade = $ordem->metro_quadrado_bruto_peca;

			# Api para comunicação com o TOTVS
			$apiTotvs = env('TOTVS_API') 
				.'/WService='. env('TOTVS_BASE')
				.'/rsapi/rsapi015web?codChave='. env('TOTVS_KEY')
				.'&Item='. $chapa 
				.'&dep_orig='. $depOrigem 
				.'&loc_orig='. $locOrigem 
				.'&dep_dest='. $depDestino 
				.'&loc_dest='. $locDestino 
				.'&quantidade='. $quantidade 
				.'&codEmitente='. env('TOTVS_COD_EMITENTE');

			
			// Chamar API TOTVS
			dump($apiTotvs);
		}
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
