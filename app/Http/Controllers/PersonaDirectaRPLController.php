<?php

namespace App\Http\Controllers;

use App\NominaDirectaRPL;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class PersonaDirectaRPLController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaDirectaRPL  $personaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function show(PersonaDirectaRPL $personaDirectaRPL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $persona = PersonaDirectaRPL::findOrFail($id);
        $jefes = PersonaDirecta::where ('cargo', '=', 'representante_jefe')->get();
        $cargos_go = ['go1', 'go2', 'go3'];
        $agrupaciones = ['MOBILE PRE', 'MOBILE POS', 'HOME', 'B2B', 'CONVERGENTE', 'LINCE HOME', 'LINCE MOBILE', 'PUNTO FIJO', 'ASESOR DELIVERY',
            'ASESOR DELIVERY PRE', 'ASESOR DELIVERY POS', 'ASESOR DELIVERY HOME', 'COBRANZAS', 'DIGITAL'  ];
        return view('directaRPL.personas.edit', ['persona'=>$persona, 'jefes'=>$jefes, 'cargos_go'=>$cargos_go,
            'agrupaciones'=>$agrupaciones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $asesor = PersonaDirectaRPL::findOrFail($id);
        $id_zona_anterior = $asesor->id_zona;
        $url = $request->get('url');
        $id_zona_nuevo = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->zona->id;
        $perfil_nuevo = $request->get('agrupacion');
        $perfil_anterior = $request->get('perfil_anterior');
        $detalles_consideracion = $request->get('detalles_consideracion');

        $id_representante_jefe_nuevo = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->id_persona;

        $asesor->fill($request->all());
        $asesor->agrupacion_anterior = $perfil_anterior;
        $asesor->id_representante_jefe_nuevo = $id_representante_jefe_nuevo;
        $asesor->id_zona_nuevo = $id_zona_nuevo;

        if ($id_zona_anterior == $id_zona_nuevo)
        {
            $asesor->id_representante_jefe = $id_representante_jefe_nuevo;
            $asesor->estado_cambio = 'aprobado';
        }
        else
        {
            $asesor->estado_cambio = 'aprobado';
            $asesor->id_zona = $id_zona_nuevo;
            $asesor->id_representante_jefe = $id_representante_jefe_nuevo;
            $asesor->id_responsable_cambio = auth()->user()->id;
        }


        $nomina = NominaDirectaRPL::where('id_persona_directa', $asesor->id_persona)->get()->last();
        if($nomina){
            $nomina->agrupacion = $asesor->agrupacion; //cambia el perfil tambien en nomina

            if ($perfil_nuevo != $perfil_anterior) //comprueba que efectivamente se haya cambiado de perfil
            {
                if ($nomina->id_consideracion)//comprueba que no haya una consideracion cargada.
                {
                    $nomina->detalles_consideracion = $nomina->detalles_consideracion.' *cambio perfil: '.$detalles_consideracion;
                    $nomina->estado_consideracion = 'pendiente';
                }
                else
                {
                    $nomina->id_consideracion = 11;
                    $nomina->detalles_consideracion = $detalles_consideracion;
                    $nomina->estado_consideracion = 'pendiente';
                }
            }

            $asesor->update();
            $nomina->update();
        }

        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaDirectaRPL  $personaDirectaRPL
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaDirectaRPL $personaDirectaRPL)
    {
        //
    }
}
