<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Produto;
use Illuminate\Http\Request;

class RetalhoController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
