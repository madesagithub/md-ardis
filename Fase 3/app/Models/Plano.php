<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'nome',
		'numero',
		'material_id',
		'maquina_id',
		'tempo_maquina',
		'user_id',
		'aproveitamento',
		'tempo',
		'data_processamento',
		'active'
	];

	public function ordens()
	{
		$this->hasMany(Ordem::class);
	}

	public function material()
	{
		$this->belongsTo(Material::class);
	}

	public function maquina()
	{
		$this->belongsTo(Maquina::class);
	}

	public function user()
	{
		$this->belongsTo(User::class);
	}
}
