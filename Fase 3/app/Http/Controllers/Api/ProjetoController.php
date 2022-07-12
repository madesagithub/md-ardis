<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use App\Models\Chapa;
use App\Models\Deposito;
use App\Models\Fabrica;
use App\Models\FamiliaChapa;
use App\Models\LogicaArdis;
use App\Models\Lote;
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

			// Fábrica
			$fabrica = Fabrica::firstWhere('nome', $data->fabrica);
			if (!$fabrica) {
				$fabrica = Fabrica::create([
					'nome' => $data->fabrica,
				]);
			}

			// Maquina
			$maquina = Maquina::firstWhere([
				['nome', $data->maquina],
				['fabrica_id', $fabrica->id],
			]);

			if (!$maquina) {
				$maquina = Maquina::create([
					'nome' => $data->maquina,
					'fabrica_id' => $fabrica->id,
				]);
			}

			// User
			$user = User::firstWhere('name', $data->usuario);
			if (!$user) {
				$user = User::create([
					'name' => $data->usuario,
				]);
			}

			// Produto
			$produto = Produto::firstWhere('referencia', $data->referencia_item);
			if (!$produto) {
				$produto = Produto::create([
					'referencia' => $data->referencia_item,
				]);
			}

			// Lote
			$lote = Lote::create([
				'numero' => $data->lote,
				'produto_id' => $produto->id,
			]);

			if (!$lote) {
				$lote = Lote::firstWhere([
					'numero', $data->lote,
					'produto_id', $produto->id,
				]);
			}

			// Familia chapa
			$familiaChapa = FamiliaChapa::firstWhere('nome', $data->classificacao_chapa);
			if (!$familiaChapa) {
				$familiaChapa = FamiliaChapa::create([
					'nome' => $data->classificacao_chapa,
				]);
			}

			// Chapa utilizada
			$chapaUtilizada = Chapa::firstWhere('codigo', $data->codigo_chapa_usado);

			if (!$chapaUtilizada) {
				$chapaUtilizada = Chapa::create([
					'codigo' => $data->codigo_chapa_usado,
					'familia_id' => $familiaChapa->id,
					'descricao' => $data->descricao_chapa,
					'comprimento' => $data->comprimento_chapa,
					'largura' => $data->largura_chapa,
					'espessura' => $data->espessura_chapa,
				]);
			}

			if (is_null($chapaUtilizada->getAttribute('descricao'))) {
				$chapaUtilizada->descricao = $data->descricao_chapa;
				$chapaUtilizada->comprimento = $data->comprimento_chapa;
				$chapaUtilizada->largura = $data->largura_chapa;
				$chapaUtilizada->espessura = $data->espessura_chapa;
				$chapaUtilizada->save();
			}

			// Chapa
			$chapaCadastro = Chapa::firstWhere('codigo', $data->codigo_chapa_cadastro);
			if (!$chapaCadastro) {
				$chapaCadastro = Chapa::create([
					'codigo' => $data->codigo_chapa_cadastro,
					'familia_id' => $familiaChapa->id,
				]);
			}

			// Peca
			$peca = Peca::firstWhere([
				['codigo', $data->codigo_peca],
				['produto_id', $produto->id],
				['chapa_id', $produto->id]
			]);

			if (!$peca) {
				$peca = Peca::create([
					'codigo' => $data->codigo_peca,
					'descricao' => $data->descricao_peca,
					'comprimento_final' => $data->comprimento_peca_final,
					'largura_final' => $data->largura_peca_final,
					'produto_id' => $produto->id,		// Tabela pivô
					'chapa_id' => $chapaCadastro->id,	// Tabela pivô
				]);
			}

			// Deposito
			$deposito = Deposito::firstWhere('nome', $data->deposito);
			if (!$deposito) {
				$deposito = Deposito::create([
					'nome' => $data->deposito,
				]);
			}

			// Projeto
			$projeto = Projeto::firstWhere('nome', $data->nome_arquivo);
			if (!$projeto) {
				$projeto = Projeto::create([
					'nome' => $data->nome_arquivo,
					'maquina_id' => $maquina->id,
					'deposito_id' => $deposito->id,
					'user_id' => $user->id,
					'data_processamento' => Carbon::createFromFormat(
						'd/m/Y H:i:s',
						$data->data_processamento . ' ' . $data->hora_processamento . ':00'
					)->format('Y-m-d H:i:s'),
					'active' => 1,
				]);
			}

			// Plano
			$plano = Plano::firstWhere([
				'projeto_id' => $projeto->id,
				'numero_layout' => $data->numero_layout,
			]);

			if (!$plano) {
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

			// Lógica Ardis
			if (isset($data->logica_ardis) && $data->logica_ardis != '') {
				$logicaArdis = LogicaArdis::firstWhere('nome', $data->logica_ardis);

				if (!$logicaArdis) {
					$logicaArdis = LogicaArdis::create([
						'nome' => $data->logica_ardis,
					]);
				}
			} else {
				$logicaArdis = new LogicaArdis();
				$logicaArdis->id = null;
			}

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
				'logica_ardis_id' => $logicaArdis->id,
				'nivel' => $data->nivel,
				'prioridade' => $data->prioridade,
				'percentual_produzido' => $data->percentual_produzido,
				'data_embalagem' => Carbon::createFromFormat('d/m/y', $data->data_embalagem)->format('Y-m-d'),
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
