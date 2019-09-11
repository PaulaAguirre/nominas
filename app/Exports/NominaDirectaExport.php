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
        $fecha_actual = Carbon::today();
        $fecha_fin = (new Carbon('first day of this month'))->addDays(25);

        $mes = Carbon::now()->format('Ym');
        $personas = NominaDirecta::where('mes', '=', $mes)
            ->get();

        return view('excel.exportar', ['personas'=>$personas]);


    }

}
