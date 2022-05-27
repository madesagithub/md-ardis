<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materiais';

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

	public function planos()
	{
		return $this->hasMany(Plano::class);
	}
}
