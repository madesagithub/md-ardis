<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RetalhoResource extends JsonResource
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
			// 'planoId' => $this->plano_id,
			'comprimentoPeca' => $this->comprimento_peca,
			'larguraPeca' => $this->largura_peca,
			'espessuraPeca' => $this->espessura_peca,
			// 'quantidade_programada' => $this->quantidade_programada,
			'quantidade_produzida' => $this->quantidade_produzida,
			// 'metro_quadrado_bruto_peca' => 
			// 'metro_quadrado_liquido_peca' => 
			// 'metro_quadrado_liquido_total_peca' => 
			// 'metro_cubico_liquido_total_peca' => 
			// 'pecas_superproducao' => 
			// 'metro_quadrado_superproducao' => 
			// 'percentual_peca_plano' => 
			// 'logica_ardis_id' => 
			// 'nivel' => 
			// 'prioridade' => 
			// 'percentual_produzido":' => 
			'plano' => new PlanoResource($this->whenLoaded('plano')),
		];
        
		// return parent::makeHidden(['created_at', 'updated_at'])
		// 	->loadMissing([
		// 		'plano' => new PlanoResource($this->whenLoaded('plano')),
		// 	])
		// 	->toArray($request);
    }
}
