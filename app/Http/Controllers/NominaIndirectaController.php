<?php

namespace App\Http\Controllers;

use App\Consideracion;
use App\Coordinador;
use App\Impulsador;
use App\NominaIndirecta;
use App\ZonaIndirecta;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class NominaIndirectaController extends Controller
{
    /**
     * NominaIndirectaController constructor.
     */
    public function __construct()
    {
        return $this->middleware('canales:indirecta');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $zona_id = $request->get('zona_id');
        $coordinador_id = $request->get('coordinador_id');
        $activo = $request->get('activo');
        $clasificacion = $request->get('clasificacion');
        $impulsador_id = $request->get('impulsador_id');
        $consideraciones = Consideracion::all();
        $mes_nomina = \Config::get('global.mes_indirecta');
        $coordinadores = Coordinador::all();

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas_zonal = \Auth::user()->zonasIndirecta->pluck('id')->toArray();
            $zonas = ZonaIndirecta::whereIn('id', $zonas_zonal)->get();

            $impulsadores = NominaIndirecta::mes($mes_nomina)
                ->zonas($zonas_zonal)
                ->coordinador($coordinador_id)
                ->zona($zona_id)
                ->activo($activo)->impulsadorInd($impulsador_id)
                ->orderBy('id')
                ->get();
        }
        else
        {
            $zonas = ZonaIndirecta::all();
            $impulsadores = NominaIndirecta::mes($mes_nomina)
                ->coordinador($coordinador_id)
               ->zona($zona_id)
                ->activo($activo)->impulsadorInd($impulsador_id)
                ->orderBy('id')
                ->get();
        }

        return \view('indirecta.nomina.index', ['zonas'=>$zonas, 'coordinadores'=>$coordinadores,
            'consideraciones'=>$consideraciones, 'impulsadores'=>$impulsadores]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function create(Request $request)
    {
        $zona_id = $request->get('zona_id');
        $zonas = ZonaIndirecta::all();
        $mes_nomina = \Config::get('global.mes_indirecta');
        $impulsadores_existentes = NominaIndirecta::where('mes', '=', $mes_nomina)->get()->pluck('impulsador_id')->toArray();
        $impulsadores = Impulsador::whereNotIn('id', $impulsadores_existentes)
            ->where('activo', '=', 'ACTIVO')->zonaInd($zona_id)->get();

        return view('indirecta.nomina.create', ['impulsadores'=>$impulsadores, 'mes_nomina'=>$mes_nomina, 'zonas'=>$zonas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $impulsadores_id = $request->get('impulsador_id');
        $cont = 0;
        $impulsador_mes = $request->get('impulsador_mes');
        $mes_nomina = \Config::get('global.mes_indirecta');

        while ($cont < count($impulsadores_id))
        {
            $nomina = new NominaIndirecta();
            $nomina->impulsador_id = $impulsadores_id[$cont];
            $nomina->impulsador_mes = $impulsador_mes[$cont];
            $nomina->mes = $mes_nomina;
            $nomina->save();
            $cont = $cont+1;
        }

        return redirect('nomina_indirecta/create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param NominaIndirecta $nominaIndirecta
     * @return Response
     */
    public function edit(NominaIndirecta $nominaIndirecta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NominaIndirecta $nominaIndirecta
     * @return Response
     */
    public function update(Request $request, NominaIndirecta $nominaIndirecta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NominaIndirecta $nominaIndirecta
     * @return Response
     */
    public function destroy(NominaIndirecta $nominaIndirecta)
    {
        //
    }
}
