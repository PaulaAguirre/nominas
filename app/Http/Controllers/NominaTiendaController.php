<?php

namespace App\Http\Controllers;

use App\Tienda;
use App\ZonaTienda;
use Illuminate\Http\Request;
use App\NominaTienda;
use App\AsesorTienda;
use App\Consideracion;
use App\JefeTienda;
use App\Teamleader;

class NominaTiendaController extends Controller
{
    /**
     * NominaTiendaController constructor.
     */
    public function __construct()
    {
        $this->middleware('canales:tiendas');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zona_id = $request->get('zona_id');
        $activo = $request->get('activo');
        $tienda_id = $request->get('tienda_id');
        $teamleader_id =$request->get('teamleader_id');
        $asesor_id = $request->get('asesor_id');
        $consideraciones = Consideracion::all();
        $mes_nomina = 201912;
        $teamleaders = Teamleader::all();

        if (\Auth::user()->hasRoles(['zonal']))
        {

            $zonas = \Auth::user()->zonasTienda->pluck('id')->toArray();
            $tiendas = Tienda::whereIn('zona_id', $zonas)->get();
            $zonas_tienda = ZonaTienda::where('id', $zonas)->get();
            dd($zonas_tienda);
            $asesores = NominaTienda::mes($mes_nomina)
                ->tiendas($zonas)
                ->zona($zona_id)->tienda($tienda_id)->activo($activo)->asesor($asesor_id)->teamleader($teamleader_id)
                ->orderBy('id')
                ->get();


        }
        else
        {
            $tiendas=Tienda::all();
            $zonas_tienda = ZonaTienda::all();
            $asesores = NominaTienda::mes($mes_nomina)
                ->zona($zona_id)->tienda($tienda_id)->activo($activo)->asesor($asesor_id)->teamleader($teamleader_id)
                ->orderBy('id')
                ->get();
        }

        return view('tiendas.nomina.index', ['mes_nomina'=>$mes_nomina, 'asesores'=>$asesores,
            'consideraciones'=>$consideraciones, 'zonas_tienda'=>$zonas_tienda, 'tiendas'=>$tiendas, 'teamleaders'=>$teamleaders]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $zona_id = $request->get('zona_id');
        $zonas_tienda = ZonaTienda::all();
        $mes_nomina = 201912;
        $asesores_existentes = NominaTienda::where('mes', '=', $mes_nomina)->get()->pluck('id_asesor')->toArray();
        $asesores = AsesorTienda::whereNotIn('asesores_tienda.id', $asesores_existentes)
            ->where('asesores_tienda.activo', '=', 'ACTIVO')->get();




        return view('tiendas.nomina.create', ['asesores'=>$asesores, 'mes_nomina'=>$mes_nomina,
            'zonas_tienda'=>$zonas_tienda]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $asesores_id = $request->get('id_asesor');

        $cont = 0;
        $asesor_mes = $request->get('asesor_mes');
        $mes_nomina = '201912';

        while ($cont < count($asesores_id))
        {
            $nomina = new NominaTienda();
            $nomina->id_asesor = $asesores_id[$cont];
            $nomina->mes = $mes_nomina;
            $nomina->asesor_mes = $asesor_mes[$cont];

            $nomina->save();
            $cont = $cont+1;
        }

        return redirect('nomina_tienda/create');

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
    public function destroy(Request $request ,$id)
    {
       //
    }
}
