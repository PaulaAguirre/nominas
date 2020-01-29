<?php

namespace App\Http\Controllers;

use App\ArchivoIndirecta;
use App\NominaIndirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConsideracionIndirectaController extends Controller
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

    public function agregarConsideracion(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);
        $impulsador->id_consideracion = $request->get('id_consideracion');
        $impulsador->detalles_consideracion = $request->get('detalles_consideracion');
        $impulsador->estado_consideracion = 'pendiente';
        $impulsador->fecha_carga_consideracion = (Carbon::now())->format('d-m-Y');

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);

            $archivo = new ArchivoIndirecta();
            $archivo->nomina_indirecta_id = $impulsador->id;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'consideracion';
            $archivo->save();
        }

        $impulsador->update();
        return redirect()->back();
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
