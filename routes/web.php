<?php

use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\TimeInController;
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