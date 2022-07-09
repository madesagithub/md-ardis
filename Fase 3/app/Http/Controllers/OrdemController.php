<?php

namespace App\Http\Controllers;

use App\Models\Peca;
use App\Models\Chapa;
use App\Models\Ordem;
use Illuminate\Http\Request;

class OrdemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordens = Ordem::all();

		return view('pages.ordem.ordemIndex', compact('ordens'));
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
		$chapa = Chapa::firstWhere('codigo', $request->input('cod_chapa'));
		$peca = Peca::firstWhere('codigo', $request->input('cod_peca'));
		
		if (! $chapa) {
			$data = [
				'codigo' => $request->input['cod_chapa'],
				'descricao' => $request->input['descircao'],
				'comprimento' => $request->input['comprimento'],
				'largura' => $request->input['largura'],
				'quantidade' => $request->input['quantidade'],
			];

			// $chapa = ChapaController::store($data);
		}

		if (! $peca) {
			$data = [
				'codigo' => $request->input['cod_peca'],
				'descricao' => $request->input['descricao'],
				'comprimento' => $request->input['comprimento'],
				'largura' => $request->input['largura'],
				'quantidade' => $request->input['quantidade'],
			];

			// $peca = PecaController::store($data);
		}

        $ordem = Ordem::create([
			'identificador' => $request->input('identificador'),
			'chapa_id' => 1,
			'peca_id' => 1,
			'ordem' => $request->input('ordem'),
			'tempo' => $request->input('tempo'),
		]);

		return response()->json([
			"message" => "Ordem criada!",
		], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ordem  $ordem
     * @return \Illuminate\Http\Response
     */
    public function show(Ordem $ordem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ordem  $ordem
     * @return \Illuminate\Http\Response
     */
    public function edit(Ordem $ordem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ordem  $ordem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ordem $ordem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ordem  $ordem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ordem $ordem)
    {
        //
    }
}
