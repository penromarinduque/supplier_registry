<?php

use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\TimeInController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/time-in', [TimeInController::class, 'index'])->name('timein');
Route::get('/time-in/show', [TimeInController::class, 'show'])->name('timein.show');

Route::group(['prefix' => 'time-entries', 'as' => 'timeEntries.'], function () {
    Route::post('', [TimeEntryController::class, 'store'])->name('store');
    Route::get('print-dtr', [TimeEntryController::class, 'printDtr'])->name('printDtr');
});

Route::group(['prefix' => 'accomplishments', 'as' => 'accomplishments.'], function () {
    Route::post('', [AccomplishmentController::class, 'store'])->name('store');
    Route::get('edit/{id}', [AccomplishmentController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [AccomplishmentController::class, 'update'])->name('update');
    Route::delete('{id}', [AccomplishmentController::class, 'delete'])->name('delete');
    Route::get('download-file/{id}', [AccomplishmentController::class, 'downloadFile'])->name('downloadFile');
    Route::delete('delete-file/{id}', [AccomplishmentController::class, 'deleteFile'])->name('deleteFile');
});

Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
    Route::post('', [TaskController::class, 'store'])->name('store');
    Route::get('edit/{id}', [TaskController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [TaskController::class, 'update'])->name('update');
    Route::delete('{id}', [TaskController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'storages', 'as' => 'storage.'], function () {
    Route::get('view-image/{filename}', [AccomplishmentController::class, 'viewImage'])->name('viewImage');
    
});

Route::get('/user-guide', function (Request $request) { return view('user-guide', [
    'title' => 'User Guide',
    'division' => $request->input('division'),
]); })->name('userGuides');