<?php

use Illuminate\Support\Facades\Route;
use TromsFylkestrafikk\Meteobridge\Http\Controllers\ObservationController;

Route::get('station/{station}/observation/add/{hash}', [ObservationController::class, 'register'])->name('meteobridge.station.observation.add');
Route::get('station/{station}/observation/latest', [ObservationController::class, 'latest'])->name('meteobridge.station.observation.latest');
