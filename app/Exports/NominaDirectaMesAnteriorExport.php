<?php

namespace App\Exports;

use App\NominaDirectaRPL;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Config;

class NominaDirectaMesAnteriorExport implements FromView
{
    use Exportable;
    /**
     * @return View
     */
    public function view():View
    {
        $mes = Config::get('global.mes_anterior');
        $personas = NominaDirectaRPL::where('mes', '=', $mes)
            ->get();

        return view('excel.exportar_directa_anterior', ['personas'=>$personas]);

    }
}
