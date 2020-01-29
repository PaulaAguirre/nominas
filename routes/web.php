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
            elseif (!Auth::user()->hasCanales(['directa','tiendas']))
            {
                return redirect('nomina_directa');
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

    /**
     * fin Nomina directa-----------------------------------------------------------------------------------------------
     * ----------------------------------------------------------------------------------------------------------------
     * */


        /*** Tiendas
         * todo lo referente a tiendas desde acá */

        Route::resource('asesores_tienda', 'AsesorTiendaController');
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

    /**-------------Fin tiendas-----------------------------------------------------------------------------------------------*/

    /**
     * Indirecta*
     */
    Route::resource('asesores_indirecta', 'ImpulsadorController');
    Route::resource('nomina_indirecta', 'NominaIndirectaController');
    Route::resource('consideraciones_indirecta', 'ConsideracionesIndirectaController');

    /**Consideraciones indirecta*/
    Route::patch('agregar_consideracion_indirecta/{id}', 'ConsideracionIndirectaController@agregarConsideracion')
        ->name('consideraciones_indirecta.agregar_consideracion');


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
Route::get('/excel_tienda_x_zona', 'ExcelController@exportNominaTiendaxZona');



