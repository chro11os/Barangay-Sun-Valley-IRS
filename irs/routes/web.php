<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IncidentFormController;
use Illuminate\Support\Facades\Auth;
use App\Models\IncidentType;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [IncidentFormController::class, 'create'])->name('home');
Route::get('/app', [IncidentFormController::class, 'create'])->name('report');
Route::get('/track/search', [IncidentFormController::class, 'trackIncident'])->name('trackIncident');


Route::middleware('auth')->group(function () {
    Route::get('/incidents', [IncidentFormController::class, 'index'])->name('incidents.index');
    Route::post('/incidents', [IncidentFormController::class, 'store'])->name('incidents.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/track', function () {
    return view('track');
})->name('track'); 