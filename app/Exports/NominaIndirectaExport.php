<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\NominaIndirecta;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class NominaIndirectaExport implements FromView, WithTitle
{
    use Exportable;

    public function view():View
    {
        $mes = \Config::get('global.mes_indirecta');
        $clasificacion_id = 2;
        $impulsadores = NominaIndirecta::where('mes', $mes)
            ->clasificacion($clasificacion_id)
            ->get();
        return view('excel_indirecta.exportar', ['impulsadores' => $impulsadores]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'pdas';
    }
}
