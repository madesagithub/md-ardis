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
		'numero',
		'projeto_id',
		'material_id',
		'aproveitamento',
		'quantidade_material',
		'tempo_processo',
		'active',
	];

	public function ordens()
	{
		return $this->hasMany(Ordem::class);
	}
	
	public function material()
	{
		return $this->belongsTo(Material::class);
	}

	public function projeto()
	{
		return $this->belongsTo(Projeto::class);
	}
}
