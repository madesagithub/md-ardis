<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapaResource extends JsonResource
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
			'codigo' => $this->codigo,
			'familia_id' => $this->familia_id,
			'descricao' => $this->descricao,
			'comprimento' => $this->comprimento,
			'largura' => $this->largura,
			'espessura' => $this->espessura,
			'familia' => new FamiliaResource($this->whenLoaded('familia')),
		];
        // return parent::toArray($request);
    }
}
