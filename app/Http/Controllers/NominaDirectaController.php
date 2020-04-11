<?php
/**
 * Copyright (c) 2019
 */

namespace App\Http\Controllers;
use App\Archivo;
use App\Consideracion;
use App\NominaDirecta;
use App\PersonaDirecta;
use App\PorcentajeDirecta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Psr\Log\NullLogger;
use App\Zona;


class




NominaDirectaController extends Controller
{
    /**
     * NominaDirectaController constructor.
     */
    public function __construct()
    {
        $this->middleware('roles:tigo_people,tigo_people_admin')->only(['aprobarNomina', 'aprobarInactivaciones']);
        $this->middleware('roles:zonal,tigo_people_admin')->only(['create', 'edit','agregarConsideraciones', 'destroy']);


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $zonas = auth()->user()->zonas->pluck('id')->toArray();
       // dd($zonas);

        $mes = $request->get('mes');
        $id_zona = $request->get('id_zona');
        $id_persona= $request->get('id_persona');
        $id_jefe = $request->get('id_jefe');
        $estado = $request->get('estado');
        $activo = $request->get('activo');

        if(auth()->user()->hasRoles(['tigo_people_admin']))
        {
            $zonas_user = Zona::all();
            $jefes = PersonaDirecta::where('cargo', '=', 'representante_jefe')->get();
            $personas = NominaDirecta::representanteDir($id_persona)->mes($mes)->jefesDirecta($id_jefe)
                ->zonadirecta($id_zona, $id_jefe)
                ->estado($estado)
                ->inactivo($activo)
                ->orderBy('id_nomina')->get();
        }
        else
        {
          $zonas_user = Zona::whereIn('id', $zonas)->get();
          $jefes = PersonaDirecta::where('cargo', '=', 'representante_jefe')
              ->whereIn('id_zona', $zonas)->get();
          $id_personas = PersonaDirecta::where('cargo', '=', 'representante')
              ->whereIn('id_zona', $zonas)->get()->pluck('id_persona')->toArray();
          $personas = NominaDirecta::representanteDir($id_persona)->mes($mes)->zonadirecta($id_zona, $id_jefe)
            ->jefesDirecta($id_jefe)->estado($estado)->whereIn('id_persona_directa', $id_personas)
            ->orderBy('id_nomina')->get();
        }



        $fecha_inicio = (new Carbon('first day of this month'))->addDays(14);
        $fecha_fin = new Carbon('first day of next month');
        $today = Carbon::today();

        return view('nomina_directa.index', ['personas' => $personas,
            'zonas' =>$zonas, 'zonas_user'=>$zonas_user, 'jefes'=>$jefes,
            'fecha_inicio'=>$fecha_inicio, 'fecha_fin'=>$fecha_fin, 'today'=>$today]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (auth()->user()->hasRoles(['zonal']))
        {
          $zonas = auth()->user()->zonas;
        }
        else
        {
            $zonas = Zona::all();
        }

        $id_rep_jefe = $request->get('id_jefe');
        $id_rep = $request->get('id_representante');
        $id_zona = $request->get('id_zona');

        $jefes = PersonaDirecta::where('cargo', 'representante_jefe')->get();

        $fecha_actual = Carbon::today();
        $fecha_fin = (new Carbon('first day of this month'))->addDays(10);

        if ($fecha_actual < $fecha_fin)
        {
            $mes_nomina = $fecha_actual->format('Ym');
            /**los asesores que ya se encuentran en la nomina que no deben aparecer entre los que estan para agregar**/
            $representantes_existentes = NominaDirecta::where('mes', $mes_nomina)
                ->get()->pluck('id_persona_directa')->toArray();

            $personas_directa = PersonaDirecta::whereNotIn('id_persona', $representantes_existentes)
                ->where('activo', '=', 'activo')
                ->representantesdir($id_rep)->jefe($id_rep_jefe)->zona($id_zona)
                ->get();
        }
        else
        {
            $mes_anterior = $fecha_actual->format('Ym');
            $mes_nomina = Carbon::now()->addMonth()->format ('Ym');
            /**los asesores que ya se encuentran en la nomina que no deben aparecer entre los que estan para agregar**/
            $representantes_existentes = NominaDirecta::where('mes', $mes_nomina)
                ->get()->pluck('id_persona_directa')->toArray();

            $personas_directa = PersonaDirecta::whereNotIn('id_persona', $representantes_existentes)
                ->where('activo', '=', 'activo')
                ->representantesdir($id_rep)->jefe($id_rep_jefe)->zona($id_zona)
                ->get();

            //dd($personas_directa->count());
        }


        return view('nomina_directa.create', ['personas_directa' => $personas_directa, 'jefes' => $jefes,
                          'mes_nomina'=>$mes_nomina, 'zonas'=>$zonas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personas_id = $request->get('idrepresentante');
        $activo = $request->get('activo');
        $cont = 0;
        $persona_mes = $request->get('persona_mes');

        $fecha_actual = Carbon::today();
        $fecha_fin = (new Carbon('first day of this month'))->addDays(10);

        if ($fecha_actual < $fecha_fin)
        {
            $mes_nomina = $fecha_actual->format('Ym');
        }
        else
        {
            $mes_nomina = Carbon::now()->addMonth()->format ('Ym');
        }

         /**
         * Validaciones
         */
        $messages = [];
        $rules = [];


       foreach ($request->get('persona_mes') as $key => $val)
        {
            $persona = PersonaDirecta::findOrFail($personas_id[$key]);
            $rules['persona_mes.'.$key] = 'unique:nomina_directa,persona_mes';
            $messages['persona_mes.'.$key.'.unique'] = 'Asesor duplicado: '. $persona->nombre;
        }
        $this->validate($request, $rules, $messages);

        $mes_anterior = Carbon::now()->format('Ym');
        $asesores_existentes = NominaDirecta::where('mes', $mes_anterior)
            ->get()->pluck('id_persona_directa');

        while ($cont < count($personas_id))
        {

            $nomina = new NominaDirecta();
            $nomina->id_persona_directa = $personas_id[$cont];
            $nomina->mes = $mes_nomina ;
            $nomina->persona_mes = $personas_id[$cont].$mes_nomina;
            $nomina->activo = 'activo';
            $nomina->agrupacion = PersonaDirecta::findOrFail($personas_id[$cont])->agrupacion;
            if ($asesores_existentes->contains( $personas_id[$cont]))
            {
                $nomina->estado_nomina = 'aprobado';
            }

            $nomina->save();
            $cont = $cont + 1;
        }

        return redirect('nomina_directa/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function show(NominaDirecta $nominaDirecta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     * editar los rechazados en la nómina.
     */
    public function edit($id)
    {
        $nominaDirecta = NominaDirecta::findOrFail($id);
        return view('nomina_directa.edit', ['nomina_directa'=>$nominaDirecta]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $nomina_directa = NominaDirecta::findOrFail($id);
       $regularizacion = $request->get('regularizacion');
       $nomina_directa->regularizacion_nomina = $regularizacion;
       $nomina_directa->estado_nomina = 'pendiente';
       $nomina_directa->update();
       return redirect('nomina_directa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NominaDirecta  $nominaDirecta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $persona_nomina = NominaDirecta::findOrFail($id);
        $motivo_inactivacion = $request->get('motivo_inactivacion');
        $detalles_inactivacion = $request->get('detalles_inactivacion');

        $persona_nomina->motivo_inactivacion = $motivo_inactivacion;
        $persona_nomina->detalles_inactivacion = $detalles_inactivacion;
        $persona_nomina->estado_inactivacion = 'pendiente';
        $persona_nomina->fecha_carga_inactivacion = (Carbon::now())->format('d-m-Y');

        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);
            $archivo = new Archivo();
            $archivo->id_nomina_directa = $persona_nomina->id_nomina;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            $archivo->tipo = 'inactivacion';
            $archivo->save();
        }

        $persona_nomina->update();

        return redirect('nomina_directa');
    }

    public function aprobarInactivaciones(Request $request)
    {

        $mes=\Config::get('global.mes');

        $personas = NominaDirecta::where('estado_inactivacion', '=', 'pendiente')
            ->where('mes', '=', $mes)->get();
        $porcentajes = PorcentajeDirecta::where('descripcion', 'inactivacion')
            ->orderBy('nombre')->get();
        return view('nomina_directa.aprobar_inactivaciones', ['personas' => $personas, 'mes' => $mes,
            'porcentajes'=>$porcentajes]);
    }

    public function aprobarInactivacionesStore(Request $request)
    {
        $estado_inactivacion = $request->get('aprobacion');
        $nomina = $request->get('id_nomina');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $comentario_inactivacion = $request->get('comentario_inactivacion');
        $objetivo = $request->get('objetivo');
        $cont = 0;

        while ($cont < count($nomina))
        {
            $porcentaje = explode('-', $objetivo[$cont]);

            $nomina_directa = NominaDirecta::findOrFail($nomina[$cont]);
            $nomina_directa->estado_inactivacion = $estado_inactivacion[$cont];
            $nomina_directa->motivo_rechazo_inactivacion = $motivo_rechazo[$cont];
            $nomina_directa->comentario_inactivacion = $comentario_inactivacion[$cont];


            if ($nomina_directa->estado_inactivacion == 'aprobado')
            {
                $persona_directa = PersonaDirecta::findOrFail($nomina_directa->id_persona_directa);
                $persona_directa->activo = 'inactivo';
                $nomina_directa->fecha_aprobacion_inactivacion = Carbon::now()->format('d/m/Y');
                $nomina_directa->porcentaje_id = $porcentaje[0];
                $nomina_directa->porcentaje_objetivo = $porcentaje[1];
                $persona_directa->update();
            }

            $nomina_directa->update();
            $cont = $cont+1;
        }

        return redirect('aprobar_inactivaciones');
    }

    public function agregarConsideraciones ($id)
    {
        $persona_nomina = NominaDirecta::findOrFail($id); //->personaDirecta;
        $consideraciones = Consideracion::all();

        return view('nomina_directa.consideracion_nomina',
            ['persona_nomina' => $persona_nomina,
            'consideraciones' => $consideraciones ]);
    }

    public function storeConsideraciones (Request $request, $id)
    {

        $nominaDirecta = NominaDirecta::findOrFail($id);
        $nominaDirecta->id_consideracion = $request->get('id_consideracion');
        $nominaDirecta->detalles_consideracion = $request->get('detalles_consideracion');
        $nominaDirecta->estado_consideracion = 'pendiente';
        $nominaDirecta->fecha_carga_consideracion = (Carbon::now())->format('d-m-Y');


        if ($request->hasFile('archivo'))
        {
            $this->validate($request, [
                'archivo' => 'mimes:jpg,jpeg,gif,png,pdf'
            ]);

            $archivo = new Archivo();
            $archivo->id_nomina_directa = $nominaDirecta->id_nomina;
            $ruta = $request->file('archivo')->store('public');
            $archivo->nombre = explode('/',$ruta)[1];
            //dd($archivo->nombre);
            $archivo->tipo = 'consideracion';
            $archivo->save();
        }
        $nominaDirecta->update();
        return redirect('nomina_directa');

    }

    public function aprobarNomina (Request $request, $mes)
    {
        if(auth()->user()->hasRoles(['zonal', 'tigo_people'])){
            $zonas = auth()->user()->zonas;
        }
        else
        {
            $zonas = Zona::all();
        }

        $jefes = PersonaDirecta::where('cargo', 'representante_jefe')->get();

        $id_rep_jefe = $request->get('id_jefe');
        $id_rep = $request->get('id_representante');

        /**los asesores que ya se encuentran en la nomina con estado_nomina pendiente**/
        $mes_anterior = NominaDirecta::all()->last()->mes-1;
        $mes_actual = NominaDirecta::all()->last()->mes;
        $id_personas_mes_pasado = NominaDirecta::where('mes', $mes_anterior)->get()->pluck('id_persona_directa');
        $id_personas_mes_actual = NominaDirecta::where('mes', $mes_actual)
            ->get()->pluck('id_persona_directa');
        $id_persona_nuevas = $id_personas_mes_actual->diff($id_personas_mes_pasado);

        $personas_directa = NominaDirecta::where('estado_nomina', '=', 'pendiente') //personas a aprobar, solo las nuevas
        ->whereIn('id_persona_directa', $id_persona_nuevas)->mes($mes)->get();
        $mes_search = Carbon::now()->format('Ym');

        return view('nomina_directa.aprobacion', ['personas_directa' => $personas_directa,
            'jefes' => $jefes, 'mes'=>$mes, 'mes_search'=>$mes_search, 'zonas'=>$zonas]);
    }


    public function aprobarNominaStore (Request $request)
    {
        $estado = $request->get('aprobacion');
        $nomina= $request->get('id_nomina');
        $motivo_rechazo = $request->get('motivo_rechazo');
        $cont = 0;

        $mes = \Config::get('global.mes');

        $asesores_existentes = NominaDirecta::where('mes', $mes)
            ->whereNotIn('id_nomina', $nomina)
            ->get();



        foreach ($asesores_existentes as $asesor)
        {
            $asesor->estado_nomina = 'aprobado';
            $asesor->update();
        }


        while ($cont < count($nomina))
        {

            $nomina_directa = NominaDirecta::findOrFail($nomina[$cont]);
            $nomina_directa->estado_nomina = $estado[$cont];
            $nomina_directa->motivo_rechazo = $motivo_rechazo[$cont];
            $nomina_directa->update();
            $cont = $cont + 1;
        }

        return redirect('aprobacion_nomina_directa/'.$mes);
    }

    public function ingresarAsesorMesActual(Request $request)
    {

        $mes_nomina = \Config::get('global.mes');
        $id_zonas = auth()->user()->zonas->pluck('id')->toArray();


        $personas_mes_actual = NominaDirecta::where('mes', '=', $mes_nomina)
            ->pluck('id_persona_directa')->toArray();

        if (count($id_zonas) > 0){
            $personas_a_ingresar = PersonaDirecta::whereNotIn('id_persona', $personas_mes_actual)
                ->where('cargo', '=', 'representante')
                ->whereIn('id_zona', $id_zonas)
                ->where('activo', '=', 'activo')->get();
        }
        else
        {
            $personas_a_ingresar = PersonaDirecta::whereNotIn('id_persona', $personas_mes_actual)
                ->where('cargo', '=', 'representante')
                ->where('activo', '=', 'activo')->get();
        }

        return view('nomina_directa.ingresar_nuevo_asesor', ['personas_a_ingresar'=>$personas_a_ingresar,
            'mes_nomina'=>$mes_nomina]);

    }

    public function ingresarAsesorMesActualStore(Request $request)
    {
        $fecha1 = new Carbon('first day of this month');
        $fecha2 = (new Carbon('first day of this month'))->addDays(15);
        $mes = Carbon::now();

        if ($mes->between($fecha1, $fecha2))
        {
            $mes_nomina=Carbon::now()->format('Ym');
        }
        else
        {
            $mes_nomina = Carbon::now()->addMonth(1)->format('Ym');
        }

        $agregar = $request->get('agregar');

        $cont = 0;

        //$mes_nomina = Carbon::now()->addMonth(1)->format('Ym');

        $mes_nomina = \Config::get('global.mes');


        while ($cont < count($agregar))
        {
            $nomina = new NominaDirecta();
            $nomina->id_persona_directa = $agregar[$cont];
            $nomina->mes = $mes_nomina ;
            $nomina->persona_mes = $agregar[$cont].$mes_nomina ;
            $nomina->activo = 'activo';
            $nomina->agrupacion = PersonaDirecta::findOrFail($agregar[$cont])->agrupacion;
            $fecha_ingreso = PersonaDirecta::findOrFail($agregar[$cont])->fecha_ingreso;
            $nomina->estado_nomina = 'pendiente';
            $nomina->id_consideracion=PersonaDirecta::findOrFail($agregar[$cont])->id_consideracion;
            $nomina->detalles_consideracion = 'fecha ingreso: '.$fecha_ingreso.'-'.PersonaDirecta::findOrFail($agregar[$cont])->detalles_consideracion;
            $nomina->estado_consideracion= 'pendiente';
            $nomina->save();
            $cont = $cont + 1;
        }
        return redirect('nomina_directa');
    }

}
