<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::resource('pages', 'PageController', ['except' => ['create', 'destroy', 'update']]);
    Route::post('pages/{id}/components', 'ComponentController@store')->name('components.store');
    Route::put('pages/{id}/components', 'ComponentController@update')->name('components.update');
    Route::delete('pages/{id}/components', 'ComponentController@destroy')->name('components.destroy');
});