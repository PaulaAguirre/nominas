<?php

namespace App\Exports;

use App\NominaDirecta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class NominaDirectaExport implements FromView
{

    use Exportable;
    /**
     * NominaDirectaExport constructor.
     */
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
        $personas = NominaDirecta::where('estado_consideracion', '=', 'aprobado')
            ->whereBetween('updated_at', [$this->fecha_inicial, $this->fecha_final])->get();

        return view('excel.exportar', ['personas'=>$personas]);


    }

}
