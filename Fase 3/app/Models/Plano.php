<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class Plano extends Model
{
	use HasStatuses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'numero_layout',
		'projeto_id',
		'chapa_id',
		'quantidade_chapa',
		'metro_quadrado_chapa',
		'aproveitamento',
		'carregamentos',
		'tempo_corte',
		'metro_cubico',
		'quantidade_por_corte',
		'percentual_ocupacao_maquina',
		'custo_por_metro',
		'cortes_n1',
		'cortes_n2',
		'cortes_n3',
		'active'
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
		if (!$this->active) {
			$this->active = true;
			$this->save();
		}
	}

	public function disable()
	{
		if ($this->active) {
			$this->active = false;
			$this->save();
		}
	}

	public function iniciarProducao() {
		$ordens = $this->ordens->where('status', Status::PENDENTE);
		foreach ($ordens as $ordem) {
			$ordem->iniciarProducao();
		}
		$this->setStatus(Status::PRODUZINDO);
	}

	public function cancelarTotvs() {
		$ordens = $this->ordens->where('status', Status::PRODUZINDO);
		foreach ($ordens as $ordem) {
			$ordem->cancelarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->atualizarStatus();
	}
	
	public function confirmarTotvs() {
		$ordens = $this->ordens->where('status', Status::PRODUZINDO);
		foreach ($ordens as $ordem) {
			$ordem->confirmarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->atualizarStatus();
	}

	public function atualizarStatus() {
		$arrayStatus = $this->ordens->pluck('status')->toArray();

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
			if ($this->status != Status::CANCELADO) {
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

	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
	
	public function chapa()
	{
		return $this->belongsTo(Chapa::class);
	}

	public function projeto()
	{
		return $this->belongsTo(Projeto::class);
	}
}
