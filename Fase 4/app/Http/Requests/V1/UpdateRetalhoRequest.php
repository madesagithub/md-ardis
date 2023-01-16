<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRetalhoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
		if ($this->method() == 'PUT')
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
				'pecasSuperproducao' => ['required', 'float'],
				'metroQuadradoSuperproducao' => ['required', 'float'],
				'percentualPecaPlano' => ['required', 'float'],
				'logicaArdisId' => ['required', 'float'],
				'nivel' => ['required', 'integer'],
				'prioridade' => ['required', 'integer'],
				'percentualProduzido' => ['required', 'float'],
			];
		} else {
			return [
				'planoId' => ['sometimes', 'required', 'integer'],
				'comprimentoPeca' => ['sometimes', 'required', 'integer'],
				'larguraPeca' => ['sometimes', 'required', 'integer'],
				'espessuraPeca' => ['sometimes', 'required', 'integer'],
				'quantidadeProgramada' => ['sometimes', 'required', 'integer'],
				'quantidadeProduzida' => ['sometimes', 'required', 'integer'],
				'metroQuadradoBrutoPeca'  => ['sometimes', 'required', 'float'],
				'metroQuadradoLiquidoPeca' => ['sometimes', 'required', 'float'],
				'metroQuadradoLiquidoTotalPeca' => ['sometimes', 'required', 'float'],
				'metroCubicoLiquidoTotalPeca' => ['sometimes', 'required', 'float'],
				'pecasSuperproducao' => ['sometimes', 'required', 'float'],
				'metroQuadradoSuperproducao' => ['sometimes', 'required', 'float'],
				'percentualPecaPlano' => ['sometimes', 'required', 'float'],
				'logicaArdisId' => ['sometimes', 'required', 'float'],
				'nivel' => ['sometimes', 'required', 'integer'],
				'prioridade' => ['sometimes', 'required', 'integer'],
				'percentualProduzido' => ['sometimes', 'required', 'float'],
			];
		}
    }

	protected function prepareForValidation()
	{
		// $this->merge([
		// 	'plano_id' => $this->planoId,
		// 	'comprimento_peca' => $this->comprimentoPeca,
		// 	'largura_peca' => $this->larguraPeca,
		// 	'espessura_peca' => $this->espessuraPeca,
		// 	'quantidade_programada' => $this->quantidadeProgramada,
		// 	'quantidade_produzida' => $this->quantidadeProduzida,
		// 	'metro_quadrado_bruto_peca' => $this->metroQuadradoBrutoPeca,
		// 	'metro_quadrado_liquido_peca' => $this->metroQuadradoLiquidoPeca,
		// 	'metro_quadrado_liquido_total_peca' => $this->metroQuadradoLiquidoTotalPeca,
		// 	'metro_cubico_liquido_total_peca' => $this->metroCubicoLiquidoTotalPeca,
		// 	'pecas_superproducao' => $this->pecasSuperproducao,
		// 	'metro_quadrado_superproducao' => $this->metroQuadradoSuperproducao,
		// 	'percentual_peca_plano' => $this->percentualPecaPlano,
		// 	'logica_ardis_id' => $this->logicaArdisId,
		// 	'percentual_produzido' => $this->percentualProduzido,
		// ]);

		$data = [];

		foreach ($this->toArray() as $obj) {
			$obj['plano_id'] = $obj['planoId'] ?? null;
			$obj['comprimento_peca'] = $obj['comprimentoPeca'] ?? null;
			$obj['largura_peca'] = $obj['larguraPeca'] ?? null;
			$obj['espessura_peca'] = $obj['espessuraPeca'] ?? null;
			$obj['quantidade_programada'] = $obj['quantidadeProgramada'] ?? null;
			$obj['quantidade_produzida'] = $obj['quantidadeProduzida'] ?? null;
			$obj['metro_quadrado_bruto_peca'] = $obj['metroQuadradoBrutoPeca'] ?? null;
			$obj['metro_quadrado_liquido_peca'] = $obj['metroQuadradoLiquidoPeca'] ?? null;
			$obj['metro_quadrado_liquido_total_peca'] = $obj['metroQuadradoLiquidoTotalPeca'] ?? null;
			$obj['metro_cubico_liquido_total_peca'] = $obj['metroCubicoLiquidoTotalPeca'] ?? null;
			$obj['pecas_superproducao'] = $obj['pecasSuperproducao'] ?? null;
			$obj['metro_quadrado_superproducao'] = $obj['metroQuadradoSuperproducao'] ?? null;
			$obj['percentual_peca_plano'] = $obj['percentualPecaPlano'] ?? null;
			$obj['logica_ardis_id'] = $obj['logicaArdisId'] ?? null;
			$obj['percentual_produzido'] = $obj['percentualProduzido'] ?? null;
			
			$data[] = $obj;
		}

		$this->merge($data);
	}
}
