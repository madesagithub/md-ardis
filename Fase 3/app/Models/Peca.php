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
		'comprimento',
		'largura',
	];
	
	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
}
