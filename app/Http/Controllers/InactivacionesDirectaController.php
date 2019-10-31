<?php

namespace App\Http\Controllers;

use App\Archivo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\NominaDirecta;
use App\PersonaDirecta;

class InactivacionesDirectaController extends Controller
{
    /**
     * InactivacionesDirectaController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zonas = auth()->user()->zonas->pluck('id');
        $fecha1 = new Carbon('first day of this month');
        $fecha2 = (new Carbon('first day of this month'))->addDays(22);
        $mes_actual = Carbon::now();
        $id_persona = $request->get('id_persona');
        $estado_inactivacion = $request->get('estado');
        $porcentajes = ['100%', '75% nuevo', '75%', '50%', 'prorrateado', '25%', 'sin objetivos'];

        if ($mes_actual->between($fecha1, $fecha2))
        {
            $mes=Carbon::now()->format('Ym');
        }
        else
        {

            $mes = 201911;
            //$mes= Carbon::now()->addMonth(1)->format('Ym');

        }

       // $mes = Carbon::now()->format('Ym');

        $inactivaciones = NominaDirecta::where('estado_inactivacion', '<>', 'NULL')
            ->where('mes', '=', $mes )
            ->representanteDir($id_persona)->estadoInactivacion($estado_inactivacion)
            ->get();

        return view('inactivaciones_directa.index', ['inactivaciones'=>$inactivaciones, 'zonas'=>$zonas, 'porcentajes'=>$porcentajes    ]);
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
        $persona = NominaDirecta::findOrFail($id);
        $motivos = ['renuncia', 'desvinculacion', 'cambio de canal'];
        return view('inactivaciones_directa.regularizar_inactivacion', ['persona'=>$persona, 'motivos'=>$motivos]);
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
        $persona = NominaDirecta::findOrFail($id);
        $persona->estado_inactivacion = 'pendiente';
        $persona->regularizacion_inactivacion = $request->get('regularizacion_inactivacion');
        $persona->update();
        return redirect('inactivaciones_directa');
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

    public function updateInactivacion(Request $request, $id)
    {
        $persona = NominaDirecta::findOrFail($id);

        if ($request->hasFile('archivo'))
        {

            if ($persona->archivos->where('tipo', '=', 'inactivacion')->first())
            {
                $archivo = Archivo::where('id_nomina_directa', $persona->id_nomina)
                    ->where('tipo', 'inactivacion')->get()->first();
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->update();
            }
            else
            {
                $archivo = new Archivo();
                $archivo->id_nomina_directa = $persona->id_nomina;
                $ruta = $request->file('archivo')->store('public');
                $archivo->nombre = explode('/',$ruta)[1];
                $archivo->tipo = 'inactivacion';
                $archivo->save();
            }

        }

        $persona->fill($request->all());
        $persona->update();
        return redirect()->back();

    }

    public function updateEstado(Request $request, $id)
    {
        $persona = NominaDirecta::findOrFail($id);

        $estado_inactivacion = $request->get('estado_inactivacion');
        $comentarios = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');

        if ($estado_inactivacion == 'aprobado')
        {
            $persona->estado_inactivacion = 'aprobado';
            $persona->comentario_inactivacion = $comentarios;
            $persona->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
            $persona->motivo_rechazo_inactivacion = NULL;
            $persona->porcentaje_objetivo = $objetivo[0];
        }
        elseif ($estado_inactivacion == 'rechazado')
        {
            $persona->estado_inactivacion = 'rechazado';
            $persona->motivo_rechazo_inactivacion = $comentarios;
            $persona->comentario_inactivacion = NULL;
            $persona->porcentaje_objetivo = '100%';
        }

        $persona->update();

        return redirect()->back();

    }
}
