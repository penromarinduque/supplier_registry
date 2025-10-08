<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
})->name('terms-and-conditions');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::view('login', 'auth.login')->name('login')->middleware('guest');
    Route::post('login', [AuthController::class, 'login'])->name('loginAttempt')->middleware('guest');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.'], function () {
    Route::get('register', [SupplierController::class, 'create'])->name('register');
    Route::post('store', [SupplierController::class, 'store'])->name('store');
});

Route::get('password/{password}', function ($password) {
    return bcrypt($password);
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.'], function () {
        Route::get('', [SupplierController::class, 'index'])->name('index')->middleware('auth');
        Route::delete('{supplier}', [SupplierController::class, 'destroy'])->name('destroy')->middleware('auth');
        Route::get('{supplier}', [SupplierController::class, 'show'])->name('show')->middleware('auth');
    });
});

Route::group(['prefix' => 'supplier', 'as' => 'supplier.'], function () {
    Route::get('profile', [SupplierController::class, 'profile'])->name('profile')->middleware('auth');
    Route::post('update/{id}', [SupplierController::class, 'update'])->name('update')->middleware('auth');
});

Route::get('storage/view', function (Request $request) {
    $url = $request->get('url');
    return response()->file(storage_path('app/public/' . $url));
})->name('storage.view');
