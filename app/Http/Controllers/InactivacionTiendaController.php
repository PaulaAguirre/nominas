<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NominaTienda;

class InactivacionTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_asesor = $request->get('id_persona');
        $estado_inactivacion = $request->get('estado');
        $porcentajes = ['100%', '75% nuevo', '75%', '50%', 'prorrateado', '25%', 'sin objetivos'];
        $mes = 201911;
        $asesores_inactivos = NominaTienda::where('estado_inactivacion', '=', 'pendiente')
            ->mes($mes)->asesor($id_asesor)->estadoInactivacion($estado_inactivacion)->get();

        return view('tiendas.inactivaciones.index', ['asesores_inactivos'=>$asesores_inactivos,
            'porcentajes'=>$porcentajes, 'mes'=>$mes]);
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

}
