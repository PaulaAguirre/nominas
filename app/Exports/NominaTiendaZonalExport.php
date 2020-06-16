<?php
/**
 * Copyright (c) 2019
 */

namespace App\Exports;

use App\NominaTienda;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class NominaTiendaZonalExport implements FromView
{
    use Exportable;
    /**
    * @return View
    */
    public function view():View
    {
        $zonas = auth()->user()->zonasTienda->pluck('id')->toArray();
        $mes = \Config::get('global.mes_tienda');
        $asesores = NominaTienda::where('mes', $mes)->get();
        return view('excel_tienda.exportar_x_zona', ['asesores'=>$asesores, 'zonas'=>$zonas]);
    }
}
