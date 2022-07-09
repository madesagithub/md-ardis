<?php

namespace App\Http\Controllers;

use App\Models\Deposito;
use App\Models\Fabrica;
use App\Models\Lote;
use App\Models\Maquina;
use App\Models\Chapa;
use App\Models\FamiliaChapa;
use App\Models\Ordem;
use App\Models\Peca;
use App\Models\Plano;
use App\Models\Produto;
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
			"nome_arquivo"                      => "01072022_110012_G20070515Z.1 - 500_FV_DATA",
			"tempo_corte"                       => "0:11",
			"data_processamento"                => "01/07/2022",
			"hora_processamento"                => "11:00",
			"fabrica"                           => "Fábrica Vermelha",
			"maquina"                           => "Sc09",
			"usuario"                           => "Alexandre",
			"codigo_chapa_usado"                => "2013000309057",
			"numero_layout"                     => 31,
			"metro_cubico_plano"                => 0.01,
			"carregamentos"                     => 1,
			"quantidade_por_corte"              => "24",
			"aproveitamento"                    => 37.65,
			"percentual_ocupacao_maquina"       => 4.17,
			"metro_quadrado_chapa"              => 4.514,
			"custo_por_metro"                   => 7.5393,
			"deposito"                          => "MATERIAIS_FB_NORMAL",
			"cortes_n1"                         => 12200,
			"cortes_n2"                         => 2934,
			"cortes_n3"                         => 2084,
			"percentual_peca_plano"             => 38.37176,
			"codigo_peca"                       => "242007005Z09",
			"descricao_peca"                    => "COSTA MENOR AEREO",
			"comprimento_peca_final"            => 216,
			"largura_peca_final"                => 604,
			"codigo_chapa_cadastro"             => "2013000309057",
			"comprimento_peca"                  => 216,
			"largura_peca"                      => 604,
			"espessura_peca"                    => 25,
			"quantidade_programada"             => 5,
			"metro_quadrado_liquido_peca"       => 0.130464,
			"metro_quadrado_liquido_total_peca" => 0.65232,
			"metro_cubico_liquido_total_peca"   => 0.0016308,
			"metro_quadrado_bruto_peca"         => 1.732580466,
			"quantidade_produzida"              => 500,
			"pecas_superproducao"               => "0",
			"metro_quadrado_superproducao"      => 0.0,
			"data_embalagem"                    => "21/12/21",
			"referencia_item"                   => "G20070515Z*.1",
			"lote"                              => 1011337,
			"logica_ardis"                      => "",
			"nivel"                             => 0,
			"prioridade"                        => 0,
			"percentual_produzido"              => 100.0,
			"descricao_chapa"                   => "HDF 2,5mm VERMONT DARK (2440x1850)",
			"familia_chapa"                     => "3MM RUSTIC",
			"comprimento_chapa"                 => 2440,
			"largura_chapa"                     => 1850,
			"espessura_chapa"                   => 2.5,
			"quantidade_chapa"                  => 1
		];

		$data = json_decode(json_encode($data));		

		// Fábrica
		$fabrica = Fabrica::firstWhere('nome', $data->fabrica);
		if (! $fabrica) {
			$fabrica = Fabrica::create([
				'nome' => $data->fabrica,
			]);
		}
		dump($fabrica->getAttributes());

		// Maquina
		$maquina = Maquina::firstWhere([
			['nome', $data->maquina],
			['fabrica_id', $fabrica->id],
		]);

		if (! $maquina) {
			$maquina = Maquina::create([
				'nome' => $data->maquina,
				'fabrica_id' => $fabrica->id,
			]);
		}
		dump($maquina->getAttributes());

		// User
		$user = User::firstWhere('name', $data->usuario);
		if (! $user) {
			$user = User::create([
				'name' => $data->usuario,
			]);
		}
		dump($user->getAttributes());

		// Produto
		$produto = Produto::firstWhere('referencia', $data->referencia_item);
		if (! $produto) {
			$produto = Produto::create([		
				'referencia' => $data->referencia_item,
			]);
		}
		dump($produto->getAttributes());

		// Lote
		$lote = Lote::create([
			'numero' => $data->lote,
			'produto_id' => $produto->id,
		]);

		if (! $lote) {
			$lote = Lote::firstWhere([
				'numero', $data->lote,
				'produto_id', $produto->id,
			]);
		}
		dump($lote->getAttributes());

		// Familia chapa
		$familiaChapa = FamiliaChapa::firstWhere('nome', $data->familia_chapa);
		if (! $familiaChapa) {
			$familiaChapa = FamiliaChapa::create([
				'nome' => $data->familia_chapa,
			]);
		}
		dump($familiaChapa->getAttributes());

		// Chapa
		$chapaCadastro = Chapa::firstWhere('codigo', $data->codigo_chapa_cadastro); // INVERTER
		if (! $chapaCadastro) {
			$chapaCadastro = Chapa::create([
				'codigo' => $data->codigo_chapa_cadastro,
				'familia_id' => $familiaChapa->id,
				'descricao' => $data->descricao_chapa,
				'comprimento' => $data->comprimento_chapa,
				'largura' => $data->largura_chapa,
				'espessura' => $data->espessura_chapa,
			]);			
		}

		if (is_null($chapaCadastro->getAttribute('descricao'))) {
			$chapaCadastro->descricao = $data->descricao_chapa;
			$chapaCadastro->comprimento = $data->comprimento_chapa;
			$chapaCadastro->largura = $data->largura_chapa;
			$chapaCadastro->espessura = $data->espessura_chapa;
			$chapaCadastro->save();
		}
		dump($chapaCadastro->getAttributes());

		// Chapa utilizada
		$chapaUtilizada = Chapa::firstWhere('codigo', $data->codigo_chapa_usado);
		if (! $chapaUtilizada) {
			$chapaUtilizada = Chapa::create([
				'codigo' => $data->codigo_chapa_usado,
				'familia_id' => $familiaChapa->id,
			]);			
		}
		dump($chapaUtilizada->getAttributes());

		// Peca
		$peca = Peca::firstWhere([
			['codigo', $data->codigo_peca],
			['produto_id', $produto->id]
		]);

		if (! $peca) {
			$peca = Peca::create([
				'codigo' => $data->codigo_peca,
				'descricao' => $data->descricao_peca,
				'comprimento_final' => $data->comprimento_peca_final,
				'largura_final' => $data->largura_peca_final,
				'produto_id' => $produto->id,		// Tabela pivô
				'chapa_id' => $chapaCadastro->id,	// Tabela pivô
			]);
		}
		dump($peca->getAttributes());

		// Deposito
		$deposito = Deposito::firstWhere('nome', $data->deposito);
		if (! $deposito) {
			$deposito = Deposito::create([
				'nome' => $data->deposito,
			]);
		}
		dump($deposito->getAttributes());

		// Projeto
		$projeto = Projeto::firstWhere('nome', $data->nome_arquivo);
		if (! $projeto) {
			$projeto = Projeto::create([
				'nome' => $data->nome_arquivo,
				'maquina_id' => $maquina->id,
				'deposito_id' => $deposito->id,
				'user_id' => $user->id,
				'data_processamento' => Carbon::createFromFormat(
					'd/m/Y H:i:s', 
					$data->data_processamento.' '.$data->hora_processamento.':00')->format('Y-m-d H:i:s'),
				'active' => 1,
			]);
		}
		dump($projeto->getAttributes());

		// Plano
		$plano = Plano::firstWhere([
			'projeto_id' => $projeto->id,
			'numero_layout' => $data->numero_layout,
		]);

		if (! $plano) {
			$plano = Plano::create([
				'numero_layout' => $data->numero_layout,
				'projeto_id' => $projeto->id,
				'chapa_id' => $chapaUtilizada->id,
				'quantidade_chapa' => $data->quantidade_chapa,
				'metro_quadrado_chapa' => $data->metro_quadrado_chapa,
				'aproveitamento' => $data->aproveitamento,
				'carregamentos' => $data->carregamentos,
				'tempo_corte' => Carbon::createFromFormat('H:i', $data->tempo_corte)->format('H:i'),
				'metro_cubico' => $data->metro_cubico_plano,
				'quantidade_por_corte' => $data->quantidade_por_corte,
				'percentual_ocupacao_maquina' => $data->percentual_ocupacao_maquina,
				'custo_por_metro' => $data->custo_por_metro,
				'cortes_n1' => $data->cortes_n1,
				'cortes_n2' => $data->cortes_n2,
				'cortes_n3' => $data->cortes_n3,
				'active' => 1,
			]);
		}
		dump($plano->getAttributes());

		// Ordem
		$ordem = Ordem::firstWhere([
			// ['numero', $data->numero_ordem],
			['plano_id', $plano->id],
			['peca_id', $peca->id],
		]);	

		$ordem = Ordem::create([
			// 'ordem' => $data->ordem,	// Talvez precise
			'plano_id' => $plano->id,
			'peca_id' => $peca->id,
			'comprimento_peca' => $data->comprimento_peca,
			'largura_peca' => $data->largura_peca,
			'espessura_peca' => $data->espessura_peca,
			'quantidade_programada' => $data->quantidade_programada,
			'quantidade_produzida' => $data->quantidade_produzida,
			'metro_quadrado_bruto_peca' => $data->metro_quadrado_bruto_peca,
			'metro_quadrado_liquido_peca' => $data->metro_quadrado_liquido_peca,
			'metro_quadrado_liquido_total_peca' => $data->metro_quadrado_liquido_total_peca,
			'metro_cubico_liquido_total_peca' => $data->metro_cubico_liquido_total_peca,
			'pecas_superproducao' => $data->pecas_superproducao,
			'metro_quadrado_superproducao' => $data->metro_quadrado_superproducao,
			'percentual_peca_plano' => $data->percentual_peca_plano,
			'lote_id' => $lote->id,
			'logica_ardis' => $data->logica_ardis,
			'nivel' => $data->nivel,
			'prioridade' => $data->prioridade,
			'percentual_produzido' => $data->percentual_produzido,
			'data_embalagem' => Carbon::createFromFormat('d/m/y', $data->data_embalagem)->format('Y-m-d'),
		]);
		dump($ordem->getAttributes());

		

		dd($fabrica->maquinas()->first()->projetos()->first()->user()->first());





        // $projetos = Projeto => =>all();
        // $projetos = Projeto => =>with('maquina')->get();d

        $projetos = Projeto::with(
			'maquina',
			// 'chapa',
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
