<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
		return [
			'id' => $this->id,
			'numeroLayout' => $this->numero_layout,
			'quantidadeChapa' => $this->quantidade_chapa,
			'metroQuadradoChapa' => $this->metro_quadrado_chapa,
			'aproveitamento' => $this->aproveitamento,
			'carregamentos' => $this->carregamentos,
			'tempoCorte' => $this->tempo_corte,
			'metroCubico' => $this->metro_cubico,
			'quantidadePorCorte' => $this->quantidade_por_corte,
			'percentualOcupacaoMaquina' => $this->percentual_ocupacao_maquina,
			'custoPorMetro' => $this->custo_por_metro,
			'cortesN1' => $this->cortes_n1,
			'cortesN2' => $this->cortes_n2,
			'cortesN3' => $this->cortes_n3,
			'active' => $this->active,
			'projeto' => new ProjetoResource($this->whenLoaded('projeto')),
			'chapa' => new ChapaResource($this->whenLoaded('chapa')),
		];

        // return parent::makeHidden(['created_at', 'updated_at'])
		// 	->toArray($request);
    }
}
