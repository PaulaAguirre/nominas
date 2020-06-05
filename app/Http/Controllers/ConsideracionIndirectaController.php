<?php

namespace App\Http\Controllers;

use App\ArchivoIndirecta;
use App\Consideracion;
use App\NominaIndirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class   ConsideracionIndirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $estado_consideracion = $request->get('estado');
        $id_impulsador = $request->get('impulsador_id');
        $consideracion_id = $request->get('consideracion_id');
        $mes_nomina=\Config::get('global.mes_indirecta');
        $porcentajes = ['50%', '75%','75% nuevo','prorrateado', '25%', 'sin objetivos'];
        $consideraciones = Consideracion::all();

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas_zonal = $zonas = \Auth::user()->zonasIndirecta->pluck('id')->toArray();
            $impulsadores = NominaIndirecta::whereNotNull('estado_consideracion')
                ->zonas($zonas_zonal)->mes($mes_nomina)->impulsadorInd($id_impulsador)->consideracion($consideracion_id)
                ->estadoConsideracion($estado_consideracion)->orderBy('id')
                ->get();
        }
        else
        {
            $impulsadores = NominaIndirecta::whereNotNull('estado_consideracion')->mes($mes_nomina)
                ->impulsadorInd($id_impulsador)->consideracion($consideracion_id)
                ->estadoConsideracion($estado_consideracion)->orderBy('id')
                ->get();
        }

        return view('indirecta.consideraciones.index', ['mes_nomina'=>$mes_nomina, 'porcentajes'=>$porcentajes,
            'impulsadores'=>$impulsadores, 'consideraciones'=>$consideraciones]);

    }

    public function agregarConsideracion(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);
        $impulsador->consideracion_id = $request->get('id_consideracion');
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

    public function aprobarConsideraciones(Request $request)
    {
        $mes_nomina = \Config::get('global.mes_indirecta');
        $consideraciones = Consideracion::all();
        $id_consideracion = $request->get('id_consideracion');
        $impulsador_id = $request->get('impulsador_id');

        $impulsadores = NominaIndirecta::mes($mes_nomina)
            ->where('estado_consideracion', '=', 'pendiente')->impulsadorInd($impulsador_id)
            ->consideracion($id_consideracion)
            ->orderBy('id')
            ->get();


        return view('indirecta.consideraciones.aprobacion', ['mes_nomina'=>$mes_nomina, 'consideraciones'=>$consideraciones,
            'impulsadores'=>$impulsadores]);
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
            $nomina_consideracion = NominaIndirecta::findOrFail($nomina[$cont]);
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

    public function updateEstado(Request $request, $id)
    {

        $impulsador = NominaIndirecta::findOrFail($id);
        $estado_consideracion = $request->get('estado_consideracion');
        $comentarios = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');


        if ($estado_consideracion == 'aprobado')
        {
            $impulsador->estado_consideracion = 'aprobado';
            $impulsador->comentarios_consideracion = $comentarios;
            $impulsador->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
            $impulsador->porcentaje_objetivo = $objetivo[0];

        }
        elseif ($estado_consideracion == 'rechazado')
        {
            $impulsador->estado_consideracion = 'rechazado';
            $impulsador->comentarios_consideracion = $comentarios;
            $impulsador->porcentaje_objetivo = '100%';
        }
        else
        {
            $impulsador->estado_consideracion = 'pendiente';
            $impulsador->comentarios_consideracion = NULL;
            $impulsador->porcentaje_objetivo = '100%';
        }

        $impulsador->update();

        return redirect()->back();

    }

    public function edit ($id)
    {
        $consideraciones = Consideracion::all();
        $impulsador = NominaIndirecta::findOrFail($id);
        return view('indirecta.consideraciones.regularizar_consideracion', ['impulsador'=>$impulsador, 'consideraciones'=>$consideraciones]);
    }

    public function update(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);

        if ($request->hasFile('archivo'))
        {

            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($impulsador->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $this->validate($request, [
                    'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
                ]);
                $archivo = ArchivoIndirecta::where('nomina_indirecta_id', $impulsador->id)
                    ->where('tipo', 'consideracion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new ArchivoIndirecta();
                $archivo->nomina_indirecta_id = $impulsador->id;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $impulsador->estado_consideracion = 'pendiente';
        $impulsador->regularizacion_consideracion = $request->get('regularizacion_consideracion');
        $impulsador->consideracion_id = $request->get('id_consideracion');
        $impulsador->update();
        return redirect('consideraciones_indirecta');
    }

    public function updateConsideracion(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($impulsador->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $archivo = ArchivoIndirecta::where('nomina_tienda_id', $impulsador->id)
                    ->where('tipo', 'consideracion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new ArchivoIndirecta();
                $archivo->nomina_indirecta_id = $impulsador->id;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $impulsador->fill($request->all());
        $impulsador->update();
        return redirect()->back();
    }


}
