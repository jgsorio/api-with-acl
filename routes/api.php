<?php

use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json(['message' => 'ok']));

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permissions/{id}', [PermissionController::class, 'show'])->name('permissions.show');
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
