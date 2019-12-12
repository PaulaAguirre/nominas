<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use Illuminate\Http\Request;

class SegundoMesDirectaController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $mes_nomina = 201911;
        $nomina_segundo_mes = NominaDirecta::where('id_consideracion', '=', '6')
        ->where('mes', '=', $mes_nomina)->where('estado_consideracion', '=', 'aprobado')
        ->get();

        return view('segundo_mes.create', ['mes_nomina'=>$mes_nomina, 'nomina_segundo_mes'=>$nomina_segundo_mes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $id_persona = $request->get('id_persona');
        $mes_nomina = 201912;
        $cont = 0;

        while ($cont < count($id_persona))
        {
            $persona = NominaDirecta::where('id_persona_directa', $id_persona[$cont])
                ->where('mes', $mes_nomina)->get()->first();
            $persona->id_consideracion = 7;
            $persona->estado_consideracion = 'pendiente';
            $persona->detalles_consideracion = 'fecha de ingreso: '.$persona->personaDirecta->fecha_ingreso;
            $persona->update();
            $cont = $cont+1;
        }

        return redirect('nomina_directa');
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
