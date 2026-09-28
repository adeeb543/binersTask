<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardProjectController;
use App\Http\Controllers\Dashboard\ProjectDiscussionController;
use App\Http\Controllers\Dashboard\StudyController;
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
    Route::get('/{id}', 'show')->name('show');

    Route::post('/{id}/status', 'updateStatus')->name('updateStatus');

});



Route::controller(StudyController::class)
//->prefix('admin')
//->name('admin.')
->middleware(['auth:admin'])
->group(function () {

    // إنشاء دراسة جديدة مرتبطة بمشروع محدد
    Route::get('/projects/{project}/studies/create',  'create')->name('studies.create');
    Route::post('/projects/{project}/studies',  'store')->name('studies.store');

    // تعديل وتحديث الدراسة الحالية عبر ID الدراسة نفسها
    Route::get('/studies/{study}/edit',  'edit')->name('studies.edit');
    Route::put('/studies/{study}',  'update')->name('studies.update');

});





Route::middleware(['auth:admin'])
->group(function () {
 // مسار عرض تفاصيل المشروع (يتضمن عرض المناقشات)
 //   Route::get('/projects/{project}', [ProjectController::class, 'show'])
   //     ->name('projects.show');
   // مسار إرسال رسالة أو طلب جديد ضمن مناقشات المشروع
    Route::post('/projects/{project}/discussions', [ProjectDiscussionController::class, 'store'])
        ->name('projects.discussions.store');

    Route::delete('projects/{project}/discussions/{discussion}', [ProjectDiscussionController::class, 'destroy'])
    ->name('projects.discussions.destroy');
});
