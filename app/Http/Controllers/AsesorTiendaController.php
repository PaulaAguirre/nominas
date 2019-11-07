<?php

namespace App\Http\Controllers;

use App\AsesorTienda;
use Illuminate\Http\Request;

class AsesorTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $asesor_id = $request->get('asesor_id');
        $asesores = AsesorTienda::asesor($asesor_id)->get();

        return view('tiendas.asesores.index', ['asesores'=>$asesores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asesores =
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
     * @param  \App\AsesorTienda  $asesorTienda
     * @return \Illuminate\Http\Response
     */
    public function show(AsesorTienda $asesorTienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AsesorTienda  $asesorTienda
     * @return \Illuminate\Http\Response
     */
    public function edit(AsesorTienda $asesorTienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AsesorTienda  $asesorTienda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AsesorTienda $asesorTienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AsesorTienda  $asesorTienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(AsesorTienda $asesorTienda)
    {
        //
    }
}
