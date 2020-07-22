<?php

namespace App\Http\Controllers;

use App\Circuito;
use App\Coordinador;
use App\Impulsador;
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
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        $circuito_id = $request->get('circuito_id');
        $auditor_id = $request->get('auditor_id');
        $coordinador_id = $request->get('coordinador_id');
        $circuitos = Circuito::buscarAuditor($auditor_id)->circuito($circuito_id)->buscarCoordinador($coordinador_id)
            ->orderBy('id')->get();
        $auditores = Impulsador::where('clasificacion_id', '=', 3)->get();
        $coordinadores = Coordinador::all();

        return \view('indirecta.circuitos.index', ['circuitos'=>$circuitos, 'auditores'=>$auditores, 'coordinadores'=>$coordinadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        $coordinadores = Coordinador::all();
        $auditores = Impulsador::where('clasificacion_id', '=', 3)->get();

        return view('indirecta.circuitos.create', ['coordinadores'=>$coordinadores, 'auditores'=>$auditores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $coordinador_zona = explode('-',$request->get('coordinador_zona'));;
        $coordinador_id = $coordinador_zona[0];
        $zona_id = $coordinador_zona[1];

        $this->validate($request, [
            'codigo' => 'required|unique:circuitos'
        ]);
        $circuito = New Circuito();
        $circuito->codigo = strtoupper($request->get('codigo'));
        $circuito->coordinador_id = $coordinador_id;
        $circuito->zona_id = $zona_id;
        $circuito->auditor_id = $request->get('auditor_id');
        $circuito->save();

        return redirect('circuitos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Factory|Application|View
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|Application|View
     */
    public function edit($id)
    {
        $circuito = Circuito::findOrFail($id);
        $coordinadores = Coordinador::all();
        $auditores = Impulsador::where('clasificacion_id', '=', 3)->get();
        return \view('indirecta.circuitos.edit', ['auditores'=>$auditores, 'circuito'=>$circuito, 'coordinadores'=>$coordinadores]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $coordinador_zona = explode('-',$request->get('coordinador_zona'));;
        $coordinador_id = $coordinador_zona[0];
        $zona_id = $coordinador_zona[1];

        $circuito = Circuito::findOrFail($id);

        $circuito->codigo = strtoupper($request->get('codigo'));
        $circuito->coordinador_id = $coordinador_id;
        $circuito->zona_id = $zona_id;
        $circuito->auditor_id = $request->get('auditor_id');
        $circuito->update();
        return redirect('circuitos');
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
