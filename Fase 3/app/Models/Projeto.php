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

	public function enable()
	{
		$this->active = true;
		$this->save();
	}

	public function disable()
	{
		$this->active = false;
		$this->save();
	}

	public function cancelarTotvs()
	{
		foreach ($this->planos as $plano) {
			$plano->cancelarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->disable();
	}

	public function confirmarTotvs()
	{
		foreach ($this->planos as $plano) {
			$plano->cancelarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->disable();
	}

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
