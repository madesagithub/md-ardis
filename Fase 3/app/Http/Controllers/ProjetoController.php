<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
	public function start($id)
	{
		$projeto = Projeto::find($id);
		$projeto->iniciarProducao();

		return redirect()->route('projeto.show', $id);
	}

	public function cancelar($id)
	{
		$projeto = Projeto::find($id);
		$projeto->cancelarTotvs();

		return redirect()->route('projeto.index');
	}

	public function confirmar($id)
	{
		$projeto = Projeto::find($id);
		$projeto->confirmarTotvs();

		return redirect()->route('projeto.index');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projetos = Projeto::with(
			'maquina',
			'planos',
			'user',
		)->active()->get();
		
		$status = config('model-status')['status_model_constants'];

		$projetosAnteriores = Projeto::with(
			'maquina',
			'planos',
			'user',
		)->disabled()
		->whereDate('created_at', '>=', Carbon::now()->subWeek(2)->startOfWeek())
		->orderBy('created_at', 'desc')
		->get();

		return view('pages.projeto.projetoIndex', compact('projetos', 'projetosAnteriores', 'status'));
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
        return response()->json('Chegou aqui => store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
		return view('pages.projeto.projetoShow', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projeto $projeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projeto $projeto)
    {
        //
    }
}
