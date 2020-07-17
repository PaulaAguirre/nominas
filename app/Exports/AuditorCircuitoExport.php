<?php

namespace App\Exports;
use App\Impulsador;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class AuditorCircuitoExport implements FromView, WithTitle
{
    use Exportable;

    /**
     * @return View
     */
    public function view():View
    {
        $auditores = Impulsador::where('clasificacion_id', '=', 3)->get();
        return view('excel_indirecta.excel_auditores_circuitos', ['auditores'=>$auditores]);

    }

    public function title(): string
    {
        return 'auditores';
    }
}
