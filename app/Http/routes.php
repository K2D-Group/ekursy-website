<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/kurs/{course}/{version}/{page?}', [
    'as' => 'course',
    'uses' => 'Frontend\CoursesController@index'
])->where('page', '(.*)');




Route::get('/', 'WelcomeController@index');


//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);



//AUTORYZACJA
//// Rejestracja
//Route::get('/rejestracja.html', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
//Route::post('/rejestracja.html', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@postRegister']);
//Route::get('/aktywuj/{mailhash}/{token}.html', ['as' => 'auth.activate', 'uses' => 'Auth\AuthController@getActivate']);
// Logowanie
Route::get('/logowanie/', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/logowanie/', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
// Wylogowywanie
Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
// Resetowanie hasła
//Route::get('/zapomnialem-hasla.html', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
//Route::post('/zapomnialem-hasla.html', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@postEmail']);
//Route::get('/reset-hasla/{token?}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
//Route::post('/reset-hasla/{token?}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);

// Logowanie BitBucket i Facebook
Route::get('/logowanie/{social_provider}', ['as' => 'auth.login.social.redirect', 'uses' => 'Auth\AuthController@socialLogin'])
    ->where('social_provider', 'bitbucket|facebook');
Route::get('/logowanie/{social_provider}/redirect', ['as' => 'auth.login.social', 'uses' => 'Auth\AuthController@socialLoginCallback'])
    ->where('social_provider', 'bitbucket|facebook');
