<?php

namespace App\Http\Controllers;

use App\Circuito;
use App\Coordinador;
use App\Pdv;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Impulsador;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use PhpParser\Node\Expr\New_;

class PdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        $impulsador_id = $request->get('impulsador_id');
        $pdv_id = $request->get('pdv_id');
        $coordinador_id = $request->get('coordinador_id');
        $circuito_id = $request->get('circuito_id');
        $auditor_id = $request->get('auditor_id');
        $coordinadores = Coordinador::all();
        $circuitos = Circuito::all();
        $auditores = Impulsador::where('clasificacion_id', '=', 3)->get();
        $pdvs = Pdv::impulsadorPDV($impulsador_id)->pdv($pdv_id)->buscarCircuito($circuito_id)
            ->buscarCoordinador($coordinador_id)->get();
        $impulsadores = Impulsador::where('clasificacion_id', '=', '1')->get();
        return view('indirecta.pdvs.index', ['pdvs'=>$pdvs, 'impulsadores'=>$impulsadores,
            'coordinadores'=>$coordinadores, 'auditores'=>$auditores, 'circuitos'=>$circuitos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        $circuitos = Circuito::all();
        $impulsadores = Impulsador::where('clasificacion_id', '=', 1)->get();

        return view('indirecta.pdvs.create', ['circuitos'=>$circuitos, 'impulsadores'=>$impulsadores]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required|unique:pdvss'
        ]);

        $pdv = New Pdv();
        $pdv->codigo = $request->get('codigo');
        $pdv->circuito_id = $request->get('circuito_id');
        $pdv->nombre =  $request->get('nombre');
        $pdv->impulsador_id = $request->get('impulsador_id');
        $pdv->save();

        return redirect('pdvs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function show(pdv $pdv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pdv = Pdv::findOrFail($id);
        $impulsadores = Impulsador::where('clasificacion_id', '=', '1')->get();
        //dd($impulsadores);
        $circuitos = Circuito::all();

        return \view('indirecta.pdvs.edit', ['pdv' => $pdv, 'impulsadores'=> $impulsadores, 'circuitos'=>$circuitos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pdv = Pdv::findOrFail($id);
        $pdv->update($request->all());
        return redirect('pdvs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pdv = Pdv::findOrFail($id);
        $pdv->delete();

        return redirect('pdvs');
    }
}
