<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class RetalhoFilter extends ApiFilter {
	protected $safeParams = [
		'planoId' => ['eq'],
		'comprimentoPeca' => ['eq', 'gt', 'gte', 'lt', 'lte'],
		'larguraPeca' => ['eq', 'gt', 'gte', 'lt', 'lte'],
		'espessuraPeca' => ['eq', 'gt', 'gte', 'lt', 'lte'],
	];

	protected $columnMap = [
		'planoId' => 'plano_id',
		'comprimentoPeca' => 'comprimento_peca',
		'larguraPeca' => 'largura_peca',
		'espessuraPeca' => 'espessura_peca',
	];
}