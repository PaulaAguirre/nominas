<?php

namespace App\Console\Commands;

use App\NominaDirectaRPL;
use Illuminate\Console\Command;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use App\NominaDirecta;

class ReplicarNominaDirecta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicar:personasDirecta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replica la estructura de los asesores de la Directa';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mes = 202003;
        $personas = NominaDirecta::where('mes', '=', $mes)->get();

        foreach ($personas as $persona)
        {
            // replica la tabla personas directa
            $personaRPL = new PersonaDirectaRPL();
            $personaRPL->id_persona_anterior = $persona->id_persona_directa;
            $personaRPL->mes = $mes;
            $personaRPL->ch = $persona->personaDirecta->ch;
            $personaRPL->fecha_ingreso = $persona->personaDirecta->fecha_ingreso;
            $personaRPL->documento_persona = $persona->personaDirecta->documento_persona;
            $personaRPL->nombre = $persona->personaDirecta->nombre;
            $personaRPL->id_representante_jefe = $persona->personaDirecta->id_representante_jefe;
            $personaRPL->id_representante_jefe_nuevo = $persona->personaDirecta->id_representante_jefe_nuevo;
            $personaRPL->cargo = $persona->personaDirecta->cargo;
            $personaRPL->id_zona = $persona->personaDirecta->id_zona;
            $personaRPL->id_zona_nuevo = $persona->personaDirecta->id_zona_nuevo;
            $personaRPL->cargo_go = $persona->personaDirecta->cargo_go;
            $personaRPL->agrupacion = $persona->personaDirecta->agrupacion;
            $personaRPL->estado_cambio = $persona->personaDirecta->estado_cambio;
            $personaRPL->motivo_rechazo = $persona->personaDirecta->motivo_rechazo;
            $personaRPL->regularizacion_cambio = $persona->personaDirecta->regularizacion_cambio;
            $personaRPL->staff = $persona->personaDirecta->staff;
            $personaRPL->id_consideracion = $persona->personaDirecta->id_consideracion;
            $personaRPL->detalles_consideracion = $persona->personaDirecta->detalles_consideracion;
            $personaRPL->id_responsable_cambio = $persona->personaDirecta->id_responsable_cambio;
            $personaRPL->agrupacion_anterior = $persona->personaDirecta->agrupacion_anterior;

            $personaRPL->save();
            $this->info($personaRPL ? 'ok' : 'not ok');
        }

        foreach ($personas as $persona)
        {
            //replica la nómina
            $nominaRPL = new NominaDirectaRPL();
            $id_persona = PersonaDirectaRPL::where('mes', '=', $mes)
                ->where('id_persona_anterior', '=', $persona->id_persona_directa)->get()->first();
            $nominaRPL->id_persona_directa = $id_persona->id_persona;
            $nominaRPL->mes = $mes;
            $nominaRPL->persona_mes = $persona->persona_mes;
            $nominaRPL->estado_nomina = $persona->estado_nomina;
            $nominaRPL->motivo_rechazo = $persona->motivo_rechazo;
            $nominaRPL->id_consideracion = $persona->id_consideracion;
            $nominaRPL->detalles_consideracion = $persona->detalles_consideracion;
            $nominaRPL->motivo_rechazo_consideracion = $persona->motivo_rechazo_consideracion;
            $nominaRPL->estado_consideracion = $persona->estado_consideracion;
            $nominaRPL->activo = $persona->activo;
            $nominaRPL->agrupacion = $persona->agrupacion;
            $nominaRPL->agrupacion_anterior = $persona->agrupacion_anterior;
            $nominaRPL->regularizacion = $persona->regularizacion;
            $nominaRPL->regularizacion_consideracion = $persona->regularizacion_consideracion;
            $nominaRPL->regularizacion_nomina = $persona->regularizacion_nomina;
            $nominaRPL->motivo_inactivacion = $persona->motivo_inactivacion;
            $nominaRPL->detalles_inactivacion = $persona->detalles_inactivacion;
            $nominaRPL->estado_inactivacion = $persona->estado_inactivacion;
            $nominaRPL->regularizacion_inactivacion = $persona->regularizacion_inactivacion;
            $nominaRPL->motivo_rechazo_inactivacion = $persona->motivo_rechazo_inactivacion;
            $nominaRPL->comentario_consideracion = $persona->comentario_consideracion;
            $nominaRPL->comentario_inactivacion = $persona->comentario_inactivacion;
            $nominaRPL->fecha_aprobacion_consideracion = $persona->fecha_aprobacion_consideracion;
            $nominaRPL->fecha_aprobacion_inactivacion = $persona->fecha_aprobacion_inactivacion;
            $nominaRPL->fecha_aprobacion_inactivacion = $persona->fecha_aprobacion_inactivacion;
            $nominaRPL->porcentaje_objetivo = $persona->porcentaje_objetivo;
            $nominaRPL->fecha_carga_consideracion = $persona->fecha_carga_consideracion;
            $nominaRPL->fecha_carga_inactivacion = $persona->fecha_carga_inactivacion;

            $nominaRPL->save();
            $personaRPL->save();
            $this->info($personaRPL ? 'ok' : 'not ok');
        }
    }
}
