<?php

namespace App\Exports;

use App\NominaDirecta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class NominaDirectaZonalExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $zonas = auth()->user()->zonas->pluck('id')->toArray();
        $fecha1 = new Carbon('first day of this month');
        $fecha2 = (new Carbon('first day of this month'))->addDays(22);
        $fecha_actual = Carbon::now();

            //$mes = Carbon::now()->addMonth(1)->format('Ym');
            $mes = 202003;
            $personas = NominaDirecta::where('mes', '=', $mes)
                ->get();


        return view('excel.exportar_x_zona', ['zonas'=>$zonas, 'personas'=>$personas]);
    }
}
