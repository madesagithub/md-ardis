<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Status;
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
		$projeto->cancelar();

		return redirect()->route('projeto.index');
	}

	public function confirmar($id)
	{
		$projeto = Projeto::find($id);
		$projeto->confirmar();

		return redirect()->route('projeto.index');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// Projetos atuais
        $projetos = Projeto::with(
			'maquina',
			'planos',
			'user',
		)->active()->get();

		// Ordenar por data de status
		$projetos = $projetos->sortByDesc(function ($item) {
			return $item->status()->created_at;
		});

		// Ordenar projetos pelo status
		$projetos = $projetos->sortBy(function($projeto) {
			if ($projeto->status == Status::PRODUZINDO) {
				return 0;
			} elseif ($projeto->status == Status::PENDENTE) {
				return 1;
			} elseif ($projeto->status == Status::FINALIZADO) {
				return 2;
			} elseif ($projeto->status == Status::CANCELADO) {
				return 3;
			} else {
				return 4;
			}
		});
		
		// Projetos já finalizado
		$projetosAnteriores = Projeto::with(
			'maquina',
			'planos',
			'user',
		)->disabled()
		->whereHas('statuses', function ($query) {
			$query->where('created_at', '>=', Carbon::now()->subWeek(2)->startOfWeek());
		})
		->get();

		// Ordenar por data de status
		$projetosAnteriores = $projetosAnteriores->sortByDesc(function ($item) {
			return $item->status()->created_at;
		});

		return view('pages.projeto.projetoIndex', compact('projetos', 'projetosAnteriores'));
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
