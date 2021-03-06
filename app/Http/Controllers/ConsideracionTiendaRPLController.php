<?php

namespace App\Http\Controllers;

use App\ArchivoTiendaRPL;
use App\Consideracion;
use App\NominaTiendaRPL;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConsideracionTiendaRPLController extends Controller
{
    public function index(Request $request)
    {
        $estado_consideracion = $request->get('estado');
        $id_asesor = $request->get('asesor_id');
        $consideracion_id = $request->get('consideracion_id');
        $mes_nomina=\Config::get('global.mes_anterior_tienda');
        $porcentajes = ['50%', '75%','75% nuevo','prorrateado', '25%', 'sin objetivos'];
        $consideraciones = Consideracion::all();

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas = $zonas = \Auth::user()->zonasTienda->pluck('id')->toArray();
            $asesores = NominaTiendaRPL::whereNotNull('estado_consideracion')
                ->tiendas($zonas)->mes($mes_nomina)->asesor($id_asesor)->consideracion($consideracion_id)
                ->estadoConsideracion($estado_consideracion)->orderBy('id')
                ->get();
        }
        else
        {
            $asesores = NominaTiendaRPL::whereNotNull('estado_consideracion')->mes($mes_nomina)
                ->asesor($id_asesor)->consideracion($consideracion_id)
                ->estadoConsideracion($estado_consideracion)->orderBy('id')
                ->get();
        }



        return view('TiendaRPL.consideraciones.index', ['mes_nomina'=>$mes_nomina, 'porcentajes'=>$porcentajes,
            'asesores'=>$asesores, 'consideraciones'=>$consideraciones]);

    }


    public function aprobarConsideraciones(Request $request)
    {
        $mes_nomina = \Config::get('global.mes_anterior_tienda');
        $consideraciones = Consideracion::all();
        $id_consideracion = $request->get('id_consideracion');
        $asesor_id = $request->get('asesor_id');

        $asesores = NominaTiendaRPL::mes($mes_nomina)
            ->where('estado_consideracion', '=', 'pendiente')->asesor($asesor_id)
            ->consideracion($id_consideracion)
            ->orderBy('id')
            ->get();


        return view('TiendaRPL.consideraciones.aprobacion', ['mes_nomina'=>$mes_nomina, 'consideraciones'=>$consideraciones,
            'asesores'=>$asesores]);
    }

    public function storeConsideraciones (Request $request)
    {
        $nomina = $request->get('id_nomina');
        $estado_consideracion = $request->get('aprobacion');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $comentarios_consideracion = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');
        $cont = 0;

        while ($cont < count($nomina))
        {
            $nomina_consideracion = NominaTiendaRPL::findOrFail($nomina[$cont]);
            $nomina_consideracion->estado_consideracion = $estado_consideracion[$cont];
            if ($nomina_consideracion->estado_consideracion == 'aprobado')
            {
                $nomina_consideracion->comentarios_consideracion = $comentarios_consideracion[$cont];
                $nomina_consideracion->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
                $nomina_consideracion->porcentaje_objetivo = $objetivo[$cont];
            }
            elseif ($nomina_consideracion->estado_consideracion == 'rechazado')
            {
                $nomina_consideracion->comentarios_consideracion = $motivo_rechazo[$cont];
            }
            $nomina_consideracion->update();
            $cont = $cont+1;
        }

        return redirect()->back();
    }

    public function edit ($id)
    {
        $consideraciones = Consideracion::all();
        $asesor = NominaTiendaRPL::findOrFail($id);
        return view('TiendaRPL.consideraciones.regularizar_consideracion', ['asesor'=>$asesor, 'consideraciones'=>$consideraciones]);
    }

    public function update(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            if ($asesor->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $this->validate($request, [
                    'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
                ]);
                $archivo = ArchivoTiendaRPL::where('id_nomina_directa', $asesor->id)
                    ->where('tipo', 'consideracion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new ArchivoTiendaRPL();
                $archivo->nomina_tienda_id = $asesor->id;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $asesor->estado_consideracion = 'pendiente';
        $asesor->regularizacion_consideracion = $request->get('regularizacion_consideracion');
        $asesor->id_consideracion = $request->get('id_consideracion');
        $asesor->update();
        return redirect('consideraciones_tienda_rpl');
    }

    public function updateConsideracion(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($asesor->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $archivo = ArchivoTiendaRPL::where('nomina_tienda_id', $asesor->id)
                    ->where('tipo', 'consideracion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new ArchivoTiendaRPL();
                $archivo->nomina_tienda_id = $asesor->id;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $asesor->fill($request->all());
        $asesor->update();
        return redirect()->back();
    }

    public function updateEstado(Request $request, $id)
    {

        $asesor = NominaTiendaRPL::findOrFail($id);
        $estado_consideracion = $request->get('estado_consideracion');
        $comentarios = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');


        if ($estado_consideracion == 'aprobado')
        {
            $asesor->estado_consideracion = 'aprobado';
            $asesor->comentarios_consideracion = $comentarios;
            $asesor->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
            $asesor->porcentaje_objetivo = $objetivo[0];

        }
        elseif ($estado_consideracion == 'rechazado')
        {
            $asesor->estado_consideracion = 'rechazado';
            $asesor->comentarios_consideracion = $comentarios;
            $asesor->porcentaje_objetivo = '100%';
        }
        else
        {
            $asesor->estado_consideracion = 'pendiente';
            $asesor->comentarios_consideracion = NULL;
            $asesor->porcentaje_objetivo = '100%';
        }

        $asesor->update();

        return redirect()->back();

    }
}
