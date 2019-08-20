<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NominaDirecta;
use App\PersonaDirecta;

class InactivacionesDirectaController extends Controller
{
    /**
     * InactivacionesDirectaController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = auth()->user()->zonas->pluck('id');

        $inactivaciones = NominaDirecta::where('estado_inactivacion', '<>', 'NULL')
            ->get();

        return view('inactivaciones_directa.index', ['inactivaciones'=>$inactivaciones, 'zonas'=>$zonas]);
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
        $persona = NominaDirecta::findOrFail($id);
        return view('inactivaciones_directa.regularizar_inactivacion', ['persona'=>$persona]);
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
        $persona = NominaDirecta::findOrFail($id);
        $persona->estado_inactivacion = 'pendiente';
        $persona->regularizacion_inactivacion = $request->get('regularizacion_inactivacion');
        $persona->update();
        return redirect('inactivaciones_directa');
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
