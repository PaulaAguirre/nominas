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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('representantes_directa', 'PersonaDirectaController');

/**
 * Nomina directa
 * */
Route::resource('nomina_directa', 'NominaDirectaController');

Route::get('nomina_directa_consideraciones/{nomina_directum}', 'NominaDirectaController@agregarConsideraciones')->name('nomina_directa_consideraciones.agregarconsideraciones');
Route::patch('nomina_directa_consideraciones/{nomina_directum}', 'NominaDirectaController@storeConsideraciones')->name('nomina_directa.storeconsideraciones');
Route::get('aprobacion_nomina_directa/{mes}', 'NominaDirectaController@aprobarNomina')->name('nomina_directa.aprobacion');
Route::patch('aprobacion_nomina_directa/{mes}', 'NominaDirectaController@aprobarNominaStore')->name('nomina_directa_aprobacion.aprobacion');

Route::resource('consideraciones_directa', 'ConsideracionesDirectaController');
//Route::resource('aprobacion_representantes_directa', 'RepresentanteMesDirectaController');

/**
 * fin Nomina directa
 * */



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
