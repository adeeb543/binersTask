<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardProjectController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)
->prefix('login')
->group(function () {
    Route::get('/',  'showLoginForm')->name('login');
    Route::post('/', 'login');
});


Route::controller(DashboardProjectController::class)
->middleware(['auth:admin'])
->prefix('projects')
->name('projects.')
->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('/{id}/status', 'updateStatus')->name('updateStatus');

});
