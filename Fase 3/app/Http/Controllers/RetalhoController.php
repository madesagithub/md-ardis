<?php

namespace App\Http\Controllers;

use App\Models\Retalho;
use Illuminate\Http\Request;

class RetalhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$retalhos = Retalho::with(
			'plano.chapa.familia'
		)->get();

		// $retalhos = Retalho::with(
		// 		'plano.chapa.familia'
		// 	)
		// 	// ->with(['plano.chapa.familia' => function($query){
		// 	// 	return $query->groupBy('nome');
		// 	// }])
		// 	->groupBy('plano.chapa.familia.id')
		// 	->get();
		// 	// ->toSql();
		// 	// ->get()
		// 	// ->dd();

		// $retalhos = $retalhos->groupBy([
		// 	'plano.chapa.familia.nome',
		// 	'comprimento_peca',
		// 	'largura_peca'
		// ]);

		// dd($retalhos);
		// dd($retalhos->first());

        return view('pages.retalho.retalhoIndex', compact('retalhos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function show(Retalho $retalho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function edit(Retalho $retalho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retalho $retalho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retalho  $retalho
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retalho $retalho)
    {
        //
    }
}
