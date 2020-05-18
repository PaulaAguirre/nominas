<?php

namespace App\Http\Controllers;

use App\ArchivoDirectaRPL;
use App\Consideracion;
use App\NominaDirectaRPL;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use App\Zona;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NominaDirectaRPLController extends Controller
{
    /**
     * NominaDirectaRPLController constructor.
     */
    public function __construct()
    {
        $this->middleware('roles:tigo_people,tigo_people_admin')->only(['aprobarNomina', 'aprobarInactivaciones']);
        $this->middleware('roles:zonal,tigo_people_admin')->only(['create', 'edit','agregarConsideraciones', 'destroy']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {

        //dd(Carbon::now() < Carbon::now()->firstOfMonth()->addDay(14));
        $mes = $request->get('mes');
        if(!$mes)
        {
            $mes = \Config::get('global.mes_anterior');
        }
        $consideraciones = Consideracion::all();
        $jefe_id = $request->get('id_jefe');
        $zona_id = $request->get('id_zona');
        $representante_id = $request->get('id_persona');

        if (\Auth::user()->hasRoles(['zonal']))
        {
            $zonasZonal = \Auth::user()->zonas->pluck('id')->toArray();
            $zonas = \Auth::user()->zonas;
            $jefes = PersonaDirecta::where('cargo', '=', 'representante_jefe')
                ->whereIn('id_zona', $zonasZonal)->get();
            $personas = NominaDirectaRPL::zonasZonales($zonasZonal)->representante($representante_id, $mes)->jefe($jefe_id)->zona($zona_id)
                ->where('mes', '=', $mes)->get();

        }
        else
        {
            $zonas = Zona::all();
            $jefes = PersonaDirecta::where('cargo', '=', 'representante_jefe')
                ->get();
            $personas = NominaDirectaRPL::jefe($jefe_id)->zona($zona_id)->representante($representante_id, $mes)
                ->where('mes', '=', $mes)->get();

        }
        return view('directaRPL.nomina.index', ['personas'=>$personas, 'consideraciones'=>$consideraciones,
            'mes'=>$mes, 'jefes'=>$jefes, 'zonas'=>$zonas]);
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
        $persona_nomina = NominaDirectaRPL::findOrFail($id);
        $motivo_inactivacion = $request->get('motivo_inactivacion');
        $detalles_inactivacion = $request->get('detalles_inactivacion');

        $persona_nomina->motivo_inactivacion = $motivo_inactivacion;
        $persona_nomina->detalles_inactivacion = $detalles_inactivacion;
        $persona_nomina->estado_inactivacion = 'pendiente';
        $persona_nomina->fecha_carga_inactivacion = (Carbon::now())->format('d-m-Y');

        if ($request->hasFile('archivo')) {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new ArchivoDirectaRPL();
            $archivo->nomina_directa_id = $persona_nomina->id_nomina;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/', $ruta)[1];
            $archivo->tipo = 'inactivacion';
            $archivo->save();
        }

        $persona_nomina->update();

        return redirect()->back();
    }
}
