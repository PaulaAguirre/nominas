<?php

namespace App\Console\Commands;

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
            $personaRPL->agrupacion = $persona->personaDirecta->activo;
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


        }
    }
}
