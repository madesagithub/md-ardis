<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'nome',
		'fabrica_id',
	];

	public function fabrica()
	{
		return $this->belongsTo(Fabrica::class);
	}

	public function projetos()
	{
		return $this->hasMany(Projeto::class);
	}
}
