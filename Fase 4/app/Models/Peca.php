<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'codigo',
		'descricao',
		'comprimento_final',
		'largura_final',
		'produto_id',
	];

	public function produtos()
	{
		return $this->belongsToMany(Produto::class);
	}
	
	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
}
