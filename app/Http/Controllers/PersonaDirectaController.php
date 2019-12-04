<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use App\PersonaDirecta;
use App\Zona;
use Illuminate\Http\Request;

class PersonaDirectaController extends Controller
{
    /**
     * PersonaDirectaController constructor.
     */
    public function __construct()
    {
       $this->middleware('roles:zonal,tigo_people_admin')->only(['edit','create', 'regularizarEstructura', 'update']);
       $this->middleware('roles:tigo_people,tigo_people_admin')->only(['aprobarCambioEstructura']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zonas = auth()->user()->zonas->pluck('id')->toArray();
        $id_persona = ($request->get('id_persona'));
        $id_rep_jefe = $request->get('id_jefe');
        $id_zona = $request->get('id_zona');
       $personasDirecta = PersonaDirecta::representantesdir($id_persona)->jefe($id_rep_jefe)
           ->zona($id_zona)->orderBy('nombre')
           ->get();
        $jefes = PersonaDirecta::where('cargo', 'representante_jefe')->get();
        $zonas_user = Zona::all();

        return view('personasDirecta.index', ['personasDirecta' => $personasDirecta, 'zonas'=>$zonas,
            'jefes'=>$jefes, 'zonas_user'=>$zonas_user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jefes = PersonaDirecta::where ('cargo', '=', 'representante_jefe')->get();
        $cargos_go = ['go1', 'go2', 'go3'];
        $agrupaciones = ['MOBILE PRE', 'MOBILE POS', 'HOME', 'B2B'];
        return view('personasDirecta.create', ['jefes'=>$jefes, 'cargos_go' => $cargos_go, 'agrupaciones'=>$agrupaciones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'ch' => 'required|unique:personas_directa'
    ]);

        $id_consideracion = $request->get('id_consideracion');
        $detalles_consideracion = $request->get('detalles_consideracion');
        $id_zona = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->zona->id;
        $id_representante_jefe = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->id_persona;
        $asesor = new PersonaDirecta($request->all());
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->id_representante_jefe = $id_representante_jefe;
        $asesor->id_zona = $id_zona;
        $asesor->cargo =  'representante';
        $asesor->activo='activo';
        $asesor->estado_cambio = 'aprobado';

        $asesor->save();

        /**
         * ingresar en nomina con estado pendiente
        */

        $asesor->id_consideracion = $id_consideracion;
        $asesor->detalles_consideracion = $detalles_consideracion;
        $asesor->save();


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(PersonaDirecta $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *Editar datos de los asesores, no así de los zonales o regionales
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persona = PersonaDirecta::findOrFail($id);
        $jefes = PersonaDirecta::where ('cargo', '=', 'representante_jefe')->get();
        $cargos_go = ['go1', 'go2', 'go3'];
        $agrupaciones = ['MOBILE PRE', 'MOBILE POS', 'HOME', 'B2B'];

        return view('personasDirecta.edit', ['jefes'=>$jefes, 'persona' => $persona, 'cargos_go' => $cargos_go, 'agrupaciones'=>$agrupaciones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $asesor = PersonaDirecta::findOrFail($id);
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
            $asesor->estado_cambio = 'pendiente';
            $asesor->id_responsable_cambio = auth()->user()->id;
        }


        $nomina = NominaDirecta::where('id_persona_directa', $asesor->id_persona)->get()->last();
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
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function aprobarCambioEstructura(Request $request, $mes)
    {
        $personas = PersonaDirecta::where('estado_cambio', '=', 'pendiente')->get();

        return view('personasDirecta.aprobacion_estructura', ['personas'=>$personas, 'mes' => $mes]);
    }

    public function aprobarCambioEstructuraStore(Request $request)
    {

        $estado_cambio = $request->get('aprobacion');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $id_persona = $request->get('id_persona');
        $cont = 0;

        while ($cont < count($id_persona))
        {
            $persona = PersonaDirecta::findOrFail($id_persona[$cont]);
            $persona->estado_cambio = $estado_cambio[$cont];
            if ($estado_cambio[$cont] == 'aprobado')
            {
                $persona->id_representante_jefe = $persona->id_representante_jefe_nuevo;
                $persona->id_zona = $persona->id_zona_nuevo;
            }
            $persona->motivo_rechazo = $motivo_rechazo[$cont];
            $persona->update();
            $cont = $cont+1;
        }

        return redirect()->back();
    }

    public function regularizarEstructura ($id)
    {
        $persona = PersonaDirecta::findOrFail($id);
        return view('personasDirecta.regularizar_cambio', ['persona' => $persona]);
    }

    public function regularizarEstructuraStore (Request $request, $id)
    {
        $persona = PersonaDirecta::findOrFail($id);
        $persona->regularizacion_cambio = $request->get('regularizacion_cambio');
        $persona->estado_cambio = 'pendiente';
        $persona->update();
        return redirect('representantes_directa');
    }
}
