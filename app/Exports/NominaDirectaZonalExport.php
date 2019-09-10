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
        $mes = Carbon::now()->format('Ym');
        $zonas = auth()->user()->zonas->pluck('id')->toArray();
        $personas = NominaDirecta::where('mes', $mes)->get();

        return view('excel.nomina_directa_zonal', ['zonas'=>$zonas, 'personas'=>$personas]);
    }
}
