<?php

namespace App\Http\Controllers;

use App\Impulsador;
use Illuminate\Http\Request;

class ImpulsadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $impulsadores = Impulsador::all();
        return view('indirecta.impulsadores.index', ['impulsadores'=>$impulsadores]);
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
     * @param  \Illuminate\Http\Request  $request
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
