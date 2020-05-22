<?php

namespace App\Http\Controllers;

use App\ArchivoTiendaRPL;
use App\AsesorTiendaRPL;
use App\NominaTiendaRPL;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InactivacionTiendaRPLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id_asesor = $request->get('asesor_id');
        $estado_inactivacion = $request->get('estado');
        $porcentajes = ['100%', '75% nuevo', '75%', '50%', 'prorrateado', '25%', 'sin objetivos'];
        $mes = \Config::get('global.mes_anterior_tienda');

        if (\Auth::user()->hasRoles(['zonal'])) {
            $zonas = \Auth::user()->zonasTienda->pluck('id')->toArray();
            $asesores_inactivos = NominaTiendaRPL::whereNotNull('estado_inactivacion')->tiendas($zonas)
                ->mes($mes)->asesor($id_asesor)->estadoInactivacion($estado_inactivacion)
                ->orderBy('id')
                ->get();
        } else {
            $asesores_inactivos = NominaTiendaRPL::whereNotNull('estado_inactivacion')
                ->mes($mes)->asesor($id_asesor)->estadoInactivacion($estado_inactivacion)->orderBy('id')->get();
        }

        return view('TiendaRPL.inactivaciones.index', ['asesores_inactivos' => $asesores_inactivos,
            'porcentajes' => $porcentajes, 'mes' => $mes]);
    }
    public function aprobarInactivaciones(Request $request)
    {
        $mes = \Config::get('global.mes_anterior_tienda');
        $asesores = NominaTiendaRPL::where('estado_inactivacion', '=', 'pendiente')
            ->where('mes', '=', $mes)->orderBy('id')->get();
        return view('TiendaRPL.inactivaciones.aprobar_inactivaciones', ['asesores' => $asesores, 'mes' => $mes]);
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
            $nomina_tienda = NominaTiendaRPL::findOrFail($nomina[$cont]);
            $nomina_tienda->estado_inactivacion = $estado_inactivacion[$cont];
            if ($motivo_rechazo[$cont])
            {
                $nomina_tienda->comentarios_inactivacion = $motivo_rechazo[$cont];
            }
            else
            {
                $nomina_tienda->comentarios_inactivacion = $comentario_inactivacion[$cont];
            }

            $nomina_tienda->porcentaje_objetivo = $objetivo[$cont];

            if ($nomina_tienda->estado_inactivacion == 'aprobado')
            {
                $asesor_tienda = AsesorTiendaRPL::findOrFail($nomina_tienda->id_asesor);
                $asesor_tienda->activo = 'inactivo';
                $nomina_tienda->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
                $asesor_tienda->update();
            }


            $nomina_tienda->update();
            $cont = $cont+1;
        }

        return redirect()->back();
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);
        $motivos = ['renuncia', 'desvinculacion', 'cambio de canal'];

        return view('TiendaRPL.inactivaciones.regularizar_inactivacion', ['asesor'=>$asesor, 'motivos'=>$motivos]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);
        $asesor->estado_inactivacion = 'pendiente';
        $asesor->regularizacion_inactivacion = $request->get('regularizacion_inactivacion');
        $asesor->update();

        return redirect('inactivaciones_tienda_rpl');
    }

    public function updateInactivacion(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($asesor->archivos->where('tipo', '=', 'inactivacion')->first())
            {
                $archivo = ArchivoTiendaRPL::where('nomina_tienda_id', $asesor->id)
                    ->where('tipo', 'inactivacion')->get()->first();
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
                $archivo->tipo = 'inactivacion';
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

        $estado_inactivacion = $request->get('estado_inactivacion');
        $comentarios = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');

        if ($estado_inactivacion == 'aprobado')
        {
            $asesor->estado_inactivacion = 'aprobado';
            $asesor->comentarios_inactivacion = $comentarios;
            $asesor->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
            $asesor->porcentaje_objetivo = $objetivo[0];
        }
        elseif ($estado_inactivacion == 'rechazado')
        {
            $asesor->estado_inactivacion = 'rechazado';
            $asesor->comentarios_inactivacion = $comentarios;
            $asesor->porcentaje_objetivo = '100%';
        }
        else
        {
            $asesor->estado_inactivacion = 'pendiente';
            $asesor->comentarios_inactivacion = NULL;
        }

        $asesor->update();
        return redirect()->back();

    }

}
