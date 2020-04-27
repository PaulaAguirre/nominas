<?php

namespace App\Http\Controllers;

use App\ArchivoDirectaRPL;
use App\NominaDirecta;
use App\NominaDirectaRPL;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use App\PorcentajeDirecta;
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
        $mes = \Config::get('global.mes_anterior');
        $porcentajes = PorcentajeDirecta::where('descripcion', 'inactivacion')
            ->orderBy('nombre')->get();
        $id_persona = $request->get('id_persona');
        $estado_inactivacion = $request->get('estado');

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas = \Auth::user()->zonas->pluck('id')->toArray();
            $inactivaciones = NominaDirectaRPL::zonasZonales($zonas)->
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

        return view('directaRPL.inactivaciones.index', ['inactivaciones'=>$inactivaciones, 'mes'=>$mes, 'porcentajes'=>$porcentajes]);

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
        $mes = \Config::get('global.mes_anterior');
        $personas = NominaDirectaRPL::where('estado_inactivacion', '=', 'pendiente')
            ->where('mes', '=', $mes)->get();

        $porcentajes = PorcentajeDirecta::where('descripcion', 'inactivacion')
            ->orderBy('nombre')->get();
        return view('directaRPL.inactivaciones.aprobar_inactivaciones', ['personas' => $personas,
            'mes' => $mes, 'porcentajes'=>$porcentajes]);
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
            $porcentaje = explode('-', $objetivo[$cont]);

            $nomina_directa = NominaDirectaRPL::findOrFail($nomina[$cont]);
            $nomina_directa->estado_inactivacion = $estado_inactivacion[$cont];
            $nomina_directa->motivo_rechazo_inactivacion = $motivo_rechazo[$cont];
            $nomina_directa->comentario_inactivacion = $comentario_inactivacion[$cont];
            $nomina_directa->porcentaje_objetivo = $objetivo[$cont];


            if ($nomina_directa->estado_inactivacion == 'aprobado')
            {
                $persona_directa = PersonaDirectaRPL::findOrFail($nomina_directa->id_persona_directa);
                $persona_directa->activo = 'inactivo';
                $nomina_directa->porcentaje_id = $porcentaje[0];
                $nomina_directa->porcentaje_objetivo = $porcentaje[1];
                $nomina_directa->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
                $persona_directa->update();
            }

            $nomina_directa->update();



            $cont = $cont+1;
        }
        return redirect()->back();
    }

    /**Modificar una inactivacion si es que aún no fue aprobada*/
    public function updateInactivacion(Request $request, $id)
    {
        $persona = NominaDirectaRPL::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);

            if ($persona->archivos->where('tipo', '=', 'inactivacion')->first())
            {
                $archivo = ArchivoDirectaRPL::where('nomina_directa_id', $persona->id_nomina)
                    ->where('tipo', 'inactivacion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new ArchivoDirectaRPL();
                $archivo->nomina_directa_id = $persona->id_nomina;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'inactivacion';
                $archivo->save();
            }

        }
        $persona->detalles_inactivacion = $request->get('detalles_inactivacion');
        $persona->motivo_inactivacion = $request->get('motivo_inactivacion');
        $persona->update();
        return redirect()->back();
    }

    public function updateEstado(Request $request, $id)
    {
        $persona = NominaDirectaRPL::findOrFail($id);

        $estado_inactivacion = $request->get('estado_inactivacion');
        $comentarios = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');
        $porcentaje = explode('-', $objetivo);

        if ($estado_inactivacion == 'aprobado')
        {

            $persona->estado_inactivacion = 'aprobado';
            $persona->comentario_inactivacion = $comentarios;
            $persona->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
            $persona->motivo_rechazo_inactivacion = NULL;
            $persona->porcentaje_id = $porcentaje[0];
            $persona->porcentaje_objetivo = $porcentaje[1];
        }
        elseif ($estado_inactivacion == 'rechazado')
        {
            $persona->estado_inactivacion = 'rechazado';
            $persona->motivo_rechazo_inactivacion = $comentarios;
            $persona->comentario_inactivacion = NULL;
            $persona->porcentaje_objetivo = '100%';
            $persona->porcentaje_id = NULL;
        }

        $persona->update();

        return redirect()->back();

    }

}
