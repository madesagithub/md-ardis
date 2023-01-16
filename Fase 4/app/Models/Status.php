<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	public const PENDENTE = 'PENDENTE'; 
	public const PRODUZINDO = 'PRODUZINDO'; 
	public const CANCELADO = 'CANCELADO';
	public const ERRO = 'ERRO'; 
	public const FINALIZADO = 'FINALIZADO';
}
