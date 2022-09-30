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

			if (!is_null($response) && $response) {
				if ($response['retorno'] == 'OK') {
					// $this->disable();
					$this->setStatus(Status::CANCELADO);
				} else {
					$erros = $this->getErros($response);
					$this->setStatus(Status::ERRO, $erros);
				}
			} else {
				$this->setStatus(Status::ERRO, 'Invalid API address');
			}
		} else {
			// $this->disable();
			$this->setStatus(Status::CANCELADO);
		}
	}

	public function cancelarTotvs() {
		$api = $this->getApiTotvs('cancel');

		$response = $this->callApi($api);

		return $response;
	}

	public function confirmar() {
		if (env('TOTVS_ENABLE') === true) {
			$response = $this->confirmarTotvs();

			if (!is_null($response) && $response) {
				if ($response['retorno'] == 'OK') {
					// $this->disable();
					$this->setStatus(Status::FINALIZADO);
				} else {
					$erros = $this->getErros($response);
					$this->setStatus(Status::ERRO, $erros);
				}
				// dd($response);
			} else {
				$this->setStatus(Status::ERRO, 'Invalid API address');
			}
		} else {
			// $this->disable();
			$this->setStatus(Status::FINALIZADO);
		}
	}

	public function confirmarTotvs() {
		$api = $this->getApiTotvs('confirm');

		$response = $this->callApi($api);

		return $response;
	}

	/**
	 * Gera o Endereço da api conforme a ação desejada
	 */
	public function getApiTotvs($action) {
		# Item a ser movimentado estoque
		$chapa = $this->plano->chapa;

		# Depósito de origem
		$depOrigem = 'ALM';

		// $fabrica = preg_replace('~[^A-Z]~', '', $this->plano->projeto->maquina->fabrica->nome);
		$fabrica = $this->plano->projeto->maquina->fabrica->nome;

		# Local origem
		if ($fabrica == 'FB') {
			$locOrigem = 'ARDISB';
		} elseif ($fabrica == 'FV') {
			$locOrigem = 'ARDISV';
		}

		if ($action == 'confirm') {
			# Deposito destino
			$depDestino = 'FAB';

			# Local de destino
			$locDestino = '';

		} elseif ($action == 'cancel') {
			# Deposito destino
			$depDestino = 'ALM';

			# Local de destino
			if ($fabrica == 'FB') {
				$locDestino = 'ALMB-A';
			} elseif ($fabrica == 'FV') {
				$locDestino = 'ALMV-A';
			}
		}

		# Quantidade deve ser na unidade de medida cadastrada no sistema
		$quantidade = $this->metro_quadrado_bruto_peca;

		// Dados enviados
		$data = array(
			'ordem' => $this,
			'base' => env('TOTVS_BASE'),
			'cod_chave' => env('TOTVS_KEY'),
			'item' => $chapa,
			'dep_origem' => $depOrigem,
			'loc_origem' => $locOrigem,
			'dep_destino' => $depDestino,
			'loc_destino' => $locDestino,
			'quantidade' => $quantidade,
			'cod_emitente' => env('TOTVS_COD_EMITENTE'),
		);

		# Api para comunicação com o TOTVS
		$url = env('TOTVS_API') 
			.'/WService='. env('TOTVS_BASE') .'/rsapi/rsapi015web'
			.'?codChave='. env('TOTVS_KEY')
			.'&Item='. $chapa->codigo 
			.'&dep_orig='. $depOrigem 
			.'&loc_orig='. $locOrigem 
			.'&dep_dest='. $depDestino 
			.'&loc_dest='. $locDestino 
			.'&quantidade='. str_replace('.', ',', str($quantidade))
			.'&codEmitente='. env('TOTVS_COD_EMITENTE');

		$apiTotvs = array(
			'data' => $data,
			'url' => $url
		);

		// Retornar API TOTVS
		return $apiTotvs;
	}

	public function callApi($api)
	{
		// Iniciar conexão com API TOTVS
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $api['url'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json',
				'Accept: application/json',
				'x-li-format: json',
			],
		]);
		
		$xml = simplexml_load_string(curl_exec($ch));
		$json = json_encode($xml);
		$response = json_decode($json,TRUE);
		curl_close($ch);

		// Registro do movimento
		Movement::registerMovement($api['data'], $response);

		// dd(implode('; ', array_map(function ($entry) {
		// 	return ($entry[key($entry)]);
		//   }, $response['erros']['erro'])));
		return $response;
	}

	public static function getErros(array $entry)
	{
		if (count($entry['erros']['erro']) > 1) {
			$erros = implode('; ', array_map(function ($input) {
				return ($input[key($input)]);
			}, $entry['erros']['erro']));
		} else {
			$erros = $entry['erros']['erro']['mensagem'];
		}
	
		return $erros;
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
