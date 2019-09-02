<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\NominaDirecta;
use App\Exports\NominaDirectaExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio');
        $personas = NominaDirecta::where('mes', '=', '201909')->get();
        return view('excel.nomina_directa', ['personas'=>$personas, 'fecha_inicio'=>$fecha_inicio]);
    }

    public function exportNominaDirecta(Request $request)
    {
        //dd($request->get('mes'));
        $mes = $request->get('mes');
        return Excel::download(new NominaDirectaExport($mes), 'nomina.xlsx');
    }

}
