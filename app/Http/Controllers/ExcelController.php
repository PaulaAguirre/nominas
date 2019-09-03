<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\NominaDirecta;
use App\Exports\NominaDirectaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NuevosIngresosDirectaExport;

class ExcelController extends Controller
{
    public function index(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicial');
        $personas = NominaDirecta::where('mes', '=', '201909')->get();
        return view('excel.nomina_directa', ['personas'=>$personas, 'fecha_inicio'=>$fecha_inicio]);
    }

    /**
    *Exporta las consideraciones
     */
    public function exportNominaDirecta(Request $request)
    {

        $mes=Carbon::now()->format('Ym');
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');
        return Excel::download(new NominaDirectaExport($fecha_inicial,$fecha_final), 'consideraciones.xlsx');
    }

    public function exportNuevosIngresos(Request $request)
    {
        $mes=Carbon::now()->format('Ym');
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        return Excel::download(new NuevosIngresosDirectaExport($fecha_inicial,$fecha_final), 'nuevos_ingresos.xlsx');
    }

}
