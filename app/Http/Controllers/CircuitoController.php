<?php

namespace App\Http\Controllers;

use App\Circuito;
use App\Coordinador;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        $coordinadores = Coordinador::all();

        return view('indirecta.circuitos.create', ['coordinadores'=>$coordinadores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $coordinador_zona = $request->get('coordinador_zona');
        $coordinador_id = $coordinador_zona[0];
        $zona_id = $coordinador_zona[1];
        $this->validate($request, [
            'codigo' => 'required|unique:circuitos'
        ]);
        $circuito = New Circuito();
        $circuito->codigo = strtoupper($request->get('codigo'));
        $circuito->coordinador_id = $coordinador_id;
        $circuito->zona_id = $zona_id;
        $circuito->save();

        return redirect('circuitos');
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
     * @param Request $request
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
