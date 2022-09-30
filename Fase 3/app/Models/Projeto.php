<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class Projeto extends Model
{
	use HasStatuses;

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

	public function scopeActive($query)
	{
		return $query->where('active', true);
	}

	public function scopeDisabled($query)
	{
		return $query->where('active', false);
	}

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

	/**
	 * Retorna o tempo de produção do projeto
	 *
	 * @return duration
	 */
	public function getTempoProducao() {
		switch ($this->status) {
			case(Status::PRODUZINDO):
				$start = $this->status()->created_at;
				$finish = Carbon::now();
				break;
			case(Status::FINALIZADO):
				$start = $this->status()->firstWhere('name', Status::PRODUZINDO)->created_at;
				$finish = $this->status()->created_at;
				break;
			case(Status::CANCELADO):
				$start = $this->status()->firstWhere('name', Status::PRODUZINDO)->created_at;
				$finish = $this->status()->firstWhere('name', Status::CANCELADO)->created_at;
				break;
			default:
				$duration = null;
		}
		
		$duration = $finish->diff($start);

		return $duration;
	}

	public function iniciarProducao() {
		$planos = $this->planos->where('status', Status::PENDENTE);
		foreach ($planos as $plano) {
			$plano->iniciarProducao();
		}
		$this->setStatus(Status::PRODUZINDO);
	}

	public function cancelar()
	{
		$planos = $this->planos->where('status', Status::PRODUZINDO);
		foreach ($planos as $plano) {
			$plano->cancelar();
		}

		$this->atualizarStatus();
	}

	public function confirmar()
	{
		$planos = $this->planos->where('status', Status::PRODUZINDO);
		foreach ($planos as $plano) {
			$plano->confirmar();
		}

		$this->atualizarStatus();
	}

	public function atualizarStatus() {
		$arrayStatus = $this->planos->pluck('status')->toArray();

		if (in_array(Status::PENDENTE, $arrayStatus)) {
			$this->enable();
			if ($this->status != Status::PENDENTE) {
				$this->setStatus(Status::PENDENTE);
			}
		} elseif (in_array(Status::PRODUZINDO, $arrayStatus)) {
			$this->enable();
			if ($this->status != Status::PRODUZINDO) {
				$this->setStatus(Status::PRODUZINDO);
			}
		} elseif (in_array(Status::CANCELADO, $arrayStatus)) {
			$this->disable();
			if ($this->status != Status::CANCELADO){
				$this->setStatus(Status::CANCELADO);
			}
		} elseif (in_array(Status::ERRO, $arrayStatus)) {
			$this->disable();
			if ($this->status != Status::ERRO) {
				$this->setStatus(Status::ERRO);
			}
		} else {
			$this->disable();
			if ($this->status != Status::FINALIZADO) {
				$this->setStatus(Status::FINALIZADO);
			}
		}
	}

	public function planos()
	{
		return $this->hasMany(Plano::class);
	}

	public function maquina()
	{
		return $this->belongsTo(Maquina::class);
	}

	public function deposito()
	{
		return $this->belongsTo(Deposito::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
