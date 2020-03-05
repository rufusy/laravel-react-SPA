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

// Named route required for SendPasswordResetEmails
Route::get('reset-password', function(){
    return view('index');
})->name('password.reset');


// Catch all other web routes
Route::get('{any}', function($any){
    return view('index');
})->where('any', '^(?!api).*$');