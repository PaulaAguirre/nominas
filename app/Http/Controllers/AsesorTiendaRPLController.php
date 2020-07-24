<?php

namespace App\Http\Controllers;

use App\ArchivoTiendaRPL;
use App\AsesorTienda;
use App\AsesorTiendaRPL;
use App\NominaTiendaRPL;
use App\SupervisorGuiaTigo;
use App\SupervisorRetencion;
use App\Teamleader;
use App\Tienda;
use App\TLretencion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AsesorTiendaRPLController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AsesorTiendaRPL  $asesorTiendaRPL
     * @return \Illuminate\Http\Response
     */
    public function show(AsesorTiendaRPL $asesorTiendaRPL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Factory|Application|View
     */
    public function edit($id)
    {
        $asesor = AsesorTiendaRPL::findOrFail($id);
        $tiendas = Tienda::all();
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PLUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS', 'ASESOR CORRESPONSALIA', 'ASESOR DE VENTAS SMART 5'];
        $supervisores = SupervisorGuiaTigo::all();
        $agrupaciones = ['ASESOR', 'RETENCION CALL', 'RETENCION TIENDA'];
        $tls_retencion_call = TLretencion::where('canal', '=', 'CALL CENTER')->get();
        $tls_retencion_tiendas = Teamleader::where('rac_retencion', '=', 'si')->get();

        return view('TiendaRPL.asesores.edit',
            ['tiendas'=>$tiendas, 'cargos'=>$cargos, 'asesor'=>$asesor,
                'supervisores'=>$supervisores, 'agrupaciones'=>$agrupaciones, 'tls_retencion_call'=>$tls_retencion_call,
                'tls_retencion_tiendas'=>$tls_retencion_tiendas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request,  $id)
    {
        $asesor = AsesorTiendaRPL::findOrFail($id);
        $racRetencion_tienda = explode('-', $request->get('tls_retencion_tiendas'));
        $rac_call = $request->get('tl_retencion_call');
        $cargo_go = $request->get('cargo_go');
        $user_red = $request->get('user_red');
        $supervisor_id = $request->get('supervisor_id');
        $agrupacion = $request->get('agrupacion');

        if ($agrupacion == 'ASESOR')
        {
            $tienda_tl = explode('-',$request->get('tienda_teamleader_id'));
            $tienda_id = $tienda_tl[0];
            $teamleader_id = $tienda_tl[1];
            $asesor->id_teamleader = $teamleader_id;
            $asesor->id_tienda = $tienda_id;
            $asesor->activo = 'ACTIVO';
            $asesor->user_red = $user_red;
            $asesor->supervisor_guiatigo_id = $supervisor_id;
            $asesor->agrupacion = 'ASESOR';
            $asesor->especialista = 'no';
            $asesor->supervisor_retencion_id = Null;
            $asesor->tl_retencion_call_id = Null;
        }
        elseif ($agrupacion == 'RETENCION CALL')
        {
            $supervisor_retencion = SupervisorRetencion::where('clasificacion', '=', 'CALL CENTER')->get()->first();
            $asesor->especialista = 'si';
            $asesor->agrupacion = 'RETENCION CALL';
            $asesor->supervisor_retencion_id = $supervisor_retencion->id;
            $asesor->tl_retencion_call_id = $rac_call;

        }
        elseif ($agrupacion == 'RETENCION TIENDA') {
            $supervisor_retencion = SupervisorRetencion::where('clasificacion', '=', 'TIENDAS')->get()->first();
            $asesor->id_teamleader = $racRetencion_tienda[0];
            $asesor->id_tienda = $racRetencion_tienda[1];
            $asesor->especialista = 'si';
            $asesor->agrupacion = 'RETENCION TIENDAS';
            $asesor->supervisor_retencion_id = $supervisor_retencion->id;
            $asesor->supervisor_guiatigo_id = NULL;
        }

        $asesor->ch = $request->get('ch');
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        $asesor->activo = 'ACTIVO';
        $asesor->staff = $request->get('staff');
        $asesor->user_red = $user_red;
        $asesor->cargo_go = $cargo_go;
        $asesor->supervisor_guiatigo_id = $supervisor_id;
        $asesor->documento = $request->get('documento');

        $asesor->update();

        return redirect($request->get('url'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);

        $asesor->motivo_inactivacion = $request->get('motivo_inactivacion');
        $asesor->detalles_inactivacion = $request->get('detalles_inactivacion');
        $asesor->estado_inactivacion = 'pendiente';

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoTiendaRPL();
            $archivo->nomina_tienda_id = $asesor->id;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'inactivacion';
            $archivo->save();
        }
        $asesor->update();
        return redirect()->back();
    }

    public function agregarConsideracion(Request $request, $id)
    {
        $asesor = NominaTiendaRPL::findOrFail($id);
        $asesor->id_consideracion = $request->get('id_consideracion');
        $asesor->detalles_consideracion = $request->get('detalles_consideracion');
        $asesor->estado_consideracion = 'pendiente';

        if ($request->hasFile('archivo')) {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoTiendaRPL();
            $archivo->nomina_tienda_id = $asesor->id;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/', $ruta)[1];
            $archivo->tipo = 'consideracion';
            $archivo->save();
        }

        $asesor->update();
        return redirect()->back();
    }
}

