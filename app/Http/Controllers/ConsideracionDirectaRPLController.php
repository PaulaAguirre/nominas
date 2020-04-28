<?php

namespace App\Http\Controllers;

use App\ArchivoDirectaRPL;
use App\Consideracion;
use App\PorcentajeDirecta;
use App\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\NominaDirectaRPL;
use App\PersonaDirectaRPL;
class ConsideracionDirectaRPLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $porcentajes = PorcentajeDirecta::where('descripcion', 'consideracion')
            ->orderBy('nombre')->get();

        $mes=\Config::get('global.mes_anterior');
        $id_consideracion = $request->get('id_consideracion');
        $id_persona = $request->get('id_persona');
        $zonas = auth()->user()->zonas->pluck('id');
        $estado_consideracion = $request->get('estado');
        $consideraciones = Consideracion::all();
        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas = \Auth::user()->zonas->pluck('id')->toArray();
            $personas_consideracion = NominaDirectaRPL::where('estado_consideracion', '<>', NULL)
                ->zonasZonales($zonas)
                ->consideracion($id_consideracion)->representante($id_persona, $mes)->estadoConsideracion($estado_consideracion)
                ->get();
        }
        else
        {
            $personas_consideracion = NominaDirectaRPL::where('estado_consideracion', '<>', NULL)
                ->consideracion($id_consideracion)->representante($id_persona, $mes)->estadoConsideracion($estado_consideracion)
                ->get();
        }

        return view('directaRPL.consideraciones.index', ['personas_consideracion' => $personas_consideracion,
            'zonas'=>$zonas, 'consideraciones'=>$consideraciones, 'porcentajes'=>$porcentajes, 'mes'=> $mes]);
    }

    public function agregarConsideracion (Request $request, $id)
    {
        $nomina = NominaDirectaRPL::findOrFail($id);
        $nomina->id_consideracion = $request->get('id_consideracion');
        $nomina->detalles_consideracion = $request->get('detalles_consideracion');
        $nomina->estado_consideracion = 'pendiente';

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoDirectaRPL();
            $archivo->nomina_directa_id = $nomina->id_nomina;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'consideracion';
            $archivo->save();
        }

        $nomina->update();
        return redirect()->back();
    }
    /**Aprobar las consideraciones*/
    public function aprobarConsideraciones (Request $request)
    {
        $zonas = Zona::all();
        $consideraciones = Consideracion::all();
        $jefes = PersonaDirectaRPL::where('cargo', '=', 'representante_jefe')->get();
        $id_consideracion = $request->get('id_consideracion');
        $id_persona = $request->get('id_persona');
        $mes = \Config::get('global.mes_anterior');

        $porcentajes = PorcentajeDirecta::where('descripcion', 'consideracion')
            ->orderBy('nombre')->get();

        $personas_directa = NominaDirectaRPL::where('estado_consideracion', '=', 'pendiente')
            ->consideracion($id_consideracion)->representante($id_persona, $mes)
            ->get();

        return view('directaRPL.consideraciones.aprobacion', ['personas_directa' => $personas_directa, 'mes'=>$mes,
            'zonas'=>$zonas, 'consideraciones'=>$consideraciones, 'jefes'=>$jefes, 'porcentajes'=>$porcentajes]);

    }
    /**Guardar las consideraciones aprobadas*/
    public function storeConsideraciones (Request $request)
    {
        $nomina = $request->get('id_nomina');
        $estado_consideracion = $request->get('aprobacion');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $comentario_consideracion = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');

        $cont = 0;
        $cantidad_registros = count($estado_consideracion);

        //dd($cantidad_registros);

        foreach ($nomina as $id)
        {
            if ($cont < $cantidad_registros)
            {
                $porcentaje = explode('-', $objetivo[$cont]);

                $nomina_consideracion = NominaDirectaRPL::findOrFail($id);
                $nomina_consideracion->estado_consideracion = $estado_consideracion[$cont];
                $nomina_consideracion->motivo_rechazo_consideracion = $motivo_rechazo[$cont];
                $nomina_consideracion->comentario_consideracion = $comentario_consideracion[$cont];
                $nomina_consideracion->porcentaje_id = $porcentaje[0];

                if (in_array($nomina_consideracion->id_consideracion, [6,12]) and
                    $nomina_consideracion->estado_consideracion == 'aprobado')
                {
                    $nomina_consideracion->estado_nomina = 'aprobado';
                }
                if ($nomina_consideracion->estado_consideracion == 'aprobado')
                {
                    $nomina_consideracion->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
                    $nomina_consideracion->porcentaje_objetivo = $porcentaje[1];
                }


                $nomina_consideracion->update();
            }
            $cont = $cont+1;
        }

        return redirect()->back();
    }


    /**
     * Editar una consideracion ya creada, antes de que se apruebe o se rechace
     * */
    public function updateConsideracion(Request $request, $id)
    {
        $persona = NominaDirectaRPL::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);

            if ($persona->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $archivo = ArchivoDirectaRPL::where('nomina_directa_id', $persona->id_nomina)
                    ->where('tipo', 'consideracion')->get()->first();
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
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $persona->id_consideracion = $request->get('id_consideracion');
        $persona->detalles_consideracion = $request->get('detalles_consideracion');
        $persona->update();
        return redirect()->back();
    }

    /**Editar el estado de una consideracion ya aprobada o rechazada*/
    public function updateEstado(Request $request, $id)
    {

        $persona = NominaDirectaRPL::findOrFail($id);
        $estado_consideracion = $request->get('estado_consideracion');
        $comentarios = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');
        $porcentaje = explode('-', $objetivo);


        if ($estado_consideracion == 'aprobado')
        {
            $persona->estado_consideracion = 'aprobado';
            $persona->comentario_consideracion = $comentarios;
            $persona->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
            $persona->motivo_rechazo_consideracion = NULL;
            $persona->porcentaje_id = $porcentaje[0];
            $persona->porcentaje_objetivo = $porcentaje[1];

        }
        elseif ($estado_consideracion == 'rechazado')
        {
            $persona->estado_consideracion = 'rechazado';
            $persona->motivo_rechazo_consideracion = $comentarios;
            $persona->comentario_consideracion = NULL;
            $persona->porcentaje_objetivo = NULL;
            $persona->porcentaje_id = NULL;
        }
        else
        {
            $persona->estado_consideracion = 'pendiente';
            $persona->motivo_rechazo_consideracion = NULL;
            $persona->comentario_consideracion = NULL;
            $persona->porcentaje_objetivo = NULL;
            $persona->porcentaje_id = NULL;
        }

        $persona->update();

        return redirect()->back();
    }

}
