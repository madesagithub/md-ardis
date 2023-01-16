<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'referencia',
	];

	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}

	public function pecas()
	{
		return $this->belongsToMany(Peca::class);
	}

	public function lotes()
	{
		return $this->hasMany(Lote::class);
	}
}
