<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogicaArdis extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nome',
	];

	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
}
