<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'nome',
		'maquina_id',
		'deposito_id',
		'user_id',
		'data_processamento',
		'active'
	];

	/**
	 * The relationships that should always be loaded.
	 *
	 * @var array
	 */
	protected $with = [
		// 'planos',
		// 'maquina',
		// 'ordens',
		// 'user'
	];

	public function planos()
	{
		return $this->hasMany(Plano::class);
	}

	public function maquina()
	{
		return $this->belongsTo(Maquina::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
