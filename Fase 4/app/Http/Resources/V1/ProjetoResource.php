<?php

namespace App\Http\Resources\V1;

use App\Models\Deposito;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjetoResource extends JsonResource
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
			'nome' => $this->nome,
			'maquina' => new MaquinaResource($this->whenLoaded('maquina')),
			// 'deposito' => new DepositoResource($this->whenLoaded('deposito')),
			// 'user' => new UserResource($this->whenLoaded('user')),
			'dataProcessamento' => $this->data_processamento,
			'active' => $this->active,
		];
    }
}
