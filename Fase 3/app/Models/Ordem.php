<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class Ordem extends Model
{
	use HasStatuses;

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
		'plano_id',
		'peca_id',
		'produto_id',
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

	public function iniciarProducao() {
		$this->setStatus(Status::PRODUZINDO);
	}

	public function cancelar() {
		if (env('TOTVS_ENABLE') === true) {
			$response = $this->cancelarTotvs();

			if (!is_null($response) && $response->status == '200') {
				// $this->disable();
				$this->setStatus(Status::CANCELADO);
			} else {
				$this->setStatus(Status::ERRO, $response);
			}
		} else {
			// $this->disable();
			$this->setStatus(Status::CANCELADO);
		}
	}

	public function cancelarTotvs() {
		$url = $this->getUrlApiTotvs('cancel');

		$response = $this->callApi($url);

		return $response;
	}

	public function confirmar() {
		if (env('TOTVS_ENABLE') === true) {
			$response = $this->confirmarTotvs();

			if (!is_null($response) && $response->status == '200') {
				// $this->disable();
				$this->setStatus(Status::FINALIZADO);
			} else {
				$this->setStatus(Status::ERRO, $response);
			}
		} else {
			// $this->disable();
			$this->setStatus(Status::FINALIZADO);
		}
	}

	public function confirmarTotvs() {
		$url = $this->getUrlApiTotvs('confirm');

		$response = $this->callApi($url);

		return $response;
	}

	public function getUrlApiTotvs($action) {
		# Item a ser movimentado estoque
		$chapa = $this->plano->chapa->codigo;

		# Depósito de origem
		$depOrigem = 'FAB';

		# Local destino
		$locOrigem = '';

		$fabrica = preg_replace('~[^A-Z]~', '', $this->plano->projeto->maquina->fabrica->nome);

		if ($action == 'cancel') {
			# dep_dest à deposito destino
			$depDestino = 'ALM';

			# Local de destino
			if ($fabrica == 'FB') {
				$locDestino = 'ALMB-A';
			} elseif ($fabrica == 'FV') {
				$locDestino = 'ALMV-A';
			}

		} elseif ($action == 'confirm') {

			// ALTERAR PARA NOVA API TOTVS
		
			# dep_dest à deposito destino
			$depDestino = 'FAB';

			# Local de destino
			if ($fabrica == 'FB') {
				$locDestino = 'ALMB-A';
			} elseif ($fabrica == 'FV') {
				$locDestino = 'ALMV-A';
			}
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

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function lote()
	{
		return $this->belongsTo(Lote::class);
	}
}
