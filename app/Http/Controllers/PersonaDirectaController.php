<?php

namespace App\Http\Controllers;

use App\PersonaDirecta;
use Illuminate\Http\Request;

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
        $personasDirecta = PersonaDirecta::name($name)->get();


        return view('personasDirecta.index', ['personasDirecta' => $personasDirecta]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas = PersonaDirecta::all();
        dd($personas) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(PersonaDirecta $persona)
    {
        //
    }
}
