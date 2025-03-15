<?php

use App\Http\Controllers\IncidentFormController;
use Illuminate\Support\Facades\Route;

// Show the incident report form
Route::get('/report', [IncidentFormController::class, 'create'])->name('report.create');

// Store submitted form data
Route::post('/report', [IncidentFormController::class, 'store'])->name('report.store');

// Track an incident using the tracking number
Route::post('/track', [IncidentFormController::class, 'trackIncident'])->name('report.track');