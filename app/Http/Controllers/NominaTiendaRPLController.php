<?php

namespace App\Http\Controllers;

use App\Consideracion;
use App\NominaTiendaRPL;
use App\Teamleader;
use App\Tienda;
use App\ZonaTienda;
use Illuminate\Http\Request;

class NominaTiendaRPLController extends Controller
{
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
        $mes_nomina = \Config::get('global.mes_anterior_tienda');
        $teamleaders = Teamleader::all();

        if (\Auth::user()->hasRoles(['zonal']))
        {

            $zonas = \Auth::user()->zonasTienda->pluck('id')->toArray();
            $tiendas = Tienda::whereIn('zona_id', $zonas)->get();
            $zonas_tienda = ZonaTienda::whereIn('id', $zonas)->get();

            $asesores = NominaTiendaRPL::mes($mes_nomina)
                ->tiendas($zonas)
                ->zona($zona_id)->tienda($tienda_id)->activo($activo)->asesor($asesor_id)->teamleader($teamleader_id)
                ->orderBy('id')
                ->get();


        }
        else
        {
            $tiendas=Tienda::all();
            $zonas_tienda = ZonaTienda::all();
            $asesores = NominaTiendaRPL::mes($mes_nomina)
                ->zona($zona_id)->tienda($tienda_id)->activo($activo)->asesor($asesor_id)->teamleader($teamleader_id)
                ->orderBy('id')
                ->get();
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
     * @param  \App\NominaTiendaRPL  $nominaTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function show(NominaTiendaRPL $nominaTiendaRPL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NominaTiendaRPL  $nominaTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function edit(NominaTiendaRPL $nominaTiendaRPL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NominaTiendaRPL  $nominaTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NominaTiendaRPL $nominaTiendaRPL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NominaTiendaRPL  $nominaTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function destroy(NominaTiendaRPL $nominaTiendaRPL)
    {
        //
    }
}
