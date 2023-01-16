<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabrica extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nome'
	];

	public function maquinas()
	{
		return $this->hasMany(Maquina::class);
	}
}
