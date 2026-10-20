<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
| Security Token AWT Api
*/
Route::post('login', 'Security\AuthController@authenticate');

Route::post('debug-log', function(Request $request) {
    \Log::info('CLIENT_DEBUG: ' . json_encode($request->all()));
    return response()->json(['status' => 'ok']);
});

/*
| Prefix Api
*/
Route::group(['prefix' => 'convocatoria', 'as' => 'convocatoria.'], function() {
	Route::resource('informe', 'Convocatoria\InformeController', ['only' => ['show']]);
});

Route::resource('comunidad', 'ComunidadController', ['only' => ['index']]);
Route::resource('curso', 'CursoController', ['only' => ['index']]);
Route::resource('blog', 'BlogController', ['only' => ['index']]);
Route::resource('evento', 'EventoController', ['only' => ['index']]);
Route::resource('foro', 'ForoController', ['only' => ['index','show']]);
// Route::resource('voto', 'Voto\VotoController', ['only' => ['store']]);
Route::group(['prefix' => 'voto', 'as' => 'voto.'], function() {
	Route::post('resend', ['as' => 'resend', 'uses' => 'Voto\VotoController@resend']);
	Route::post('verifycode', ['as' => 'verifycode', 'uses' => 'Voto\VotoController@verifycode']);
});

Route::group(['middleware' => ['jwt.verify']], function() {
	Route::resource('user', 'User\UserController', ['only' => ['store']]);
	Route::resource('voto', 'Voto\VotoController', ['only' => ['store']]);
});

Route::get('/debug-config', function() { return [ 'port' => config('database.connections.pgsql.port'), 'db' => config('database.connections.pgsql.database') ]; });
