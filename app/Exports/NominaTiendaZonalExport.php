<?php
/**
 * Copyright (c) 2019
 */

namespace App\Exports;

use App\NominaTienda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class NominaTiendaZonalExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $zonas = auth()->user()->zonasTienda->pluck('id')->toArray();
        $mes = 202002;
        $asesores = NominaTienda::where('mes', $mes)->get();
        return view('excel_tienda.exportar_x_zona', ['asesores'=>$asesores, 'zonas'=>$zonas]);
    }
}
