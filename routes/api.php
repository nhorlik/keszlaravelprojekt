<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\CityController;

// Bejelentkezési végpont (Token generálásához)
Route::post('/login', [AuthController::class, 'login']);

// Nyilvános olvasási (GET) végpontok
Route::get('/counties', [CountyController::class, 'index']);
Route::get('/cities', [CityController::class, 'index']);

// Védett végpontok (Csak érvényes Bearer tokennel érhetők el)
Route::middleware('auth:sanctum')->group(function () {

    // Megyék módosító műveletei
    Route::post('/counties', [CountyController::class, 'store']);
    Route::put('/counties/{id}', [CountyController::class, 'update']);
    Route::delete('/counties/{id}', [CountyController::class, 'destroy']);

    // Városok módosító műveletei
    Route::post('/cities', [CityController::class, 'store']);
    Route::put('/cities/{id}', [CityController::class, 'update']);
    Route::delete('/cities/{id}', [CityController::class, 'destroy']);
});