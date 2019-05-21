<?php

namespace App\Http\Controllers;

use App\RepresentanteMesDirecta;
use Illuminate\Http\Request;
use  App\PersonaDirecta;

class RepresentanteMesDirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas_directa = PersonaDirecta::all();
        dd($personas_directa);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $representantes = RepresentanteMesDirecta::all();
        return $representantes;
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
     * @param  \App\RepresentanteMesDirecta  $representanteMes
     * @return \Illuminate\Http\Response
     */
    public function show(RepresentanteMesDirecta $representanteMes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RepresentanteMesDirecta  $representanteMes
     * @return \Illuminate\Http\Response
     */
    public function edit(RepresentanteMesDirecta $representanteMes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RepresentanteMesDirecta  $representanteMes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RepresentanteMesDirecta $representanteMes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RepresentanteMesDirecta  $representanteMes
     * @return \Illuminate\Http\Response
     */
    public function destroy(RepresentanteMesDirecta $representanteMes)
    {
        //
    }
}
