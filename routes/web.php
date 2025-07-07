<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');

    Route::resource('domacinstvo', App\Http\Controllers\DomacinstvoController::class)->except('index', 'edit');

    Route::resource('radni-nalog', App\Http\Controllers\RadniNalogController::class)->except('edit');

    Route::resource('preuzeto-mleko', App\Http\Controllers\PreuzetoMlekoController::class)->only('index', 'show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
