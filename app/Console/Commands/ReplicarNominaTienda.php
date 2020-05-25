<?php

namespace App\Console\Commands;

use App\AsesorTiendaRPL;
use App\NominaTienda;
use App\NominaTiendaRPL;
use Illuminate\Console\Command;

class ReplicarNominaTienda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicar:nominaTienda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replica la estructura de los asesores de Tiendas del mes anterior';

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
        $mes = \Config::get('global.mes_anterior_tienda');
        $asesores = NominaTienda::where('mes', '=', $mes)->get();

        foreach ($asesores as $asesor)
        {
            $asesorRPL = new AsesorTiendaRPL();
            $asesorRPL->mes = $mes;
            $asesorRPL->anterior_id = $asesor->id_asesor;
            $asesorRPL->id_teamleader = $asesor->asesor->id_teamleader;
            $asesorRPL->ch = $asesor->asesor->ch;
            $asesorRPL->documento = $asesor->asesor->documento;
            $asesorRPL->nombre = $asesor->asesor->nombre;
            $asesorRPL->activo = $asesor->asesor->activo;
            $asesorRPL->staff = $asesor->asesor->staff;
            $asesorRPL->id_tienda = $asesor->asesor->id_tienda;
            $asesorRPL->fecha_ingreso = $asesor->asesor->fecha_ingreso;
            $asesorRPL->cargo_go = $asesor->asesor->cargo_go;
            $asesorRPL->id_tienda_anterior = $asesor->asesor->id_tienda_anterior;
            $asesorRPL->cargo_anterior = $asesor->asesor->cargo_anterior;
            $asesorRPL->user_red = $asesor->asesor->user_red;
            $asesorRPL->especialista = $asesor->asesor->especialista;
            $asesorRPL->supervisor_guiatigo_id = $asesor->asesor->supervisor_guiatigo_id;

            $asesorRPL->save();
            $this->info($asesorRPL ? 'ok' : 'not ok');
        }

        //Replicar Nomina Tienda
        foreach ($asesores as $asesor)
        {
            $id_asesor = AsesorTiendaRPL::where('mes', '=', $mes)
                ->where('anterior_id', '=', $asesor->id_asesor)->get()->first();
            $nominaRPL = new NominaTiendaRPL();
            $nominaRPL->id_asesor = $id_asesor->id;
            $nominaRPL->mes = $mes;
            $nominaRPL->id_consideracion = $asesor->id_consideracion;
            $nominaRPL->asesor_mes = $asesor->asesor_mes;
            $nominaRPL->detalles_consideracion = $asesor->detalles_consideracion;
            $nominaRPL->estado_consideracion = $asesor->estado_consideracion;
            $nominaRPL->comentarios_consideracion = $asesor->comentarios_consideracion;
            $nominaRPL->motivo_inactivacion = $asesor->motivo_inactivacion;
            $nominaRPL->detalles_inactivacion = $asesor->detalles_inactivacion;
            $nominaRPL->estado_inactivacion = $asesor->estado_inactivacion;
            $nominaRPL->comentarios_inactivacion = $asesor->comentarios_inactivacion;
            $nominaRPL->regularizacion_consideracion = $asesor->regularizacion_consideracion;
            $nominaRPL->regularizacion_inactivacion = $asesor->regularizacion_inactivacion;
            $nominaRPL->fecha_aprobacion_consideracion = $asesor->fecha_aprobacion_consideracion;
            $nominaRPL->fecha_aprobacion_inactivacion = $asesor->fecha_aprobacion_inactivacion;
            $nominaRPL->porcentaje_objetivo = $asesor->porcentaje_objetivo;
            $nominaRPL->cambio_jefe = $asesor->cambio_jefe;
            $nominaRPL->fecha_cambio_jefe = $asesor->fecha_cambio_jefe;

            $nominaRPL->save();
            $this->info($nominaRPL ? 'ok' : 'not ok');
        }
    }
}
