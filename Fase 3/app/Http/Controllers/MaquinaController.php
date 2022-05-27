<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Projeto;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		$projeto = Projeto::create([
			'nome' => 'teste',
			'numero' => 1,
			'material_id' => 1,
			'maquina_id' => 1,
			// 'tempo_maquina' => $data->tempo_maquina,
			'tempo_maquina' => date('H:m:s', time()),
			'user_id' => 1,
			'aproveitamento' => 100,
			// 'tempo' => $data->tempo,
			'tempo' => date('H:m:s', time()),
			// 'data_processamento' => date($data->data_processamento),
			'data_processamento' => date('Y-m-d H:m:s', time()),
			// 'hora_processamento' => date('H:m:s', time()),
			// 'hora_processamento' => $data->hora_processamento,
			'active' => 1,
		]);


		// $usuario = Usuario::firstWere('nome', 'Alexandre');
		$maquina = Maquina::firstWhere('nome', 'teste');

        if (! $maquina) {
			$maquina = Maquina::create([
				'nome' => 'teste',
			]);
		}
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
     * @param  \App\Models\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function show(Maquina $maquina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function edit(Maquina $maquina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maquina $maquina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maquina  $maquina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maquina $maquina)
    {
        //
    }
}
