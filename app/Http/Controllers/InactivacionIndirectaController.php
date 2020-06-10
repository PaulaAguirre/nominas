<?php

namespace App\Http\Controllers;

use App\ArchivoIndirecta;
use App\Impulsador;
use App\ZonaIndirecta;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\NominaIndirecta;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;


class InactivacionIndirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        $impulsador_id = $request->get('impulsador_id');
        $estado_inactivacion = $request->get('estado');
        $porcentajes = ['100%', '75% nuevo', '75%', '50%', 'prorrateado', '25%', 'sin objetivos'];
        $mes = \Config::get('global.mes_indirecta');

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonas_zonal = \Auth::user()->zonasIndirecta->pluck('id')->toArray();
            $zonas = ZonaIndirecta::whereIn('id', $zonas_zonal)->get();
            $impulsadores_inactivos = NominaIndirecta::whereNotNull('estado_inactivacion')
                ->zonas($zonas_zonal)
                ->mes($mes)
                ->activo($estado_inactivacion)
                ->impulsadorInd($impulsador_id)
                ->orderBy('id')
                ->get();

        }
        else
        {
            $impulsadores_inactivos =NominaIndirecta::whereNotNull('estado_inactivacion')
                ->mes($mes)->impulsadorInd($impulsador_id)->activo($estado_inactivacion)
                ->orderBy('id')
                ->get();
        }

        return view('indirecta.inactivaciones.index', ['impulsadores_inactivos'=>$impulsadores_inactivos,
            'porcentajes'=>$porcentajes, 'mes'=>$mes]);
    }

    public function aprobarInactivaciones(Request $request)
    {
        $mes = \Config::get('global.mes_indirecta');
        $impulsadores = NominaIndirecta::where('estado_inactivacion', '=', 'pendiente')
            ->where('mes', '=', $mes)->orderBy('id')->get();

        return view('indirecta.inactivaciones.aprobar_inactivaciones', ['impulsadores' => $impulsadores, 'mes' => $mes]);
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
            $nomina_indirecta = NominaIndirecta::findOrFail($nomina[$cont]);
            $nomina_indirecta->estado_inactivacion = $estado_inactivacion[$cont];
            if ($motivo_rechazo[$cont])
            {
                $nomina_indirecta->comentarios_inactivacion = $motivo_rechazo[$cont];
            }
            else
            {
                $nomina_indirecta->comentarios_inactivacion = $comentario_inactivacion[$cont];
            }

            $nomina_indirecta->porcentaje_objetivo = $objetivo[$cont];

            if ($nomina_indirecta->estado_inactivacion == 'aprobado')
            {
                $impulsador_indirecta = Impulsador::findOrFail($nomina_indirecta->impulsador_id);
                $impulsador_indirecta->activo = 'inactivo';
                $nomina_indirecta->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
                $impulsador_indirecta->update();
            }


            $nomina_indirecta->update();
            $cont = $cont+1;
        }


        return redirect('aprobar_inactivaciones_indirecta');
    }

    public function updateEstado(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);

        $estado_inactivacion = $request->get('estado_inactivacion');
        $comentarios = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');

        if ($estado_inactivacion == 'aprobado')
        {
            $impulsador->estado_inactivacion = 'aprobado';
            $impulsador->comentarios_inactivacion = $comentarios;
            $impulsador->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
            $impulsador->porcentaje_objetivo = $objetivo[0];
        }
        elseif ($estado_inactivacion == 'rechazado')
        {
            $impulsador->estado_inactivacion = 'rechazado';
            $impulsador->comentarios_inactivacion = $comentarios;
            $impulsador->porcentaje_objetivo = '100%';
        }
        else
        {
            $impulsador->estado_inactivacion = 'pendiente';
            $impulsador->comentarios_inactivacion = NULL;
        }

        $impulsador->update();
        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|Application|View
     */
    public function edit($id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);
        $motivos = ['renuncia', 'desvinculacion', 'cambio de canal'];

        return view('indirecta.inactivaciones.regularizar_inactivacion', ['impulsador'=>$impulsador, 'motivos'=>$motivos]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);
        $impulsador->estado_inactivacion = 'pendiente';
        $impulsador->comentarios_consideracion = $request->get('comentarios_consideracion');
        $impulsador->update();

        return redirect('inactivaciones_indirecta');
    }

    public function updateInactivacion(Request $request, $id)
    {
        $impulsador = NominaIndirecta::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($impulsador->archivos->where('tipo', '=', 'inactivacion')->first())
            {
                $archivo = ArchivoIndirecta::where('nomina_tienda_id', $impulsador->id)
                    ->where('tipo', 'inactivacion')->get()->first();
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
                $archivo->tipo = 'inactivacion';
                $archivo->save();
            }

        }

        $impulsador->fill($request->all());
        $impulsador->update();
        return redirect()->back();

    }



}
