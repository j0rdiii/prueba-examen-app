<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/Flights', [FlightController::class, 'index']);
Route::get('/Flights/{id}', [FlightController::class, 'show']);
//Route::post('/Flights', [FlightController::class, 'store']);
//Route::post('/Flights', [FlightController::class, 'storeBodyReq']);
Route::post('/Flights', [FlightController::class, 'storeBodyReqClasse'])->middleware('auth:sanctum');
//Route::post('/Flights', [FlightController::class, 'storeBodyReqClasse1'])->middleware('auth:sanctum');
//Route::post('/Flights', [FlightController::class, 'storeBodyReqClasse2'])->middleware('auth:sanctum');
Route::put('/Flights/{id}', [FlightController::class, 'update']);
Route::delete('/Flights/{id}', [FlightController::class, 'destroy']);
