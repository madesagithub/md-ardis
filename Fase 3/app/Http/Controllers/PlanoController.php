<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use App\Models\Status;
use Illuminate\Http\Request;
use Spatie\ModelStatus\ModelStatusServiceProvider;

class PlanoController extends Controller
{
	public function cancelar($id)
	{
		$plano = Plano::find($id);
		$plano->cancelar();

		if ($plano->status == Status::CANCELADO) {
			$alert['icon'] = 'warning';
			$alert['title'] = 'Cancelado!';
			$alert['text'] = 'Plano cancelado';
		} elseif ($plano->status == Status::ERRO) {
			$alert['icon'] = 'error';
			$alert['title'] = 'Erro!';
			$alert['text'] = 'Um erro ocorreu';
		}

		if (isset($alert)) {
			return redirect()->route('projeto.show', $plano->projeto->id)->with('alert', $alert);
		} else {
			return redirect()->route('projeto.show', $plano->projeto->id);
		}
	}

	public function confirmar($id)
	{
		$plano = Plano::find($id);
		$plano->confirmar();

		if ($plano->status == Status::FINALIZADO) {
			$alert['icon'] = 'success';
			$alert['title'] = 'Finalizado!';
			$alert['text'] = 'Plano finalizado com sucesso';
		} elseif ($plano->status == Status::ERRO) {
			$alert['icon'] = 'error';
			$alert['title'] = 'Erro!';
			$alert['text'] = 'Um erro ocorreu';
		}

		if (isset($alert)) {
			return redirect()->route('projeto.show', $plano->projeto->id)->with('alert', $alert);
		} else {
			return redirect()->route('projeto.show', $plano->projeto->id);
		}
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
