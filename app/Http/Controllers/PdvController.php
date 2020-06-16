<?php

namespace App\Http\Controllers;

use App\pdv;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Impulsador;
use Illuminate\View\View;

class PdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        $impulsador_id = $request->get('impulsador_id');
        $pdv_id = $request->get('pdv_id');
        $pdvs = Pdv::impulsadorPDV($impulsador_id)->pdv($pdv_id)->get();
        $impulsadores = Impulsador::where('clasificacion_id', '=', '1')->get();
        return view('indirecta.pdvs.index', ['pdvs'=>$pdvs, 'impulsadores'=>$impulsadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {

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
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function show(pdv $pdv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function edit(pdv $pdv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pdv $pdv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pdv  $pdv
     * @return \Illuminate\Http\Response
     */
    public function destroy(pdv $pdv)
    {
        //
    }
}
