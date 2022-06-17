<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\Ordem;
use App\Models\Peca;
use App\Models\Plano;
use App\Models\Projeto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return response()->json('Chegou aqui: index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		foreach (json_decode($request->input()[0]) as $data) {

			// return $data->nome_projeto;
			// return date('Y-m-d', time());

			$projeto = Projeto::firstWhere('nome', $data->nome_projeto);
			$maquina = Maquina::firstWhere('nome', $data->maquina);
			$material = Material::firstWhere('codigo', $data->codigo_material);
			$peca = Peca::firstWhere('codigo', $data->codigo_peca);
			$user = User::firstWhere('name', $data->usuario);

			// Criar Maquina
			if (! $maquina) {
				$maquina = Maquina::create([
					'nome' => $data->maquina,
				]);
			}

			// Criar Material
			if (! $material) {
				$material = Material::create([
					'codigo' => $data->codigo_material,
					'descricao' => $data->descricao_material,
					'comprimento' => $data->comprimento_material,
					'largura' => $data->largura_material,
				]);
			}
	
			// Criar Peca
			if (! $peca) {
				$peca = Peca::create([
					'codigo' => $data->codigo_peca,
					'descricao' => $data->descricao_peca,
					'comprimento' => $data->comprimento_peca,
					'largura' => $data->largura_peca,
				]);
			}

			// Criar User
			if (! $user) {
				$user = User::create([
					'name' => $data->usuario,
				]);
			}

			// Criar Projeto
			if (! $projeto) {
				$projeto = Projeto::create([
					'nome' => $data->nome_projeto,
					'maquina_id' => $maquina->id,
					'user_id' => $user->id,
					'data_processamento' => Carbon::createFromFormat('d/m/Y', $data->data_processamento)->format('Y-m-d'),
					'tempo_maquina' => Carbon::createFromFormat('H:i', $data->tempo_maquina)->format('H:i'),
					'active' => 1,
				]);
			}

			$plano = Plano::firstWhere([
				'projeto_id' => $projeto->id,
				'numero' => $data->numero_plano,
			]);

			// Criar Plano
			if (! $plano) {
				$plano = Plano::create([
					'numero' => $data->numero_plano,
					'projeto_id' => $projeto->id,
					'material_id' => $material->id,
					'aproveitamento' => $data->aproveitamento,
					'quantidade_material' => $data->quantidade_material,
					'tempo_processo' => Carbon::createFromFormat('H:i', $data->tempo_processo)->format('H:i'),
					'active' => 1,
				]);
			}

			// Criar Ordem
			$ordem = Ordem::create([
				'ordem' => $data->ordem,
				'peca_id' => $peca->id,
				'quantidade_peca' => $data->quantidade_peca,
				'data_embalagem' => Carbon::createFromFormat('d/m/Y', $data->data_embalagem)->format('Y-m-d'),
				'produzido' => $data->produzido,
				'plano_id' => $plano->id,
				'active' => 1,
			]);
		}

		return response()->json([
			"message" => "Projeto criado!",
		], 201);
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
