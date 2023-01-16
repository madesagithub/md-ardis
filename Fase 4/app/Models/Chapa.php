<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chapas';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'codigo',
		'familia_id',
		'descricao',
		'comprimento',
		'largura',
		'espessura',
	];

	public function planos()
	{
		return $this->hasMany(Plano::class);
	}

	public function familia()
	{
		return $this->belongsTo(FamiliaChapa::class);
	}
}
