<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\Ordem;
use App\Models\Peca;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PlanoController extends Controller
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

			// return time();
			// return date('Y-m-d', time());

			$plano = Plano::firstWhere('nome', $data->nome);
			$material = Material::firstWhere('codigo', $data->codigo_material);
			$peca = Peca::firstWhere('codigo', $data->codigo_peca);
			$maquina = Maquina::firstWhere('nome', $data->maquina);
			$user = User::firstWhere('name', $data->usuario);

			if (! $material) {
				$material = Material::create([
					'codigo' => $data->codigo_material,
					'descricao' => $data->descricao_material,
					'comprimento' => $data->comprimento_material,
					'largura' => $data->largura_material,
				]);
			}
	
			if (! $peca) {
				$peca = Peca::create([
					'codigo' => $data->codigo_peca,
					'descricao' => $data->descricao_peca,
					'comprimento' => $data->comprimento_peca,
					'largura' => $data->largura_peca,
				]);
			}

			if (! $maquina) {
				$maquina = Maquina::create([
					'nome' => $data->maquina,
				]);
			}

			if (! $user) {
				$user = User::create([
					'name' => $data->usuario,
				]);
			}

			if (! $plano) {
				$plano = Plano::create([
					'nome' => $data->nome,
					'numero' => $data->numero,
					'material_id' => $material->id,
					'maquina_id' => $maquina->id,
					// 'tempo_maquina' => $data->tempo_maquina,
					'tempo_maquina' => date('H:m:s', time()),
					'user_id' => $user->id,
					'aproveitamento' => $data->aproveitamento,
					// 'tempo' => $data->tempo,
					'tempo' => date('H:m:s', time()),
					// 'data_processamento' => date($data->data_processamento),
					// 'hora_processamento' => $data->hora_processamento,
					'data_processamento' => date('Y-m-d H:m:s', time()),
					// 'hora_processamento' => date('H:m:s', time()),
					'active' => 1,
				]);
			}

			$ordem = Ordem::create([
				'ordem' => $data->ordem,
				'peca_id' => $peca->id,
				'quantidade_peca' => $data->quantidade_peca,
				// 'data_embalagem' => $data->data_embalagem,
				'data_embalagem' => date('Y-m-d H:m:s', time()),
				'produzido' => $data->produzido,
				'plano_id' => $plano->id,
				'active' => 1,
			]);
		}
		

		return response()->json([
			"message" => "Plano criado!",
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
