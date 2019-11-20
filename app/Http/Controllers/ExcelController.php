<?php

namespace App\Http\Controllers;

use App\Exports\NominaTiendaZonalExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\NominaDirecta;
use App\Exports\NominaDirectaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NuevosIngresosDirectaExport;
use App\Exports\ConsideracionesExport;
use App\Exports\NominaDirectaZonalExport;
use App\Exports\NominaTiendaExport;

class ExcelController extends Controller
{
    public function index(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicial');
        $personas = NominaDirecta::where('mes', '=', '201909')->get();
        return view('reportes.index');
        //return view('excel.nomina_directa', ['personas'=>$personas, 'fecha_inicio'=>$fecha_inicio]);
    }

    /**
    *Exporta las consideraciones
     */
    public function exportNominaDirecta(Request $request)
    {

        $mes=Carbon::now()->format('Ym');
        //$fecha_inicial = $request->get('fecha_inicial');
        //$fecha_final = $request->get('fecha_final');
        return Excel::download(new NominaDirectaExport(), 'nomina_directa.xlsx');
    }

    public function exportNuevosIngresos(Request $request)
    {
        $mes=Carbon::now()->format('Ym');
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        return Excel::download(new NuevosIngresosDirectaExport($fecha_inicial,$fecha_final), 'nuevos_ingresos.xlsx');
    }

    public function exportConsideracionesController(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');
        return Excel::download(new ConsideracionesExport($fecha_inicial, $fecha_final), 'consideraciones_directa.xlsx');
    }

    public function exportBajasController(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

    }

    public function exportarNominaXZonalController(Request $request)
    {
        return Excel::download(new NominaDirectaZonalExport(), 'nomina_x_zona.xlsx');
    }

    public function exportNominaTienda(Request $request)
    {
        return Excel::download(new NominaTiendaExport(), 'nomina_tienda.xlsx');
    }

    public function exportNominaTiendaxZona(Request $request)
    {
        return Excel::download(new NominaTiendaZonalExport(), 'nomina_zona.xlsx');
    }
}
