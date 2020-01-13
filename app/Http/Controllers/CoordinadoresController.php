<?php

namespace App\Http\Controllers;

use App\Teamleader;
use App\Zona;
use Illuminate\Http\Request;
use App\PersonaDirecta;

class CoordinadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id_coordinador = $request->get('id_coordinador');
        $id_zona = $request->get('id_zona');
        $coordinadores = PersonaDirecta::where('cargo', '=', 'representante_jefe')
            ->coordinador($id_coordinador)->zona($id_zona)->get();
        $zonas = Zona::all();
        return view('coordinadores.index', ['coordinadores'=>$coordinadores, 'zonas'=>$zonas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $zonas = Zona::all();
        return view('coordinadores.create', ['zonas'=>$zonas]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $coordinador  = new PersonaDirecta();
        $coordinador->ch = $request->get('ch');
        $coordinador->nombre = $request->get('nombre');
        $coordinador->documento_persona = $request->get('documento');
        $coordinador->cargo = 'representante_jefe';
        $coordinador->id_zona = $request->get('id_zona');
        $coordinador->save();

        return redirect('coordinadores');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $coordinador = PersonaDirecta::findOrFail($id);
        $zonas = Zona::all();

        return view('coordinadores.edit', ['coordinador'=>$coordinador, 'zonas'=>$zonas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $coordinador = PersonaDirecta::findOrFail($id);
        $coordinador->nombre = $request->get('nombre');
        $coordinador->ch = $request->get('ch');
        $coordinador->documento_persona = $request->get('documento_persona');
        $coordinador->id_zona = $request->get('id_zona');
        $coordinador->update();

        return redirect('coordinadores');
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
