<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->prefix('auth')
    ->group(
        function (){
            Route::post('/register','register')->middleware('throttle:5,1');
            Route::post('/login','login')->middleware('throttle:5,1');
            Route::post('/logout','logout')->middleware('auth:sanctum');

        }
    );


    Route::controller(ProjectController::class)->middleware('auth:sanctum')
    ->prefix('projects')
    ->name('projects.')
    ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/',  'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
    Route::post('/{id}',  'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});
