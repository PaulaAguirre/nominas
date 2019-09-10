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
        $mes = Carbon::now()->format('Ym');
        $personas = NominaDirecta::where('mes', '=', $mes)
            //->whereBetween('updated_at', [$this->fecha_inicial, $this->fecha_final])
            ->get();

        return view('excel.exportar', ['personas'=>$personas]);


    }

}
