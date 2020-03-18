<?php

namespace App\Http\Controllers;

use App\NominaDirectaRPL;
use Illuminate\Http\Request;

class NominaDirectaRPLController extends Controller
{
    /**
     * NominaDirectaRPLController constructor.
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
        /*$zona_id = $request->get('zona_id');
        $activo = $request->get('activo');
        $tienda_id = $request->get('tienda_id');
        $teamleader_id =$request->get('teamleader_id');
        $asesor_id = $request->get('asesor_id');
        $consideraciones = Consideracion::all();
        $mes_nomina = 202003;
        $teamleaders = Teamleader::all();*/

        if (\Auth::user()->hasRoles(['zonal']))
        {

        }
        else
        {


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
     * @param  \App\NominaDirectaRPL  $nominaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function show(NominaDirectaRPL $nominaDirectaRPL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NominaDirectaRPL  $nominaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function edit(NominaDirectaRPL $nominaDirectaRPL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NominaDirectaRPL  $nominaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NominaDirectaRPL $nominaDirectaRPL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NominaDirectaRPL  $nominaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function destroy(NominaDirectaRPL $nominaDirectaRPL)
    {
        //
    }
}
