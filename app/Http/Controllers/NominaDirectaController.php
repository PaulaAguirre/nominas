<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use App\PersonaDirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NominaDirectaController extends Controller
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
        //$mes = NominaDirecta::all()->first()->mes; //devuelve el último mes de la nómina anterior
        $personas_directa = PersonaDirecta::where('cargo_go', '<>', 'NULL')->get();
        return view('nominaDirecta.create', ['personas_directa' => $personas_directa]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personas_id = $request->get('idrepresentante');
        $consideraciones = $request->get('consideraciones');
        $cont = 0;

        while ($cont < count($personas_id))
        {
            $nomina = new NominaDirecta();
            $nomina->id_persona_directa = $personas_id[$cont];
            $nomina->mes = '201905';
            $nomina->consideraciones = $consideraciones[$cont];
            $nomina->save();
            $cont = $cont + 1;
        }
        return redirect('nomina_directa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function show(NominaDirecta $nominaDirecta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function edit(NominaDirecta $nominaDirecta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NominaDirecta $nominaDirecta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function destroy(NominaDirecta $nominaDirecta)
    {
        //
    }
}
