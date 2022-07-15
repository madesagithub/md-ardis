<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordem extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordens';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		// 'ordem',
		'plano_id',
		'peca_id',
		'comprimento_peca',
		'largura_peca',
		'espessura_peca',
		'quantidade_programada',
		'quantidade_produzida',
		'metro_quadrado_bruto_peca',
		'metro_quadrado_liquido_peca',
		'metro_quadrado_liquido_total_peca',
		'metro_cubico_liquido_total_peca',
		'pecas_superproducao',
		'metro_quadrado_superproducao',
		'percentual_peca_plano',
		'lote_id',
		'logica_ardis_id',
		'nivel',
		'prioridade',
		'percentual_produzido',
		'data_embalagem',
	];

	public function cancelarTotvs() {
		$url = $this->getUrlApiTotvs('cancel');

		// Chamar API TOTVS
		dump($url);
		$response = $this->callApi($url);

		if (!is_null($response) && $response->status == '200') {
			$this->disable();
		}
	}

	public function confirmarTotvs() {
		$url = $this->getUrlApiTotvs('confirm');

		// Chamar API TOTVS
		dump($url);
		$response = $this->callApi($url);

		if (!is_null($response) && $response->status == '200') {
			$this->disable();
		}
	}

	public function getUrlApiTotvs($action) {
		# Item a ser movimentado estoque
		$chapa = $this->plano->chapa->codigo;

		if ($action == 'cancel') {
			# Depósito de origem
			$depOrigem = 'ALM';

			# Local de origem
			$fabrica = preg_replace('~[^A-Z]~', '', $this->plano->projeto->maquina->fabrica->nome);

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
			$fabrica = preg_replace('~[^A-Z]~', '', $this->plano->projeto->maquina->fabrica->nome);

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

		# Quantidade deve ser na unidade de medida cadastrada no sistema
		$quantidade = $this->metro_quadrado_bruto_peca;

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

		// Retornar API TOTVS
		return $apiTotvs;
	}

	public function callApi($url)
	{
		// Iniciar conexão com API TOTVS
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response, true);
		return $response;
	}

	public function plano()
	{
		return $this->belongsTo(Plano::class);
	}

	public function peca()
	{
		return $this->belongsTo(Peca::class);
	}

	public function lote()
	{
		return $this->belongsTo(Lote::class);
	}
}
