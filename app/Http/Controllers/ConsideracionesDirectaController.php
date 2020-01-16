<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\Zona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Consideracion;
use App\NominaDirecta;
use App\PersonaDirecta;

class ConsideracionesDirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $fecha1 = new Carbon('first day of this month');
        $fecha2 = (new Carbon('first day of this month'))->addDays(10);
        $fecha_actual = Carbon::now();
        $porcentajes = ['50%', '75%','75% nuevo','prorrateado', '25%', 'sin objetivos'];

        if ($fecha_actual->between($fecha1, $fecha2))
        {
            $mes = Carbon::now()->format('Ym');

        }
        else
        {
            $mes=201912;

            //$mes = Carbon::now()->addMonth(1)->format('Ym');

        }
        $mes=202002;

        $id_persona = $request->get('id_persona');
        $id_consideracion = $request->get('id_consideracion');
        $zonas = auth()->user()->zonas->pluck('id');
        $estado_consideracion = $request->get('estado');

        $personas_consideracion = NominaDirecta::where('estado_consideracion', '<>', NULL)
            ->mes($mes)->representanteDir($id_persona)->consideracion($id_consideracion)->estadoConsideracion($estado_consideracion)
            ->get();
        $consideraciones = Consideracion::all();


        return view('consideraciones_directa.index', ['personas_consideracion' => $personas_consideracion,
            'zonas'=>$zonas, 'consideraciones'=>$consideraciones, 'porcentajes'=>$porcentajes]);
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
        $consideraciones = Consideracion::all();
        $persona = NominaDirecta::findOrFail($id);
        return view('inactivaciones_directa.regularizar_consideracion', ['persona'=>$persona, 'consideraciones'=>$consideraciones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $persona = NominaDirecta::findOrFail($id);

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            if ($persona->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $archivo = Archivo::where('id_nomina_directa', $persona->id_nomina)
                    ->where('tipo', 'consideracion')->get()->first();
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
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $persona->estado_consideracion = 'pendiente';
        $persona->regularizacion_consideracion = $request->get('regularizacion_consideracion');
        $persona->id_consideracion = $request->get('id_consideracion');
        $persona->update();
        return redirect('consideraciones_directa');
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

    public function aprobarConsideraciones (Request $request, $mes)
    {
        $zonas = Zona::all();
        $consideraciones = Consideracion::all();
        $jefes = PersonaDirecta::where('cargo', '=', 'representante_jefe')->get();
        $id_consideracion = $request->get('id_consideracion');
        $id_persona = $request->get('id_persona');
        $id_zona = $request->get('id_zona');
        $id_jefe= $request->get('id_jefe');

        $personas_consideracion = NominaDirecta::where('estado_consideracion', '=', 'pendiente')
            ->mes($mes)->representanteDir($id_persona)->zonadirecta($id_zona, $id_jefe)->consideracion($id_consideracion)
            ->get();

        return view('consideraciones_directa.aprobacion', ['personas_consideracion' => $personas_consideracion, 'mes'=>$mes,
            'zonas'=>$zonas, 'consideraciones'=>$consideraciones, 'jefes'=>$jefes]);

    }

    public function storeConsideraciones (Request $request)
    {
        $nomina = $request->get('id_nomina');
        $estado_consideracion = $request->get('aprobacion');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $comentario_consideracion = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');

        $cont = 0;
        $cantidad_registros = count($estado_consideracion);

        //dd($cantidad_registros);

        foreach ($nomina as $id)
        {
            if ($cont < $cantidad_registros)
            {
                $nomina_consideracion = NominaDirecta::findOrFail($id);
                $nomina_consideracion->estado_consideracion = $estado_consideracion[$cont];
                $nomina_consideracion->motivo_rechazo_consideracion = $motivo_rechazo[$cont];
                $nomina_consideracion->comentario_consideracion = $comentario_consideracion[$cont];

                if (in_array($nomina_consideracion->id_consideracion, [6,12]) and
                    $nomina_consideracion->estado_consideracion == 'aprobado')
                {
                    $nomina_consideracion->estado_nomina = 'aprobado';
                }
                if ($nomina_consideracion->estado_consideracion == 'aprobado')
                {
                    $nomina_consideracion->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
                    $nomina_consideracion->porcentaje_objetivo = $objetivo[$cont];
                }

                $nomina_consideracion->update();
            }
            $cont = $cont+1;
        }
       /* while ($cont < count($nomina))
        {
            $nomina_consideracion = NominaDirecta::findOrFail($nomina[$cont]);
            $nomina_consideracion->estado_consideracion = $estado_consideracion[$cont];

            $nomina_consideracion->motivo_rechazo_consideracion = $motivo_rechazo[$cont];

            $nomina_consideracion->comentario_consideracion = $comentario_consideracion[$cont];

            if (in_array($nomina_consideracion->id_consideracion, [6,12]) and
                $nomina_consideracion->estado_consideracion == 'aprobado')
            {
                $nomina_consideracion->estado_nomina = 'aprobado';
            }
            if ($nomina_consideracion->estado_consideracion == 'aprobado')
            {
                $nomina_consideracion->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
                $nomina_consideracion->porcentaje_objetivo = $objetivo[$cont];
            }
            $cont = $cont+1;
            $nomina_consideracion->update();

        }*/

        return redirect()->back();
    }

    public function updateEstado(Request $request, $id)
    {

        $persona = NominaDirecta::findOrFail($id);
        $estado_consideracion = $request->get('estado_consideracion');
        $comentarios = $request->get('comentario_consideracion');
        $objetivo = $request->get('objetivo');


        if ($estado_consideracion == 'aprobado')
        {
            $persona->estado_consideracion = 'aprobado';
            $persona->comentario_consideracion = $comentarios;
            $persona->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');
            $persona->motivo_rechazo_consideracion = NULL;
            $persona->porcentaje_objetivo = $objetivo[0];

        }
        elseif ($estado_consideracion == 'rechazado')
        {
            $persona->estado_consideracion = 'rechazado';
            $persona->motivo_rechazo_consideracion = $comentarios;
            $persona->comentario_consideracion = NULL;
            $persona->porcentaje_objetivo = NULL;
        }
        else
        {
            $persona->estado_consideracion = 'pendiente';
            $persona->motivo_rechazo_consideracion = NULL;
            $persona->comentario_consideracion = NULL;
            $persona->porcentaje_objetivo = 'NULL';
        }

        $persona->update();

        return redirect('consideraciones_directa');

    }


    /**
     * Editar una consideracion ya creada, antes de que se apruebe o se rechace
     * */
    public function updateConsideracion(Request $request, $id)
    {
        $persona = NominaDirecta::findOrFail($id);

        //dd($request->file('archivo'));

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);

            if ($persona->archivos->where('tipo', '=', 'consideracion')->first())
            {
                $archivo = Archivo::where('id_nomina_directa', $persona->id_nomina)
                    ->where('tipo', 'consideracion')->get()->first();
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
                $archivo->tipo = 'consideracion';
                $archivo->save();
            }

        }

        $persona->id_consideracion = $request->get('id_consideracion');
        $persona->detalles_consideracion = $request->get('detalles_consideracion');
        //dd($persona->detalles_consideracion);
        $persona->update();
        return redirect('consideraciones_directa');
    }

}
