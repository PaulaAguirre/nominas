<?php

namespace App\Exports;

use App\NominaDirecta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NominaDirectaExport implements FromView
{

    use Exportable;
    /**
     * NominaDirectaExport constructor.
     */
    public function __construct($mes)
    {
        $this->mes = $mes;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        return view('excel.exportar', ['personas'=>NominaDirecta::all()->where('mes', '=', $this->mes)]);

        //$nominas= NominaDirecta::all()->where('mes', '=', $this->mes);
        //return $nominas;
    }

}
