<?php

namespace App\Http\Controllers;

use App\AsesorTienda;
use App\NominaTienda;
use App\SupervisorGuiaTigo;
use App\SupervisorRetencion;
use App\Teamleader;
use App\Tienda;
use App\TLretencion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AsesorTiendaController2 extends Controller
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
     * @return Factory|Application|View
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
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ch' => 'required|unique:asesores_tienda'
        ]);

        $mes_nomina = \Config::get('global.mes_tienda');
        $racRetencion_tienda = explode('-', $request->get('tls_retencion_tiendas'));
        $agrupacion = $request->get('agrupacion');
        $rac_call = $request->get('tl_retencion_call');

        $consideracion_id = $request->get('consideracion_id');
        $detalles_consideracion = $request->get('detalles_consideracion');
        $cargo_go = $request->get('cargo_go');
        $user_red = $request->get('user_red');
        $supervisor_id = $request->get('supervisor_id');


        $asesor = new AsesorTienda();

        $asesor->ch = $request->get('ch');
        $asesor->documento = $request->get('documento');
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        $asesor->staff = $request->get('staff');
        $asesor->cargo_go = $cargo_go;

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
        }
        elseif ($agrupacion == 'RETENCION CALL')
        {
            $supervisor_retencion = SupervisorRetencion::where('clasificacion', '=', 'CALL CENTER')->get()->first();
            $asesor->especialista = 'si';
            $asesor->agrupacion = 'RETENCION CALL';
            $asesor->supervisor_retencion_id = $supervisor_retencion->id;
            $asesor->tl_retencion_call_id = $rac_call;

        }
        elseif ($agrupacion == 'RETENCION TIENDA')
        {
            $supervisor_retencion = SupervisorRetencion::where('clasificacion', '=', 'TIENDAS')->get()->first();
            $asesor->id_teamleader = $racRetencion_tienda[0];
            $asesor->id_tienda = $racRetencion_tienda[1];
            $asesor->especialista = 'si';
            $asesor->agrupacion = 'RETENCION TIENDAS';
            $asesor->supervisor_retencion_id = $supervisor_retencion->id;
        }

        /**/
        $asesor->save();

        $nomina = new NominaTienda();
        $nomina->id_asesor = $asesor->id;
        $nomina->mes = $mes_nomina;
        $nomina->asesor_mes = $asesor->id.$mes_nomina;
        $nomina->id_consideracion = $consideracion_id;
        $nomina->estado_consideracion = 'pendiente';
        $nomina->detalles_consideracion = $detalles_consideracion;
        $nomina->save();

        return redirect('asesores_tienda2/create');
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
}
