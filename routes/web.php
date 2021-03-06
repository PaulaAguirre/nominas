<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    if (Auth::check())
    {
        if (Auth::user()->hasRoles(['tigo_people_admin']))
        {
            return redirect('index');
        }
        elseif (Auth::user()->hasRoles(['analista']))
        {
            return redirect('reportes_canales');
        }
        else
        {
            if (Auth::user()->hasCanales(['tiendas']))
            {
                return redirect('nomina_tienda');
            }
            elseif (Auth::user()->hasCanales(['directa']))
            {
                return redirect('nomina_tienda');
            }
            elseif (!Auth::user()->hasCanales(['directa','tiendas','indirecta']))
            {
                return redirect('nomina_directa');
            }
            elseif (Auth::user()->hasCanales(['indirecta']))
            {
                return redirect('nomina_indirecta');
            }

        }

    }
    else
    {
        return redirect ('login');
    }
});

Auth::routes();


Route::group (['middleware'=>'auth'], function () {

    Route::get('index', function ()
    {
        return view('sys.index');
    })->name('sys.index')->middleware('roles:tigo_people_admin');

    Route::resource('users', 'UserController');

    /**
     * Persona directa
     * */
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('representantes_directa', 'PersonaDirectaController');
    Route::get('representantes_directa/aprobacion_estructura/{mes}', 'PersonaDirectaController@aprobarCambioEstructura')
        ->name('representantes_directa.aprobarCambioEstructura');
    Route::patch('representantes_directa/aprobacion_estructura/{mes}', 'PersonaDirectaController@aprobarCambioEstructuraStore')
        ->name('representantes_directa.aprobarCambioEstructuraStore');
    Route::get('representantes_directa/regularizar_estructura/{persona}', 'PersonaDirectaController@regularizarEstructura')
        ->name('representantes_directa.regularizar_estructura');
    Route::patch('representantes_directa/regularizar_estructura/{persona}', 'PersonaDirectaController@regularizarEstructuraStore')
        ->name('representantes_directa.regularizarEstructuraStore');
    Route::resource('horarios', 'HorarioDirectaController');

    /**
     * Nomina directa
     * */
    Route::resource('nomina_directa', 'NominaDirectaController');
    Route::get('nomina_directa_consideraciones/{nomina_directum}', 'NominaDirectaController@agregarConsideraciones')
        ->name('nomina_directa_consideraciones.agregarconsideraciones');
    Route::patch('nomina_directa_consideraciones/{nomina_directum}', 'NominaDirectaController@storeConsideraciones')
        ->name('nomina_directa.storeconsideraciones');

    Route::get('aprobacion_nomina_directa/{mes}', 'NominaDirectaController@aprobarNomina')
        ->name('nomina_directa.aprobacion');
    Route::patch('aprobacion_nomina_directa/{mes}', 'NominaDirectaController@aprobarNominaStore')
        ->name('nomina_directa_aprobacion.aprobacion');

    Route::get('aprobar_inactivaciones', 'NominaDirectaController@aprobarInactivaciones')
        ->name('nomina_directa.inactivacion');
    Route::patch('aprobar_inactivaciones', 'NominaDirectaController@aprobarInactivacionesStore')
        ->name('nomina_directa.inactivacion_store');
    Route::get('ingresar_nuevo_asesor', 'NominaDirectaController@ingresarAsesorMesActual')
        ->name('ingresar_nuevo_asesor');
    Route::patch('ingresar_nuevo_asesor_store', 'NominaDirectaController@ingresarAsesorMesActualStore')
        ->name('ingresar_nuevo_asesor_store');


    /**Consideraciones directa* */
    Route::resource('consideraciones_directa', 'ConsideracionesDirectaController');
    Route::get('aprobacion_consideraciones_directa/{mes}', 'ConsideracionesDirectaController@aprobarConsideraciones')//ruta para cargar las consideraciones de un asesor
    ->name('consideraciones_directa.aprobacion');//ruta para mostrar las consideraciones a aprobar
    Route::patch('aprobacion_consideraciones_directa/{mes}', 'ConsideracionesDirectaController@storeConsideraciones')
        ->name('consideraciones_directa_aprobacion.aprobacion'); //ruta para guardar estado de consideración

    Route::patch('consideraciones_directa_edit/{id}', 'ConsideracionesDirectaController@updateEstado')
        ->name('consideraciones_directa_edit'); //ruta para editar el estado

    Route::patch('consideraciones_directa_update_consideracion/{id}', 'ConsideracionesDirectaController@updateConsideracion')
        ->name('consideraciones_directa_edit_consideracion'); //ruta para editar el estado

    /**
     * Inactivaciones directa
     * */
    Route::resource('inactivaciones_directa', 'InactivacionesDirectaController');
    Route::patch('inactivaciones_directa_update/{id}', 'InactivacionesDirectaController@updateInactivacion')
        ->name('inactivaciones_directa_edit_inactivacion'); //ruta para editar la inactivacion
    Route::patch('inactivaciones_directa_edit_estado/{id}', 'InactivacionesDirectaController@updateEstado')
        ->name('inactivaciones_directa_edit'); //ruta para editar el estado

    /**Segundo mes*/
    Route::resource('segundo_mes', 'SegundoMesDirectaController');

    /**coordinadores directa*/
    Route::resource('coordinadores', 'CoordinadoresController');
    /**reportes*/
    Route::view('reportes_directa', 'reportes.index');
    Route::view('reportes_canales', 'analistas.reportes');

    /**----------------reapertura de nómina en mes en curso----------*/
    Route::resource('nomina_directa_mescurso', 'NominaDirectaRPLController');
    Route::resource('representantes_directa_rpl', 'PersonaDirectaRPLController');

        /**Consideraciones mes curso**/
    Route::resource('consideraciones_directa_rpl', 'ConsideracionDirectaRPLController');
    Route::patch('agregar_consideraciones_directa_mes_curso/{id}', 'ConsideracionDirectaRPLController@agregarConsideracion')
        ->name('nomina_directa_mes_curso.consideracion');
    Route::get('aprobacion_consideraciones_directa_rpl', 'ConsideracionDirectaRPLController@aprobarConsideraciones')//ruta para cargar las consideraciones de un asesor
    ->name('consideraciones_directa_rpl.aprobacion');//ruta para mostrar las consideraciones a aprobar
    Route::patch('aprobacion_consideraciones_directa_rpl', 'ConsideracionDirectaRPLController@storeConsideraciones')
        ->name('consideraciones_directa_rpl.store'); //ruta para guardar estado de consideración
    Route::patch('consideraciones_directa_rpl_update_consideracion/{id}', 'ConsideracionDirectaRPLController@updateConsideracion')
        ->name('consideraciones_directa_rpl_edit_consideracion'); //ruta para editar la consideracion ya creada
    Route::patch('consideraciones_directa_rpl_edit/{id}', 'ConsideracionDirectaRPLController@updateEstado')
        ->name('consideraciones_directa_rpl_edit'); //ruta para editar el estado de la consideracion ya aprobada o rechazada

        /**Inactivaciones Directa* mes curso*/
    Route::get('aprobar_inactivaciones_rpl', 'InactivacionDirectaRPLController@aprobarInactivaciones')
        ->name('nomina_directa_rpl.inactivacion');
    Route::patch('aprobar_inactivaciones_rpl', 'InactivacionDirectaRPLController@aprobarInactivacionesStore')
        ->name('nomina_directa_rpl.inactivacion_store');
    Route::resource('inactivaciones_directa_rpl', 'InactivacionDirectaRPLController');
    Route::patch('inactivaciones_directa_edit_rpl/{id}', 'InactivacionDirectaRPLController@updateInactivacion')
        ->name('inactivaciones_directa_edit_rpl'); //ruta para editar la inactivacion
    Route::patch('inactivaciones_directa_edit_estado_rpl/{id}', 'InactivacionDirectaRPLController@updateEstado')
        ->name('inactivaciones_directa_edit_estado_rpl'); //ruta para editar el estado
    /**
     * fin Nomina directa-----------------------------------------------------------------------------------------------
     * ----------------------------------------------------------------------------------------------------------------
     * */


        /*** Tiendas
         * todo lo referente a tiendas desde acá */

        Route::resource('asesores_tienda', 'AsesorTiendaController');
        Route::resource('asesores_tienda2', 'AsesorTiendaController2');
        Route::resource('nomina_tienda', 'NominaTiendaController');

        /**consideraciones tienda*/
        Route::patch('asesores_tienda_consideracion/{id}', 'AsesorTiendaController@agregarConsideracion')
            ->name('asesores_tienda.consideracion');
        Route::resource('consideraciones_tienda', 'ConsideracionTiendaController');
        Route::get('aprobacion_consideraciones_tienda', 'ConsideracionTiendaController@aprobarConsideraciones')//ruta para cargar las consideraciones de un asesor
        ->name('consideraciones_tienda.aprobacion');//ruta para mostrar las consideraciones a aprobar
        Route::patch('aprobacion_consideraciones_tienda', 'ConsideracionTiendaController@storeConsideraciones')
            ->name('consideraciones_tienda_aprobacion.aprobacion'); //ruta para guardar estado de consideración
        Route::patch('consideraciones_tienda_update_consideracion/{id}', 'ConsideracionTiendaController@updateConsideracion')
            ->name('consideraciones_tienda_edit_consideracion'); //ruta para editar la consideracion
        Route::patch('consideraciones_tienda_edit/{id}', 'ConsideracionTiendaController@updateEstado')
            ->name('consideraciones_tienda_edit'); //ruta para editar el estado


        /**Inactivaciones Tienda*/
        Route::resource('inactivaciones_tienda', 'InactivacionTiendaController');
        Route::get('aprobar_inactivaciones_tienda', 'InactivacionTiendaController@aprobarInactivaciones')
            ->name('nomina_tienda.inactivacion');
        Route::patch('aprobar_inactivaciones_tienda', 'InactivacionTiendaController@aprobarInactivacionesStore')
            ->name('nomina_tienda.inactivacion_store');
        Route::patch('inactivaciones_tienda_update/{id}', 'InactivacionTiendaController@updateInactivacion')
            ->name('inactivaciones_tienda_edit_inactivacion'); //ruta para editar la inactivacion
        Route::patch('inactivaciones_tienda_edit_estado/{id}', 'InactivacionTiendaController@updateEstado')
            ->name('inactivaciones_tienda_edit'); //ruta para editar el estado

    /**Tiendas*/
        Route::resource('tiendas', 'TiendaController');
    /**Teamleaders*/
        Route::resource('teamleaders', 'TeamleaderController');

    /**reportes*/
        Route::view('reportes_tienda', 'tiendas.reportes.index');
    /**supervisores*/
        Route::resource('supervisores_tienda', 'SupervisorGuiaTigoController');

    /**************Reapertura Tienda************************************/
    Route::resource('nomina_tienda_rpl', 'NominaTiendaRPLController');
    Route::resource('asesores_tienda_rpl', 'AsesorTiendaRPLController');

    /**consideraciones tienda rpl*/
    Route::patch('asesores_tienda_consideracion_rpl/{id}', 'AsesorTiendaRPLController@agregarConsideracion')
        ->name('asesores_tienda.consideracion_rpl');
    Route::resource('consideraciones_tienda_rpl', 'ConsideracionTiendaRPLController');
    Route::get('aprobacion_consideraciones_tienda_rpl', 'ConsideracionTiendaRPLController@aprobarConsideraciones')//ruta para cargar las consideraciones de un asesor
    ->name('consideraciones_tienda.aprobacion_rpl');//ruta para mostrar las consideraciones a aprobar
    Route::patch('aprobacion_consideraciones_tienda_rpl', 'ConsideracionTiendaRPLController@storeConsideraciones')
        ->name('consideraciones_tienda_aprobacion.aprobacion_rpl'); //ruta para guardar estado de consideración
    Route::patch('consideraciones_tienda_update_consideracion_rpl/{id}', 'ConsideracionTiendaRPLController@updateConsideracion')
        ->name('consideraciones_tienda_edit_consideracion_rpl'); //ruta para editar la consideracion
    Route::patch('consideraciones_tienda_edit_rpl/{id}', 'ConsideracionTiendaRPLController@updateEstado')
        ->name('consideraciones_tienda_edit_rpl'); //ruta para editar el estado

    /**Inactivaciones Tienda rpl*/
    Route::resource('inactivaciones_tienda_rpl', 'InactivacionTiendaRPLController');
    Route::get('aprobar_inactivaciones_tienda_rpl', 'InactivacionTiendaRPLController@aprobarInactivaciones')
        ->name('nomina_tienda.inactivacion_rpl');
    Route::patch('aprobar_inactivaciones_tienda_rpl', 'InactivacionTiendaRPLController@aprobarInactivacionesStore')
        ->name('nomina_tienda.inactivacion_store_rpl');
    Route::patch('inactivaciones_tienda_update_rpl/{id}', 'InactivacionTiendaRPLController@updateInactivacion')
        ->name('inactivaciones_tienda_edit_inactivacion_rpl'); //ruta para editar la inactivacion
    Route::patch('inactivaciones_tienda_edit_estado_rpl/{id}', 'InactivacionTiendaRPLController@updateEstado')
        ->name('inactivaciones_tienda_edit_rpl'); //ruta para editar el estado
    /**-------------Fin tiendas-----------------------------------------------------------------------------------------------*/

    /**
     * Indirecta*
     */
    Route::resource('asesores_indirecta', 'ImpulsadorController');
    Route::get('circuitos_auditor/{auditor_id}', 'ImpulsadorController@showCircuitos' )->name('ver_circuitos');
    Route::get('agregar_pdv/{impulsador_id}', 'ImpulsadorController@agregarPdvs')->name('agregar_pdv');
    Route::patch('agregar_pdv/{impulsador_id}', 'ImpulsadorController@agregarPdvsStore')->name('agregar_pdv_store');
    Route::get('editar_pdv/{impulsador_id}', 'ImpulsadorController@editarPdvs')->name('editar_pdv');
    Route::patch('editar_pdv/{impulsador_id}', 'ImpulsadorController@updatePdvs')->name('editar_pdv_update');
    Route::resource('nomina_indirecta', 'NominaIndirectaController');
    Route::resource('consideraciones_indirecta', 'ConsideracionIndirectaController');
    Route::resource('inactivaciones_indirecta', 'InactivacionIndirectaController');
    Route::get('aprobar_inactivaciones_indirecta', 'InactivacionIndirectaController@aprobarInactivaciones')
        ->name('nomina_indirecta.inactivacion');
    Route::patch('aprobar_inactivaciones_indirecta', 'InactivacionIndirectaController@aprobarInactivacionesStore')
        ->name('nomina_indirecta.inactivacion_store');
    Route::patch('inactivaciones_indirecta_edit_estado/{id}', 'InactivacionIndirectaController@updateEstado')
        ->name('inactivaciones_indirecta_edit'); //ruta para editar el estado
    Route::patch('inactivaciones_indirecta_update/{id}', 'InactivacionIndirectaController@updateInactivacion')
        ->name('inactivaciones_indirecta_edit_inactivacion'); //ruta para editar la inactivacion

    /**Consideraciones indirecta*/
    Route::patch('agregar_consideracion_indirecta/{id}', 'ConsideracionIndirectaController@agregarConsideracion')
        ->name('consideraciones_indirecta.agregar_consideracion');
    Route::resource('consideraciones_indirecta', 'ConsideracionIndirectaController');
    Route::get('aprobacion_consideraciones_indirecta', 'ConsideracionIndirectaController@aprobarConsideraciones')
        ->name('consideraciones_indirecta.aprobacion');
    Route::patch('aprobacion_consideraciones_indirecta', 'ConsideracionIndirectaController@storeConsideraciones')
        ->name('consideraciones_indirecta.aprobacion_store');
    Route::patch('consideraciones_indirecta_edit/{id}', 'ConsideracionIndirectaController@updateEstado')
        ->name('consideraciones_indirecta_edit'); //ruta para editar el estado
    Route::patch('consideraciones_indirecta_update/{id}', 'ConsideracionIndirectaController@updateConsideracion')
        ->name('consideraciones_edit_consideracion'); //ruta para editar la inactivacio

    /**PDVS*/
    Route::resource('pdvs', 'PdvController');
    /**CIRCUITOS*/
    Route::resource('circuitos', 'CircuitoController');

    /**calendario*/
    Route::resource('calendario', 'CalendarioController');


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//todo esto debe ir al controller
//use App\Exports\NominaDirectaExport;
//use Maatwebsite\Excel\Facades\Excel;

//Route::get('/excel', function () {
  //  return Excel::download(new NominaDirectaExport, 'nomina.xlsx');
//});
 Route::get('/excel', 'ExcelController@exportNominaDirecta'); //Descarga las Consideraciones
 Route::get('/excel_nuevos_ingresos', 'ExcelController@exportNuevosIngresos'); //descarga los nuevos ingresos
 Route::get('/generar', 'ExcelController@index');
 Route::get('/exportar_consideraciones', 'ExcelController@exportConsideracionesController');
 Route::get('/nomina_x_zona', 'ExcelController@exportarNominaXZonalController');

 /**excel tiendas*/
Route::get('/excel_tienda', 'ExcelController@exportNominaTienda');
Route::get('/excel_tienda_rpl', 'ExcelController@exportarNominaTiendaMesAnterior');
Route::get('/excel_tienda_x_zona', 'ExcelController@exportNominaTiendaxZona');
/**excel reapertura*/
Route::get('/excel_directa_mes_anterior', 'ExcelController@exportarDirectaMesAnterior');

/**Excel indirecta*/
Route::get('/excel_indirecta', 'ExcelController@exportarNominaIndirecta');
Route::get('/pdas_indirecta', 'ExcelController@exportarPdas');
Route::get('/circuitos_auditores', 'ExcelController@exportarAuditoresCircuitos');

Route::get('variable', function ()
{
    dd(config('global.mes'));
});



