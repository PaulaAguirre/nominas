<?php

namespace App\Http\Controllers;

use App\ArchivoTiendaRPL;
use App\AsesorTiendaRPL;
use App\NominaTiendaRPL;
use App\SupervisorGuiaTigo;
use App\Tienda;
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
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PlUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS', 'ASESOR CORRESPONSALIA', 'ASESOR DE VENTAS SMART 5'];
        $supervisores = SupervisorGuiaTigo::all();

        return view('TiendaRPL.asesores.edit', ['asesor'=>$asesor, 'tiendas'=>$tiendas, 'cargos'=>$cargos, 'supervisores'=>$supervisores]);

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
        $teamleader_anterior = $asesor->id_teamleader;
        $tienda_anterior = $asesor->id_tienda;
        $cargo_anterior = $asesor->cargo_go;
        $tienda_tl = explode('-', $request->get('tienda_teamleader_id'));
        $asesor->documento = $request->get('documento');
        $asesor->staff = $request->get('staff');
        $asesor->especialista = $request->get('especialista');
        $asesor->user_red = $request->get('user_red');
        $asesor->supervisor_guiatigo_id = $request->get('supervisor_id');

        if (\Auth::user()->hasRoles(['tigo_people_admin']))
        {
            $asesor->ch = $request->get('ch');
            $asesor->nombre = strtoupper($request->get('nombre'));
            $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        }


        if ($teamleader_anterior <> $tienda_tl[1]) {
            $asesor->id_anterior_teamleader = $teamleader_anterior;
            $asesor->id_teamleader = $tienda_tl[1];

            $nomina = NominaTienda::where('id_asesor', $asesor->id)->get()->last();
            $nomina->cambio_jefe = 'si';
            $nomina->fecha_cambio_jefe = Carbon::now()->format('d-m-Y');
            $nomina->update();

        }
        if ($cargo_anterior <> $request->get('cargo_go')) {

            $asesor->cargo_go = $request->get('cargo_go');
            $asesor->cargo_anterior = $cargo_anterior;



        }
        if ($tienda_anterior <> $tienda_tl[0]) {
            $asesor->id_tienda_anterior = $tienda_anterior;
            $asesor->id_tienda = $tienda_tl[0];


        }
        $asesor->user_id = \Auth::user()->id;

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

