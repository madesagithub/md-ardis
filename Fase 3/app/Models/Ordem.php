<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordem extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordens';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		// 'ordem',
		'plano_id',
		'peca_id',
		'comprimento_peca',
		'largura_peca',
		'espessura_peca',
		'quantidade_programada',
		'quantidade_produzida',
		'metro_quadrado_bruto_peca',
		'metro_quadrado_liquido_peca',
		'metro_quadrado_liquido_total_peca',
		'metro_cubico_liquido_total_peca',
		'pecas_superproducao',
		'metro_quadrado_superproducao',
		'percentual_peca_plano',
		'lote_id',
		'logica_ardis',
		'nivel',
		'prioridade',
		'percentual_produzido',
		'data_embalagem',
	];

	public function plano()
	{
		return $this->belongsTo(Plano::class);
	}

	public function peca()
	{
		return $this->belongsTo(Peca::class);
	}

	public function lote()
	{
		return $this->belongsTo(Lote::class);
	}
}
