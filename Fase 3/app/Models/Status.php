<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	const CANCELADO = 'CANCELADO';
	const FINALIZADO = 'FINALIZADO';
	const PENDENTE = 'PENDENTE'; 
	const PRODUZINDO = 'PRODUZINDO'; 
	const ERRO = 'ERRO'; 
}
