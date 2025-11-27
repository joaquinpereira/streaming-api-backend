<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Agrupación para la versión 1 de la API (/api/v1)
Route::prefix('v1')->group(function () {

    // Rutas del Módulo 1: Autenticación y Acceso (Endpoints Públicos)
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('register', 'register'); // POST /api/v1/auth/register
        Route::post('login', 'login');       // POST /api/v1/auth/login
    });

    // Rutas del Módulo 1: Autenticación (Endpoints Protegidos)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Logout
        Route::post('auth/logout', [AuthController::class, 'logout']); // POST /api/v1/auth/logout
        
        // Perfil de usuario autenticado 
        Route::get('user/profile', function (Request $request) {
            return response()->json($request->user());
        });

    });
});
