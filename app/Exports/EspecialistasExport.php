<?php

namespace App\Exports;

use App\NominaTiendaRPL;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EspecialistasExport implements FromView
{
    use Exportable;

    /**
     * @return View
     */
    public function view():View
    {
        $mes = \Config::get('global.mes_anterior_tienda');
        $asesores = NominaTiendaRPL::where('mes', $mes)->especialista('si')->get();
        return $this->view('excel_tienda.exportar_especialistas', ['asesores'=>$asesores]);

    }
}
