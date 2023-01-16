<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NecessidadeReaproveitamento extends Model
{

	public function lote()
	{
		return $this->belongsTo(Lote::class);
	}
}
