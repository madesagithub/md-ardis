<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRetalhoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'planoId' => ['required', 'integer'],
			'comprimentoPeca' => ['required', 'integer'],
			'larguraPeca' => ['required', 'integer'],
			'espessuraPeca' => ['required', 'integer'],
			'quantidadeProgramada' => ['required', 'integer'],
			'quantidadeProduzida' => ['required', 'integer'],
			'metroQuadradoBrutoPeca'  => ['required', 'float'],
			'metroQuadradoLiquidoPeca' => ['required', 'float'],
			'metroQuadradoLiquidoTotalPeca' => ['required', 'float'],
			'metroCubicoLiquidoTotalPeca' => ['required', 'float'],
			'pecasSuperproducao' => ['required', 'integer', 'float'],
			'metroQuadradoSuperproducao' => ['required', 'float'],
			'percentualPecaPlano' => ['required', 'float'],
			'logicaArdisId' => ['required', 'float'],
			'nivel' => ['required', 'integer'],
			'prioridade' => ['required', 'integer'],
			'percentualProduzido' => ['required', 'float'],
        ];
    }

	protected function prepareForValidation() {
		$this->merge([
			'plano_id' => $this->planoId,
			'comprimento_peca' => $this->comprimentoPeca,
			'largura_peca' => $this->larguraPeca,
			'espessura_peca' => $this->espessuraPeca,
			'quantidade_programada' => $this->quantidadeProgramada,
			'quantidade_produzida' => $this->quantidadeProduzida,
			'metro_quadrado_bruto_peca' => $this->metroQuadradoBrutoPeca,
			'metro_quadrado_liquido_peca' => $this->metroQuadradoLiquidoPeca,
			'metro_quadrado_liquido_total_peca' => $this->metroQuadradoLiquidoTotalPeca,
			'metro_cubico_liquido_total_peca' => $this->metroCubicoLiquidoTotalPeca,
			'pecas_superproducao' => $this->pecasSuperproducao,
			'metro_quadrado_superproducao' => $this->metroQuadradoSuperproducao,
			'percentual_peca_plano' => $this->percentualPecaPlano,
			'logica_ardis_id' => $this->logicaArdisId,
			'percentual_produzido' => $this->percentualProduzido,
		]);
	}
}
