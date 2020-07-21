<?php

namespace App\Exports;

use App\NominaTienda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class NominaTiendaExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $mes = \Config::get('global.mes_tienda');
        $asesores = NominaTienda::where('mes', $mes)->especialista('no')->get();
        return view('excel_tienda.exportar', ['asesores'=>$asesores]);
    }
}
