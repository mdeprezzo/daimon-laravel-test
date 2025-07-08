<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';