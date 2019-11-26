<?php

namespace App\Http\Controllers;

use App\ZonaTienda;
use Illuminate\Http\Request;
use App\Tienda;
use App\JefeTienda;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zonas = ZonaTienda::all();
        $zona_id = $request->get('zona_id');
        $tienda_id = $request->get('tienda_id');
        $jefes_tienda = JefeTienda::all();
        $tiendas = Tienda::tienda($tienda_id)->zonaTienda($zona_id)->ordeBy('id')->get();

        return view('tiendas.tiendas.index', ['tiendas'=>$tiendas, 'jefes_tienda'=>$jefes_tienda,
            'zonas'=>$zonas]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $tienda = Tienda::findOrFail($id);
        $jefes_tienda = JefeTienda::all();
        $zonas = ZonaTienda::all();
        $tipos_tienda = ['1','2','3', '4'];
        $clasificaciones = ['TIENDA', 'TIENDA EXPRESS', 'SHOPPING'];

        return view('tiendas.tiendas.edit', ['tienda'=>$tienda, 'zonas'=>$zonas, 'tipos_tienda'=>$tipos_tienda,
            'jefes_tienda'=>$jefes_tienda, 'clasificaciones'=>$clasificaciones]);
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
        $tienda = Tienda::findOrFail($id);
        $tienda->zona_id = $request->get('zona_id');
        $tienda->tienda_nombre = $request->get('tienda_nombre');
        $tienda->jefe_tienda_id = $request->get('jefe_tienda_id');
        $tienda->tipo_tienda = $request->get('tipo_tienda');
        $tienda->clasificacion = $request->get('clasificacion');
        $tienda->zona_tienda = $request->get('zona_tienda');

        $tienda->update();
        return redirect('tiendas');
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
