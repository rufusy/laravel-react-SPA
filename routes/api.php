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

// Auth Endpoints
Route::group([
    'prefix' => 'v1/auth'
], function($router){
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@email')->name('forgotPassword');
    Route::post('password-reset', 'Auth\ResetPasswordController@reset')->name('passwordReset');

    // Protected endpoints
    Route::group([
        'middleware' => 'jwt.auth',
    ], function($router){
        Route::post('me', 'Auth\ProfileController@me')->name('profile.me');
        Route::post('logout', 'Auth\LogoutController@logout')->name('logout');
    });

});


// Resource Endpoints
Route::group([
    'prefix' => 'v1'
], function($router){
    Route::get('articles', 'ArticleController@index')->name('article.index');
    Route::resource('article', 'ArticleController')->only(['show']);

    // Protected endpoints
    Route::group([
        'middleware' => 'jwt.auth', 
    ], function($router){
        Route::resource('article', 'ArticleController')->only(['store', 'update', 'destroy']);
    });

});


// Not Found
Route::fallback(function(){
    return response()->json(['message' => 'Resource Not Found.'], 404);
});