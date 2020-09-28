<?php

namespace App\Exports;

use App\NominaTiendaRPL;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class NominaTiendaRPLExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $mes = \Config::get('global.mes_anterior_tienda');
        //$mes = 202008;
        $asesores = NominaTiendaRPL::where('mes', '=', $mes)->get();

        return view('excel_tienda.exportar_tienda_mes_anterior', ['asesores'=>$asesores]);
    }
}
