<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'numero',
		'produto_id',
	];

	public function produto()
	{
		return $this->belongsTo(Produto::class);
	}

	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
}
