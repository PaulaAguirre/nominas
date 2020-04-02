<?php

namespace App\Exports;

use App\NominaDirectaRPL;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;


class NominaDirectaAnteriorZonalExport implements FromView
{
    use Exportable;

    /**
     * @return View
     * Exporta a excel la nomina del mes anterior para los zonales
     *
     */

    public function view(): View
    {
        $zonasZonal = \Auth::user()->zonas->pluck('id')->toArray();
        $mes = \Config::get('global.mes_anterior');

        $personas = NominaDirectaRPL::zonasZonales($zonasZonal)->where('mes', $mes)->get();
    }
}
