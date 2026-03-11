<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
  Route::get('/profile', [UserController::class, 'profileIndex']);
  Route::post('/profile', [UserController::class, 'profileUpdate']);
});


Route::middleware(['auth', 'admin'])
  ->prefix('admin')
  ->group(function () {
    Route::get('/users', [UserController::class, 'userIndex'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'createUser'])->name('user.create');
    Route::post('/users', [UserController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroyUser'])->name('users.destroy');
  });
