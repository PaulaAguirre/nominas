<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\NominaIndirecta;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class NominaIndirectaExport implements FromView
{
    use Exportable;

    public function view():View
    {
        $mes = \Config::get('global.mes_indirecta');
        $impulsadores = NominaIndirecta::where('mes', $mes)->get();
        return view('excel_indirecta.exportar', ['impulsadores' => $impulsadores]);
    }
}
