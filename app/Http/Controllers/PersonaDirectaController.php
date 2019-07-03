<?php

namespace App\Http\Controllers;

use App\PersonaDirecta;
use Illuminate\Http\Request;
use App\Zona;
use App\Region;
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
        $zonas = Zona::all();
        $regiones = Region::all();
        $jefes = PersonaDirecta::where ('cargo', '=', 'representante jefe')->get();
        $zonales = PersonaDirecta::where('cargo', '=', 'representante zonal')->get();

        return view('personasDirecta.create', ['zonas'=>$zonas, 'regiones'=>$regiones,
                                                    'jefes'=>$jefes, 'zonales'=>$zonales]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $persona_directa = new PersonaDirecta($request->all());
        $persona_directa->activo = 'A';
        $persona_directa->save();

        return redirect('personasDirecta');
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
        $jefes = PersonaDirecta::where ('cargo', '=', 'representante jefe')->get();
        $zonales = PersonaDirecta::where('cargo', '=', 'representante zonal')->get();
        $cargos_go = ['go1', 'go2', 'go3'];

        return view('personasDirecta.edit', ['jefes'=>$jefes, 'zonales'=>$zonales, 'persona' => $persona, 'cargos_go' => $cargos_go]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $persona)
    {
        dd($persona);

        $region = PersonaDirecta::findOrFail($request->get('rep_zonal_id'))->zona->region->region;
        $zona = PersonaDirecta::findOrFail($request->get('rep_zonal_id'))->zona->zona;
        //obtenemos la region y zona a la que pertenece el zonal, para asignarle al asesor

        //dd($zona);

        $persona = PersonaDirecta::findOrFail($id);

        $persona->ch = $request->get('ch');
        $persona->nombre = $request->get('nombre');
        $persona->documento_persona = $request->get('documento_persona');
        $persona->id_representante_zonal = $request->get('rep_zonal_id');
        $persona->id_representante_jefe = $request->get('rep_jefe_id');
        $persona->cargo_go = $request->get('cargo_go');
        $persona->activo = $request->get('activo');
        $persona->region = $region;
        $persona->zona = $zona;
        $persona->cargo = 'representante';

        $persona->update();

       // dd('Hecho');


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
