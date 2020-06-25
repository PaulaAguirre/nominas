<?php

namespace App\Exports;

use App\Pdv;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PDAsExport implements FromView, WithTitle
{
    use Exportable;

    public function view():View
    {
        $pdvs = Pdv::all();
        return view('excel_indirecta.pdas', ['pdvs'=>$pdvs]);

    }

    public function title(): string
    {
        return 'pdas';
    }
}
