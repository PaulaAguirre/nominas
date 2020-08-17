<?php

namespace App\Http\Controllers;

use App\NominaDirecta;
use Illuminate\Http\Request;
use App\PersonaDirecta;
use Carbon\Carbon;

class HorarioDirectaController extends Controller
{
    public function edit ($id)
    {
        $persona = NominaDirecta::findOrFail($id);
        $dias_persona = collect(explode(", ", $persona->dias))  ;
        $dias = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES','VIERNES', 'SABADO'];

        return view('personasDirecta.agregar_horarios', ['persona'=>$persona, 'dias'=>$dias,
            'dias_persona'=>$dias_persona]);
    }

    public function update(Request $request, $id)
    {
        $persona = NominaDirecta::findOrFail($id);
        $dias = $request->get('dias');

        $persona->dias = implode(", ", $dias);
        $persona->hora_entrada = $request->get('hora_entrada');
        $persona->hora_salida = $request->get('hora_salida');

        $persona->update();
        return redirect('nomina_directa');
    }
}


