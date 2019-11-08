<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NominaTienda;
use App\AsesorTienda;

class NominaTiendaController extends Controller
{
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
        $mes_nomina = 201911;
        $asesores_existentes = NominaTienda::where('mes', '=', $mes_nomina)->get()->pluck('id_asesor')->toArray();
        $asesores = AsesorTienda::where('activo', '=', 'activo')
            ->whereNotIn('id_asesor', $asesores_existentes)
            ->get();
        return view('tiendas.nomina.create', ['asesores'=>$asesores, 'mes_nomina'=>$mes_nomina]);
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
        $mes_nomina = '201911';

        while ($cont < count($asesores_id))
        {
            $nomina = new NominaTienda();
            $nomina->id_asesor = $asesores_id[$cont];
            $nomina->mes = $mes_nomina;
            $nomina->asesor_mes = $asesor_mes[$cont];

            $nomina->save();
            $cont = $cont+1;
        }

        dd('ok');

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
