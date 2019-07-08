<?php
/**
 * Copyright (c) 2019
 */

namespace App\Http\Controllers;
use App\Consideracion;
use App\Http\Requests\NominaRequest;
use App\NominaDirecta;
use App\PersonaDirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class NominaDirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mes = $request->get('mes');

        $id_persona= $request->get('id_persona');
        $personas = NominaDirecta::representante($id_persona)->mes($mes)->get();

        return view('nomina_directa.index', ['personas' => $personas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
            $mes_actual= Carbon::now()->format('Ym');
            $mes_siguiente = Carbon::now()->addMonth()->format ('Ym');
            $mes_anterior = Carbon::now()->format('Ym'); //porque en junio se carga lo de julio
            $mes_nomina = Carbon::now()->addMonth();


            $meses = [$mes_actual,$mes_siguiente];

            $id_rep_jefe = $request->get('id_jefe');
            $id_rep = $request->get('id_representante');

            /**los asesores que ya se encuentran en la nomina que no deben aparecer entre los que estan para agregar**/
            $representantes_existentes = NominaDirecta::where('mes', $mes_nomina->format('Ym'))
                ->get()->pluck('id_persona_directa')->toArray();

            $jefes = PersonaDirecta::where('cargo', 'representante_jefe')->get();
            $personas_directa = PersonaDirecta::whereNotIn('id_persona', $representantes_existentes)
            ->representantesdir($id_rep)->jefe($id_rep_jefe)
                ->get();

            return view('nomina_directa.create', ['personas_directa' => $personas_directa, 'jefes' => $jefes,
                             'meses'=>$meses, 'mes_nomina'=>$mes_nomina]);
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
        $activo = $request->get('activo');
        $cont = 0;
        $mes_nomina = Carbon::now()->addMonth()->format ('Ym');
        $persona_mes = $request->get('persona_mes');

        /**
         * Validaciones
         */
        $messages = [];
        $rules = [];

        foreach ($request->get('persona_mes') as $key => $val)
        {
            $persona = PersonaDirecta::findOrFail($personas_id[$key]);
            $rules['persona_mes.'.$key] = 'unique:nomina_directa,persona_mes';
            $messages['persona_mes.'.$key.'.unique'] = 'Asesor duplicado: '. $persona->nombre;
        }
        $this->validate($request, $rules, $messages);


        while ($cont < count($personas_id))
        {

            $nomina = new NominaDirecta();
            $nomina->id_persona_directa = $personas_id[$cont];
            $nomina->mes = $mes_nomina ;
            $nomina->persona_mes = $persona_mes[$cont] ;
            $nomina->activo = $activo[$cont];
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


    public function agregarConsideraciones ($id)
    {
        $persona_nomina = NominaDirecta::findOrFail($id); //->personaDirecta;
        $consideraciones = Consideracion::all();

        return view('nomina_directa.consideracion_nomina',
            ['persona_nomina' => $persona_nomina,
            'consideraciones' => $consideraciones ]);
    }

    public function storeConsideraciones (Request $request, $id)
    {
        $nominaDirecta = NominaDirecta::findOrFail($id);
        $nominaDirecta->id_consideracion = $request->get('id_consideracion');
        $nominaDirecta->detalles_consideracion = $request->get('detalles_consideracion');

        $nominaDirecta->update();
        dd('hecho');

    }
}
