<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamiliaChapa extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'nome',
	];

	public function chapas()
	{
		return $this->hasMany(Chapa::class);
	}
}
