<?php

use Illuminate\Support\Facades\Route;
use TromsFylkestrafikk\Meteobridge\Http\Controllers\ObservationController;

Route::get('observation/{station}/{hash}', [ObservationController::class, 'register'])->name('meteobridge.observation');
