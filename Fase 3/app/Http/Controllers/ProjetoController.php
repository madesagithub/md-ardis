<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Material;
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
		$data = [
			"nome_arquivo" => "01072022_110012_G20070515Z.1 - 500_FV_DATA",
			"tempo_corte" => "0:11",
			"data_processamento" => "01/07/2022",
			"hora_processamento" => "11:00",
			"fabrica" => "F\u00e1brica Vermelha",
			"maquina" => "Sc09",
			"usuario" => "Alexandre",
			"codigo_chapa_usado" => "2013000309057",
			"numero_layout" => "31",
			"metro_cubico_plano" => 0.01,
			"carregamentos" => 1,
			"quantidade_por_corte" => "24",
			"aproveitamento" => 37.65,
			"percentual_ocupacao_maquina" => 4.17,
			"metro_quadrado_chapa" => 4.514,
			"custo_por_metro" => 7.5393,
			"deposito" => "MATERIAIS_FB_NORMAL",
			"cortes_n1" => 12200,
			"cortes_n2" => 2934,
			"cortes_n3" => 2084,
			"percentual_peca_plano" => 0.0,
			"codigo_peca" => "",
			"descricao_peca" => "",
			"comprimento_peca_final" => 0,
			"largura_peca_final" => 0,
			"codigo_chapa_cadastro" => "",
			"comprimento_peca" => 0,
			"largura_peca" => 0,
			"espessura_peca" => 2.5,
			"quantidade_programada" => 1,
			"metro_quadrado_liquido_peca" => 0.0,
			"metro_quadrado_liquido_total_peca" => 0.0,
			"metro_cubico_liquido_total_peca" => 0.0,
			"metro_quadrado_bruto_peca" => 0.0,
			"quantidade_produzida" => 0,
			"pecas_superiores_produzidas" => "0",
			"metro_quadrado_superior_produzido" => 0.0,
			"data_embalagem" => "",
			"referencia_item" => "",
			"lote" => "",
			"logica_ardis" => "",
			"nivel" => 0,
			"prioridade" => 0,
			"percentual_produzido" => 0,
			"descricao_chapa" => "HDF 2,5mm VERMONT DARK (2440x1850)",
			"classificacao_chapa" => "3MM RUSTIC",
			"comprimento_chapa" => 2440,
			"largura_chapa" => 1850,
			"espessura_chapa" => 2.5,
			"quantidade_chapa" => 1
		];

		$data = json_decode(strval($data), true);

		$maquina = Maquina::firstWhere('nome', $data->maquina);
		$user = User::firstWhere('name', $data->usuario);
		// $material = Material::firstWhere('codigo', $data->codigo_material);
		// $peca = Peca::firstWhere('codigo', $data->codigo_peca);
		// $projeto = Projeto::firstWhere('nome', $data->nome_projeto);

		// Criar Maquina
		if (! $maquina) {
			$maquina = Maquina::create([
				'nome' => $data->maquina,
			]);
		}
		dump($maquina);

		// Criar User
		if (! $user) {
			$user = User::create([
				'name' => $data->usuario,
			]);
		}
		dump($user);

		dd('end');






















        // $projetos = Projeto::all();
        // $projetos = Projeto::with('maquina')->get();d

        $projetos = Projeto::with(
			'maquina',
			// 'material',
			'planos',
			// 'ordem.peca',
			'user',
		)->get();

		// return view('pages.projeto.projetoIndex', compact('projetos'));
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
        return response()->json('Chegou aqui => store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projeto $projeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projeto $projeto)
    {
        //
    }
}
