<?php

namespace App\Http\Controllers;

use App\ArchivoTienda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\NominaTienda;
use App\Consideracion;
class ConsideracionTiendaController extends Controller
{
    public function index(Request $request)
    {
        $estado_consideracion = $request->get('estado');
        $id_asesor = $request->get('asesor_id');
        $consideracion_id = $request->get('consideracion_id');
        $mes_nomina=201911;
        $porcentajes = ['50%', '75%','75% nuevo','prorrateado', '25%', 'sin objetivos'];

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas = $zonas = \Auth::user()->zonasTienda->pluck('id')->toArray();
            $asesores = NominaTienda::whereNotNull('estado_consideracion')
                ->tiendas($zonas)->mes($mes_nomina)
                ->get();
        }
        else
        {
            $asesores = NominaTienda::whereNotNull('estado_consideracion')->mes($mes_nomina)
                ->get();
        }



        return view('tiendas.consideraciones.index', ['mes_nomina'=>$mes_nomina, 'porcentajes'=>$porcentajes,
            'asesores'=>$asesores]);

    }

    public function agregarConsideracion(Request $request, $id)
    {
        $asesor = NominaTienda::findOrFail($id);
        dd($asesor);
        $asesor->id_consideracion = $request->get('id_consideracion');
        $asesor->detalles_consideracion = $request->get('detalles_consideracion');
        $asesor->estado_consideracion = 'pendiente';


        $asesor->update();
        return redirect()->back();
    }

    public function aprobarConsideraciones(Request $request)
    {
        $mes_nomina = 201911;
        $consideraciones = Consideracion::all();
        $id_consideracion = $request->get('id_consideracion');
        $asesor_id = $request->get('asesor_id');

        $asesores = NominaTienda::mes($mes_nomina)
            ->where('estado_consideracion', '=', 'pendiente')->asesor($asesor_id)
            ->consideracion($id_consideracion)->get();


        return view('tiendas.consideraciones.aprobacion', ['mes_nomina'=>$mes_nomina, 'consideraciones'=>$consideraciones,
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
            $nomina_consideracion = NominaTienda::findOrFail($nomina[$cont]);
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
}
