<?php

namespace App\Http\Controllers;

use App\ArchivoTienda;
use App\AsesorTienda;
use App\NominaTienda;
use App\SupervisorGuiaTigo;
use App\SupervisorRetencion;
use App\Teamleader;
use App\Tienda;
use App\TLretencion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\ZonaTienda;
use Psr\Log\NullLogger;

class AsesorTiendaController extends Controller
{
    /**
     * AsesorTiendaController constructor.
     */
    public function __construct()
    {
        $this->middleware('canales:tiendas');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $asesor_id = $request->get('asesor_id');
        $tienda_id = $request->get('tienda_id');
        $zona_id = $request->get('zona_id');
        $estado = $request->get('estado');
        $tiendas = Tienda::all();
        $zonas_tienda = ZonaTienda::all();

        $asesores = AsesorTienda::asesor($asesor_id)->tienda($tienda_id)->zona($zona_id)->estado($estado)->orderBy('id')
            ->get();

        return view('tiendas.asesores.index', ['asesores'=>$asesores, 'zonas_tienda'=>$zonas_tienda,
            'tiendas'=>$tiendas, 'zonas'=>$zonas_tienda]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        $tiendas = Tienda::all();
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PLUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS', 'ASESOR CORRESPONSALIA', 'ASESOR DE VENTAS SMART 5'];
        $supervisores = SupervisorGuiaTigo::all();
        $agrupaciones = ['ASESOR', 'RETENCION CALL', 'RETENCION TIENDA'];
        $tls_retencion_call = TLretencion::where('canal', '=', 'CALL CENTER')->get();
        $tls_retencion_tiendas = Teamleader::where('rac_retencion', '=', 'si')->get();
        return view('tiendas.asesores.create2', ['tiendas'=>$tiendas, 'cargos'=>$cargos,
            'supervisores'=>$supervisores, 'agrupaciones'=>$agrupaciones, 'tls_retencion_call'=>$tls_retencion_call,
            'tls_retencion_tiendas'=>$tls_retencion_tiendas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ch' => 'required|unique:asesores_tienda'
        ]);

        $mes_nomina = \Config::get('global.mes_tienda');
        $racRetencion_tienda = explode('-', $request->get('tls_retencion_tiendas'));
        $rac_call = $request->get('tl_retencion_call');

        $consideracion_id = $request->get('consideracion_id');
        $detalles_consideracion = $request->get('detalles_consideracion');
        $cargo_go = $request->get('cargo_go');
        $user_red = $request->get('user_red');
        $supervisor_id = $request->get('supervisor_id');
        $agrupacion = $request->get('agrupacion');


        $asesor = new AsesorTienda();
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
        $asesor->save();

        $nomina = new NominaTienda();
        $nomina->id_asesor = $asesor->id;
        $nomina->mes = $mes_nomina;
        $nomina->asesor_mes = $asesor->id.$mes_nomina;
        $nomina->id_consideracion = $consideracion_id;
        $nomina->estado_consideracion = 'pendiente';
        $nomina->detalles_consideracion = $detalles_consideracion;
        $nomina->save();

        return redirect('asesores_tienda/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  AsesorTienda $asesor
     * @return Response
     */
    public function show(AsesorTienda $asesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($id)
    {
        $asesor = AsesorTienda::findOrFail($id);
        $tiendas = Tienda::all();
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PLUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS', 'ASESOR CORRESPONSALIA', 'ASESOR DE VENTAS SMART 5'];
        $supervisores = SupervisorGuiaTigo::all();
        $agrupaciones = ['ASESOR', 'RETENCION CALL', 'RETENCION TIENDA'];
        $tls_retencion_call = TLretencion::where('canal', '=', 'CALL CENTER')->get();
        $tls_retencion_tiendas = Teamleader::where('rac_retencion', '=', 'si')->get();
        return view('tiendas.asesores.edit', ['tiendas'=>$tiendas, 'cargos'=>$cargos, 'asesor'=>$asesor,
            'supervisores'=>$supervisores, 'agrupaciones'=>$agrupaciones, 'tls_retencion_call'=>$tls_retencion_call,
            'tls_retencion_tiendas'=>$tls_retencion_tiendas]);
    }


    public function update(Request $request, $id)
    {
        $asesor = AsesorTienda::findOrFail($id);
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
            $asesor->supervisor_retencion_id = Null;

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

        return redirect('nomina_tienda');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AsesorTienda $asesor
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        $asesor = NominaTienda::findOrFail($id);
        $asesor->motivo_inactivacion = $request->get('motivo_inactivacion');
        $asesor->detalles_inactivacion = $request->get('detalles_inactivacion');
        $asesor->estado_inactivacion = 'pendiente';

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoTienda();
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
        $asesor = NominaTienda::findOrFail($id);
        $asesor->id_consideracion = $request->get('id_consideracion');
        $asesor->detalles_consideracion = $request->get('detalles_consideracion');
        $asesor->estado_consideracion = 'pendiente';

        if($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoTienda();
            $archivo->nomina_tienda_id = $asesor->id;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'consideracion';
            $archivo->save();
        }

        $asesor->update();
        return redirect()->back();
    }
}
