<?php

namespace App\Http\Controllers;

use App\PersonaDirecta;
use Illuminate\Http\Request;
use App\Zona;
use App\Region;
use Illuminate\Validation\Rule;

class PersonaDirectaController extends Controller
{
    /**
     * PersonaDirectaController constructor.
     */
    public function __construct()
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = ($request->get('name'));
        $personasDirecta = PersonaDirecta::representantesdir('')->name($name)->get();


        return view('personasDirecta.index', ['personasDirecta' => $personasDirecta]);

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
        return view('personasDirecta.create', ['jefes'=>$jefes, 'cargos_go' => $cargos_go]);
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

        $id_zona = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->zona->id_zona;
        $id_representante_jefe = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->id_persona;
        $asesor = new PersonaDirecta($request->all());
        $asesor->id_representante_jefe = $id_representante_jefe;
        $asesor->id_zona = $id_zona;
        $asesor->cargo =  'representante';

        $asesor->save();

        //dd('hecho');
        return redirect('representantes_directa');
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

        return view('personasDirecta.edit', ['jefes'=>$jefes, 'persona' => $persona, 'cargos_go' => $cargos_go]);
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
        $url = $request->get('url');
        $id_zona = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->zona->id_zona;
        $id_representante_jefe = PersonaDirecta::findOrFail($request->get('rep_jefe_id'))->id_persona;

        $asesor->fill($request->all());
        $asesor->id_representante_jefe = $id_representante_jefe;
        $asesor->id_zona = $id_zona;
        $asesor->update();

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
}
