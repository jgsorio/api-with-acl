<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/', fn () => response()->json(['message' => 'ok']));
Route::get('/unauthorized', fn () => response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED))->name('login');

Route::post('/auth', [AuthController::class, 'login'])->name('auth.login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('authorize')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{id}/permissions', [UserController::class, 'getPermissions'])->name('users.permissions.list');
        Route::post('/users/{id}/permissions', [UserController::class, 'syncPermissions'])->name('users.permissions.sync');
    });
    Route::apiResource('/permissions', PermissionController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});
