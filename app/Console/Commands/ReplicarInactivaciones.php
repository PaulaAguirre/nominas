<?php

namespace App\Console\Commands;

use App\NominaDirecta;
use App\NominaDirectaRPL;
use App\PersonaDirecta;
use App\PersonaDirectaRPL;
use Illuminate\Console\Command;

class ReplicarInactivaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicar:inactivacionesDirecta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'elimina a las personas inactivas de la nómina en el sgte mes';

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
        $mes = \Config::get('global.mes_anterior');
        $mes_actual = \Config::get('global.mes');
        $asesores_inactivados_mes_pasado = PersonaDirectaRPL::where('activo','=', 'inactivo' )
            ->where('mes', '=', $mes)->get();

        foreach ($asesores_inactivados_mes_pasado as $persona)
        {
            $persona_mes_pasado = PersonaDirecta::findOrFail($persona->id_persona_anterior);
            $persona_mes_pasado->activo = 'inactivo';
            $persona_mes_pasado->update();

            $nomina_actual = NominaDirecta::where('id_persona_directa', '=', $persona_mes_pasado->id_persona)
                ->where('mes', '=', $mes_actual )
                ->get()->last();

            $this->info($nomina_actual->delete() ? 'ok' : 'not ok');
        }

    }
}
