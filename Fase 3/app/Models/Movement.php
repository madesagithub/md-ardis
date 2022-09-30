<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movements';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'ordem_id',
		'base',
		'chapa_id',
		'dep_origem',
		'loc_origem',
		'dep_destino',
		'loc_destino',
		'quantidade',
		'cod_emitente',
		'success',
		'message',
	];

	public static function RegisterMovement(array $data, $response)
	{
		$movement = new Movement();
		$movement->ordem_id = $data['ordem']->id;
		$movement->base = $data['base'];
		$movement->chapa_id = $data['item']->id;
		$movement->dep_origem = $data['dep_origem'];
		$movement->loc_origem = $data['loc_origem'];
		$movement->dep_destino = $data['dep_destino'];
		$movement->loc_destino = $data['loc_destino'];
		$movement->quantidade = $data['quantidade'];
		$movement->cod_emitente = $data['cod_emitente'];
		$movement->success = $response && $response['retorno'] == 'OK' ? true : false;
		$movement->message = $response ? Ordem::getErros($response) : 'Invalid API address';
		$movement->save();
	}
}
