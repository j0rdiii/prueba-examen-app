<?php

use App\Http\Controllers\FlightController;
use App\Http\Controllers\FlightControllerWebRoutes;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('Flights', FlightControllerWebRoutes::class);
Route::get('/Flights', [FlightControllerWebRoutes::class, 'getFlightsFromAPI']);
Route::get('/Flight/{id}', [FlightControllerWebRoutes::class, 'getFlightByIdFromAPI']);
Route::get('/FlightToDestroy/{id}', [FlightControllerWebRoutes::class, 'destroyFlightByIdFromAPI']);
Route::get('/FlightToUpdate/{id}', [FlightControllerWebRoutes::class, 'updateFlightByIdFromApi']);
Route::get('/FlightToCreate', [FlightControllerWebRoutes::class, 'createFlightWithJsonBodyReqFromApi']);
Route::get('/FlightToCreateFull', [FlightControllerWebRoutes::class, 'createFlightWithBearerJsonBodyReqFromApi']);

require __DIR__.'/auth.php';
