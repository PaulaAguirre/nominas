<?php

namespace App\Http\Controllers;

use App\ArchivoTienda;
use Illuminate\Http\Request;
use App\NominaTienda;
class ConsideracionTiendaController extends Controller
{
    public function agregarConsideracion(Request $request, $id)
    {
        $asesor = NominaTienda::findOrFail($id);
        dd($asesor);
        $asesor->id_consideracion = $request->get('id_consideracion');
        $asesor->detalles_consideracion = $request->get('detalles_consideracion');
        $asesor->estado_consideracion = 'pendiente';


        $asesor->update();
        return redirect()->back();
    }
}
