<?php

namespace App\Http\Controllers;

use App\AsesorTienda;
use App\NominaTienda;
use App\SupervisorGuiaTigo;
use App\Tienda;
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
        return view('tiendas.asesores.create2', ['tiendas'=>$tiendas, 'cargos'=>$cargos,
            'supervisores'=>$supervisores, 'agrupaciones'=>$agrupaciones]);
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
        $tienda_tl = explode('-',$request->get('tienda_teamleader_id'));
        $tienda_id = $tienda_tl[0];
        $teamleader_id = $tienda_tl[1];
        $consideracion_id = $request->get('consideracion_id');
        $detalles_consideracion = $request->get('detalles_consideracion');
        $cargo_go = $request->get('cargo_go');
        $user_red = $request->get('user_red');
        $especialista = $request->get('especialista');
        $supervisor_id = $request->get('supervisor_id');
        $agrupacion = $request->get('agrupacion');


        $asesor = new AsesorTienda();
        $asesor->ch = $request->get('ch');
        $asesor->documento = $request->get('documento');
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        $asesor->staff = $request->get('staff');
        $asesor->cargo_go = $cargo_go;
        $asesor->activo = 'ACTIVO';
        $asesor->user_red = $user_red;
        $asesor->especialista = $especialista;
        $asesor->supervisor_guiatigo_id = $supervisor_id;
        $asesor->agrupacion = $agrupacion;

        if ($agrupacion <> 'RETENCION CALL' )
        {
            $asesor->id_tienda = $tienda_id;
            $asesor->id_teamleader = $teamleader_id;
        }

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
