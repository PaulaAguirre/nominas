<?php

namespace App\Exports;

use App\NominaDirecta;
use App\PersonaDirecta;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class NuevosIngresosDirectaExport implements FromView
{
    public $fecha_inicial;
    public $fecha_final;

    public function __construct($fecha_inicial, $fecha_final)
    {
        $this->fecha_inicial = Carbon::createFromFormat('d/m/Y', $fecha_inicial);
        $this->fecha_final = Carbon::createFromFormat('d/m/Y', $fecha_final);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view():View
    {
        $mes_nomina = Carbon::now()->format('Ym');
        $representantes_existentes = NominaDirecta::where('mes', $mes_nomina)
            ->get()->pluck('id_persona_directa')->toArray();

        $personas = PersonaDirecta::whereNotIn('id_persona', $representantes_existentes)
            ->where('activo', '=', 'activo')->where('cargo', '=', 'representante')
            ->whereBetween('created_at',[$this->fecha_inicial, $this->fecha_final])->get();

        return view('excel.exportar_nuevos_ingresos', ['personas'=>$personas]);

    }
}
