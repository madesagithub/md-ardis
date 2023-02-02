<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RetalhoCollection;
use App\Http\Resources\V1\RetalhoResource;
use App\Models\Lote;
use App\Models\Produto;
use App\Models\Retalho;
use App\Filters\V1\RetalhoFilter;
use App\Http\Requests\V1\StoreRetalhoRequest;
use App\Http\Requests\V1\UpdateRetalhoRequest;
use Illuminate\Http\Request;

class RetalhoController extends Controller
{
	// public function plano(Retalho $retalho)
	// {
	// 	return new PlanoController::show($retalho->plano);
	// }

	function saldo(Request $request)
	{
		// dd($request->all());

		$filter = new RetalhoFilter();
		$filterItems = $filter->transform($request);

		$retalhos = Retalho::where($filterItems);

		// Chapa
		$chapa = $request->query('chapa');
		if ($chapa) {
			$retalhos = $retalhos->whereHas('plano.chapa.familia', function ($query) use ($chapa) {
				$query->where('nome', $chapa);
			});
		}

		// Fábrica
		$fabrica = $request->query('fabrica');
		if ($fabrica) {
			$retalhos = $retalhos->whereHas('plano.projeto.maquina.fabrica', function ($query) use ($fabrica) {
				$query->where('nome', $fabrica);
			});
		}

		$retalhos = $retalhos->sum('quantidade_produzida');
		$saldo = [
			'quantidade' => intval($retalhos),
		];

		return $saldo;
	}


	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$filter = new RetalhoFilter();
		$filterItems = $filter->transform($request);

		$retalhos = Retalho::where($filterItems);

		// Plano
		$includePlano = $request->query('includePlano');
		if ($includePlano) {
			$retalhos = $retalhos->with('plano');
		}

		// Chapa
		$includeChapa = $request->query('includeChapa');
		if ($includeChapa) {
			$retalhos = $retalhos->with('plano.chapa');
		}

		// Familia
		$includeFamilia = $request->query('includeFamilia');
		if ($includeFamilia) {
			$retalhos = $retalhos->with('plano.chapa.familia');
		}

		$familia = $request->query('familia');
		if ($familia) {
			$retalhos = $retalhos->whereHas('plano.chapa.familia', function ($query) use ($familia) {
				$query->where('nome', $familia);
			});
		}

		// Projeto
		$includeProjeto = $request->query('includeProjeto');
		if ($includeProjeto) {
			$retalhos = $retalhos->with('plano.projeto');
		}

		// Fábrica
		$includeFabrica = $request->query('includeFabrica');
		if ($includeFabrica) {
			$retalhos = $retalhos->with('plano.projeto.maquina.fabrica');
		}

		$fabrica = $request->query('fabrica');
		if ($fabrica) {
			$retalhos = $retalhos->whereHas('plano.projeto.maquina.fabrica', function ($query) use ($fabrica) {
				$query->where('nome', $fabrica);
			});
		}

		// dd($retalhos->toSql());
		// dd($retalhos->first());
		$retalhos = $retalhos->get();
		// $retalhos = $retalhos->paginate()->appends($request->query());

		return new RetalhoCollection($retalhos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreRetalhoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRetalhoRequest $request)
    {
        // Recebe
		// ---------------------------------------------------------------------
		// codigo peca
		// descricao peca
		// familia chapa
		// comprimento peca
		// largura peca
		// quantidade
		// lote
		// data embalagem


		// ---------------------------------------------------------------------
		// Busca retalhos com a mesma medida
		//
		// Adiciona na tabela NecessidadeReaproveitamento
		// ---------------------------------------------------------------------


		foreach (json_decode($request->input()[0]) as $data) {
			// Produto
			if ($data->referencia_item != '') {
				$produto = Produto::firstWhere('referencia', $data->referencia_item);

				if (!$produto) {
					$produto = Produto::create([
						'referencia' => $data->referencia_item,
					]);
				}
			}

			// Lote
			if ($data->lote != '') {
				$lote = Lote::firstWhere('numero', $data->lote);
				
				if (!$lote) {
					$lote = Lote::create([
						'numero' => $data->lote,
						'produto_id' => $produto->id,
					]);
				}
			}
		}
		// ---------------------------------------------------------------------


		// Retorna
		// ---------------------------------------------------------------------
		// codigo peca
		// descricao peca
		// familia chapa
		// comprimento peca
		// largura peca
		// quantidade (inicial - retalhos)
		// lote
		// data embalagem
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function show(Retalho $retalho)
	{
		// Plano
		$includePlano = request()->query('includePlano');
		if ($includePlano) {
			$retalho = $retalho->loadMissing('plano');
		}

		// Chapa
		$includeChapa = request()->query('includeChapa');
		if ($includeChapa) {
			$retalho = $retalho->loadMissing('plano.chapa');
		}

		// Familia
		$includeFamilia = request()->query('includeFamilia');
		if ($includeFamilia) {
			$retalho = $retalho->loadMissing('plano.chapa.familia');
		}

		return new RetalhoResource($retalho);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Retalho  $retalho
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Retalho $retalho)
	{
		//
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateRetalhoRequest  $request
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRetalhoRequest $request, Retalho $retalho)
    {
        $retalho->update($request->all());
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
