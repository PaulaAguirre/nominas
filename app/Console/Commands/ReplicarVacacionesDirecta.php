<?php

namespace App\Console\Commands;

use App\Evolution;
use App\NominaDirecta;
use App\PersonaDirecta;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ReplicarVacacionesDirecta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicar:vacacionesDirecta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toma las vacaciones del EVO y replica en nómina';

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
        $mes = \Config::get('global.mes');
        $vacaciones = Evolution::where('canal', '=', 'DIRECTA')
            ->where('estado', '=', 'AUTORIZADO')
            ->where('mes', '=', $mes)->get();

        foreach ($vacaciones as $vacacion)
        {
            $persona = PersonaDirecta::where('ch', '=', $vacacion->ch)->get()->last();
            $nomina = NominaDirecta::where('id_persona_directa', '=', $persona->id_persona)
                ->where('mes', '=', $mes)->get()->last();

            $fecha_hasta = str_replace('/', '-', $vacacion->hasta);
            $fecha_desde = str_replace('/', '-', $vacacion->desde);


            $hasta = New Carbon($fecha_hasta);
            $desde = New Carbon($fecha_desde);
            $cant_dias = $hasta->diffInDays($desde);

            if ($cant_dias == 18)
            {
                $nomina->id_consideracion = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->porcentaje_id = 21;
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentario_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->update();
            }
            elseif ($cant_dias == 12)
            {
                $nomina->id_consideracion = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->porcentaje_id = 3;
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentario_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->update();
            }
            elseif ($cant_dias == 6)
            {
                $nomina->id_consideracion = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->porcentaje_id = 3;
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentario_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->update();
            }
            $this->info($nomina ? 'ok' : 'not ok, nomina: ');
        }
    }
}
