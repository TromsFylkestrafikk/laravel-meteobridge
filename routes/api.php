<?php

use Illuminate\Support\Facades\Route;
use TromsFylkestrafikk\Meteobridge\Http\Controllers\ObservationController;

Route::get('observe/{station}', [ObservationController::class, 'register'])->name('meteobridge.observe');
