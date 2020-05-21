<?php

namespace App\Http\Controllers;

use App\ArchivoTiendaRPL;
use App\AsesorTiendaRPL;
use App\NominaTiendaRPL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AsesorTiendaRPLController extends Controller
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
     * @param  \App\AsesorTiendaRPL  $asesorTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function show(AsesorTiendaRPL $asesorTiendaRPL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AsesorTiendaRPL  $asesorTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function edit(AsesorTiendaRPL $asesorTiendaRPL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AsesorTiendaRPL  $asesorTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AsesorTiendaRPL $asesorTiendaRPL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);
        $asesor->motivo_inactivacion = $request->get('motivo_inactivacion');
        $asesor->detalles_inactivacion = $request->get('detalles_inactivacion');
        $asesor->estado_inactivacion = 'pendiente';

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoTiendaRPL();
            $archivo->nomina_tienda_id = $asesor->id;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'inactivacion';
            $archivo->save();
        }
        $asesor->update();
        return redirect()->back();
    }
}
