<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});


Route::middleware(['web', 'throttle:global'])->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/user.php';
    require __DIR__ . '/dashboard.php';
});
