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

// Auth::routes();

// Route::resource('reset_pass', 'ResetPasswordController');

// Route::get('/reset_pass', function () {
//     return view('reset_password');
// });

Route::get('reset_pass', 'ResetPasswordController@index')->name('reset_pass.index');
