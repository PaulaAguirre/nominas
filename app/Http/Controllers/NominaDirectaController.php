<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use App\PersonaDirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
    public function create(Request $request)
    {
            $id_rep_zonal = $request->get('id_zonal');
            $id_rep_jefe = $request->get('id_jefe');
            $id_rep = $request->get('id_representante');

            $jefes = PersonaDirecta::where('cargo', 'representante jefe')->get();
            $zonales = PersonaDirecta::where('cargo', '=', 'representante zonal')->get();
            $personas_directa = PersonaDirecta::representantesdir($id_rep)->zonal($id_rep_zonal)->jefe($id_rep_jefe)->get();

            return view('nomina_directa.create', ['personas_directa' => $personas_directa, 'jefes' => $jefes, 'zonales'=>$zonales]);
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
