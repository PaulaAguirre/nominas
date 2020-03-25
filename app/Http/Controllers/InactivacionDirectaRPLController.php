<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use App\NominaDirectaRPL;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InactivacionDirectaRPLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $mes = 202003;
        $id_persona = $request->get('id_persona');
        $estado_inactivacion = $request->get('estado');

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas = \Auth::user()->zonas->pluck('id')->toArray();
            $inactivaciones = NominaDirectaRPL::zonaZonales($zonas)->
            where('estado_inactivacion', '<>', 'NULL')
                ->where('mes', '=', $mes )
                ->representante($id_persona, $mes)->estadoInactivacion($estado_inactivacion)
                ->get();
        }
        else
        {
            $inactivaciones = NominaDirectaRPL::where('estado_inactivacion', '<>', 'NULL')
                ->where('mes', '=', $mes )
                ->representante($id_persona, $mes)->estadoInactivacion($estado_inactivacion)
                ->get();
        }

        return view('directaRPL.inactivaciones.index', ['inactivaciones'=>$inactivaciones, 'mes'=>$mes]);

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

    public function aprobarInactivaciones(Request $request)
    {
        $mes = 202003;
        $personas = NominaDirectaRPL::where('estado_inactivacion', '=', 'pendiente')
            ->where('mes', '=', $mes)->get();
        return view('directaRPL.inactivaciones.aprobar_inactivaciones', ['personas' => $personas, 'mes' => $mes]);
    }
    public function aprobarInactivacionesStore(Request $request)
    {
        $estado_inactivacion = $request->get('aprobacion');
        $nomina = $request->get('id_nomina');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $comentario_inactivacion = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');
        $cont = 0;

        while ($cont < count($nomina))
        {
            $nomina_directa = NominaDirectaRPL::findOrFail($nomina[$cont]);
            $nomina_directa->estado_inactivacion = $estado_inactivacion[$cont];
            $nomina_directa->motivo_rechazo_inactivacion = $motivo_rechazo[$cont];
            $nomina_directa->comentario_inactivacion = $comentario_inactivacion[$cont];
            $nomina_directa->porcentaje_objetivo = $objetivo[$cont];


            if ($nomina_directa->estado_inactivacion == 'aprobado')
            {
                $persona_directa = PersonaDirectaRPL::findOrFail($nomina_directa->id_persona_directa);
                $persona_directa->activo = 'inactivo';
                $nomina_directa->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
                $persona_directa->update();
            }

            $nomina_directa->update();
            $cont = $cont+1;
        }

        return redirect('aprobar_inactivaciones');
    }

}
