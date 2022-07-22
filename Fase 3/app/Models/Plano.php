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
		$this->active = true;
		$this->save();
	}

	public function disable()
	{
		$this->active = false;
		$this->save();
	}

	public function iniciarProducao() {
		$ordens = $this->ordens->where('status', Status::PENDENTE);
		foreach ($ordens as $ordem) {
			$ordem->iniciarProducao();
		}
		$this->setStatus(Status::PRODUZINDO);
	}

	public function cancelarTotvs() {
		foreach ($this->ordens as $ordem) {
			$ordem->cancelarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->disable();
		$this->setStatus(Status::CANCELADO);
	}

	public function confirmarTotvs() {
		foreach ($this->ordens as $ordem) {
			$ordem->confirmarTotvs();
		}

		// Verificar respostas do TOTVS
		$this->disable();
		$this->setStatus(Status::FINALIZADO);
	}

	public function atualizarStatus() {
		$array = $this->ordens->pluck('status')->toArray();

		if (in_array('CANCELADO', $array) || in_array('EM PROCESSAMENTO', $array)) {
			$this->enable();
		} else {
			$this->disable();
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
