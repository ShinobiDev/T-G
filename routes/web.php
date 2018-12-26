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

Route::auth();
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', function(){
	return view('admin.panel');
});


Route::group(['prefix'=>'trabajos','namespace'=>'Trabajos','middleware'=>'auth'], function(){

    //Rutas de las ordenes
    Route::get('ordenes/crear','OrdenesController@crear')->name('ordenes.crear'); 

    //Rutas de las sedes
    Route::get('sedes','SedesController@index')->name('sedes.index');
    Route::get('sedes/crear','SedesController@crear')->name('sedes.crear');
    Route::post('sedes/almacenar','SedesController@almacenar')->name('trabajos.sedes.almacenar');
    Route::post('sedes/{sede_id}','SedesController@actualizar')->name('trabajos.sedes.update');

    //Variables Editables -----------------------------------------------------------
    Route::get('variables', 'VariableController@index')->name('variables.index');
    Route::post('variables/{variable_id}', 'VariableController@update')->name('trabajos.variables.update');

});






/*Rutas de autenticación del metodo Auth -------------------------------------------------------------------*/
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register/almacenarUsuario', 'Auth\RegisterController@almacenarUsuario')->name('almacenarUsuario');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');