<?php

namespace App\Http\Controllers;

use App\ArchivoTienda;
use App\AsesorTienda;
use App\NominaTienda;
use App\Teamleader;
use App\Tienda;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\ZonaTienda;

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
     * @return Response
     */
    public function create()
    {
        $tiendas = Tienda::all();
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PlUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS'];

        return view('tiendas.asesores.create', ['tiendas'=>$tiendas, 'cargos'=>$cargos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $mes_nomina = 201911;
        $tienda_tl = explode('-',$request->get('tienda_teamleader_id'));
        $tienda_id = $tienda_tl[0];
        $teamleader_id = $tienda_tl[1];
        $consideracion_id = $request->get('consideracion_id');
        $detalles_consideracion = $request->get('detalles_consideracion');
        $cargo_go = $request->get('cargo_go');

        $asesor = new AsesorTienda();
        $asesor->id_teamleader = $teamleader_id;
        $asesor->ch = $request->get('ch');
        $asesor->documento = $request->get('documento');
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        $asesor->staff = $request->get('staff');
        $asesor->id_tienda = $tienda_id;
        $asesor->cargo_go = $cargo_go;
        $asesor->activo = 'ACTIVO';
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
     * @return Response
     */
    public function edit($id)
    {
        $asesor = AsesorTienda::findOrFail($id);
        $tiendas = Tienda::all();
        $cargos = ['GO1', 'GO2', 'GO3', 'GO3 PlUS', 'ASESOR DE VENTAS SMART',
            'F&F', 'RECEPCIONISTA', 'GUIA TIGO', 'SAC VENTAS', 'ATENCIÓN EXPRESS'];

        return view('tiendas.asesores.edit', ['asesor'=>$asesor, 'tiendas'=>$tiendas, 'cargos'=>$cargos]);

    }


    public function update(Request $request, $id)
    {
        $asesor = AsesorTienda::findOrFail($id);
        $teamleader_anterior = $asesor->id_teamleader;
        $tienda_anterior = $asesor->id_tienda;
        $cargo_anterior = $asesor->cargo_go;
        $tienda_tl = explode('-', $request->get('tienda_teamleader_id'));


        $asesor->ch = $request->get('ch');
        $asesor->documento = $request->get('documento');
        $asesor->nombre = strtoupper($request->get('nombre'));
        $asesor->fecha_ingreso = $request->get('fecha_ingreso');
        $asesor->staff = $request->get('staff');


        if ($teamleader_anterior <> $tienda_tl[1]) {
            $asesor->id_anterior_teamleader = $teamleader_anterior;
            $asesor->id_teamleader = $tienda_tl[1];
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
