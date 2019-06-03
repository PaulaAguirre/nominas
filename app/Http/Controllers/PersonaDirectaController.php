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
     *
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonaDirecta $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaDirecta  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonaDirecta $persona)
    {
        //
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
