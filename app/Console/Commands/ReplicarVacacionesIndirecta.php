<?php

namespace App\Console\Commands;

use App\Evolution;
use App\Impulsador;
use App\NominaIndirecta;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReplicarVacacionesIndirecta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicar:vacacionesIndirecta';

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
        $mes = \Config::get('global.mes_indirecta');
        $vacaciones = Evolution::where('canal', '=', 'INDIRECTA')
            ->where('estado', '=', 'AUTORIZADO')
            ->where('mes', '=', $mes)->get();

        foreach ($vacaciones as $vacacion)
        {
            $impulsador = Impulsador::where('ch', '=', $vacacion->ch)->get()->last();
            $nomina = NominaIndirecta::where('impulsador_id', '=', $impulsador->id)
                ->where('mes', '=', $mes)->get()->last();
            $fecha_hasta = str_replace('/', '-', $vacacion->hasta);
            $fecha_desde = str_replace('/', '-', $vacacion->desde);


            $hasta = New Carbon($fecha_hasta);
            $desde = New Carbon($fecha_desde);
            $cant_dias = $hasta->diffInDays($desde);

            if ($cant_dias == 18)
            {
                $nomina->consideracion_id = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentarios_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->porcentaje_objetivo = 'prorrateado';
            }
            elseif ($cant_dias == 12)
            {
                $nomina->consideracion_id = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentarios_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->porcentaje_objetivo = '50%';
            }
            elseif ($cant_dias == 6)
            {
                $nomina->consideracion_id = 3;
                $nomina->estado_consideracion = 'aprobado';
                $nomina->detalles_consideracion = 'desde '.$desde->format('d-m-yy').' hasta '.$hasta->format('d-m-yy').' días: '.$cant_dias;
                $nomina->comentarios_consideracion = 'OK. Vacaciones '.$cant_dias.' días';
                $nomina->fecha_aprobacion_consideracion = Carbon::now()->format('d/m/Y');;
                $nomina->porcentaje_objetivo = 'prorrateado';
            }
            $nomina->update();
            $this->info($nomina ? 'ok' : 'not ok, nomina: ');
        }
    }
}
