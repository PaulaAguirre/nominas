<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Consideracion;
use App\NominaDirecta;
use App\PersonaDirecta;

class ConsideracionesDirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mes_nomina = NominaDirecta::all()->last()->mes;
        $personas_consideracion = NominaDirecta::where('estado_consideracion', '<>', 'NULL')
            ->where('mes', $mes_nomina)
            ->get();

        return view('consideraciones_directa.index', ['personas_consideracion' => $personas_consideracion]);
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
        $persona = NominaDirecta::findOrFail($id);
        return view('inactivaciones_directa.regularizar_consideracion', ['persona'=>$persona]);
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
        $persona = NominaDirecta::findOrFail($id);
        $persona->estado_consideracion = 'pendiente';
        $persona->regularizacion_consideracion = $request->get('regularizacion_consideracion');
        $persona->update();
        return redirect('inactivaciones_directa');
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

    public function aprobarConsideraciones ($mes)
    {
        $personas_consideracion = NominaDirecta::where('estado_consideracion', '=', 'pendiente')
            ->where('mes', $mes)
            ->get();

        return view('consideraciones_directa.aprobacion', ['personas_consideracion' => $personas_consideracion, 'mes'=>$mes]);

    }

    public function storeConsideraciones (Request $request)
    {
        $nomina = $request->get('id_nomina');
        $estado_consideracion = $request->get('aprobacion');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $cont = 0;

        while ($cont < count($nomina))
        {
            $nomina_consideracion = NominaDirecta::findOrFail($nomina[$cont]);
            $nomina_consideracion->estado_consideracion = $estado_consideracion[$cont];
            $nomina_consideracion->motivo_rechazo_consideracion = $motivo_rechazo[$cont];
            $nomina_consideracion->update();
            $cont = $cont+1;
        }

        return redirect()->back();
    }
}
