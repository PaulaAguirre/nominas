<?php

namespace App\Http\Controllers;

use App\Circuito;
use App\ClasificacionImpulsadores;
use App\Coordinador;
use App\Impulsador;
use App\NominaIndirecta;
use App\Pdv;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ImpulsadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $impulsadores = Impulsador::all();
        return view('indirecta.impulsadores.index', ['impulsadores'=>$impulsadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {

        $coordinadores = Coordinador::all();
        $clasificaciones = ClasificacionImpulsadores::all();
        $pdvs = Pdv::all();
        return view('indirecta.impulsadores.create', ['clasificaciones'=>$clasificaciones, 'coordinadores'=>$coordinadores,
        'pdvs' => $pdvs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'ch' => 'required|unique:impulsadores'
        ]);

        $pdv_ids = $request->get('idpdv');
        $coordinador_zona = explode('-', $request->get('coordinador_zona'));

        $mes_nomina = \Config::get('global.mes_indirecta');
        $impulsador = new Impulsador();
        $impulsador->ch = $request->get('ch');
        $impulsador->fecha_ingreso = $request->get('fecha_ingreso');
        $impulsador->nombre = strtoupper($request->get('nombre'));
        $impulsador->documento = $request->get('documento');
        $impulsador->coordinador_id = $coordinador_zona[0];
        $impulsador->zona_id = $coordinador_zona[1];
        $impulsador->clasificacion_id = $request->get('clasificacion_id');
        $impulsador->save();

        $nomina = new NominaIndirecta();
        $nomina->mes = $mes_nomina;
        $nomina->impulsador_id = $impulsador->id;
        $nomina->impulsador_mes = $impulsador->id.$mes_nomina;
        $nomina->consideracion_id = $request->get('consideracion_id');
        $nomina->estado_consideracion = 'pendiente';
        $nomina->detalles_consideracion = $request->get('detalles_consideracion');
        $nomina->save();

        //$impulsador->pdvs()->sync($pdv_ids);

        return redirect('agregar_pdv/'.$impulsador->id);
    }

    public function agregarPdvs($impulsador_id)
    {
        //dd($impulsador_id);
        $impulsador =  Impulsador::findOrFail($impulsador_id);
        $coordinador = Coordinador::findOrFail($impulsador->coordinador->id);

        $circuitos = Circuito::where('coordinador_id', '=', $coordinador)
        ->where('zona_id', '=', $impulsador->zona_id)->get();
        dd($circuitos);

    }

    public function agregarPdvsStore(Request $request, $coordinador_id)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Impulsador  $impulsador
     * @return \Illuminate\Http\Response
     */
    public function show(Impulsador $impulsador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Impulsador  $impulsador
     * @return \Illuminate\Http\Response
     */
    public function edit(Impulsador $impulsador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Impulsador  $impulsador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Impulsador $impulsador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Impulsador  $impulsador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Impulsador $impulsador)
    {
        //
    }
}
