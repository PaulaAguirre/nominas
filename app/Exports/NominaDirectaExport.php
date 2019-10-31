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
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $fecha1 = new Carbon('first day of this month');
        $fecha2 = (new Carbon('first day of this month'))->addDays(21);
        $fecha_actual = Carbon::now();

        if ($fecha_actual->between($fecha1, $fecha2))
        {
            $mes = Carbon::now()->format('Ym');
            $personas = NominaDirecta::where('mes', '=', $mes)
                ->get();
        }
        else
        {
            //$mes = Carbon::now()->addMonth(1)->format('Ym');
            $mes = 201911;
            $personas = NominaDirecta::where('mes', '=', $mes)
                ->get();
        }

        return view('excel.exportar', ['personas'=>$personas]);


    }

}
