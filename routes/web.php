<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\IncidentFormController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminDashboardController;
use App\Models\IncidentType;
use App\Http\Controllers\residentDashboardController;

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

 

// Admin Dashboard
Route::get('/admin/AdminDashboard', [AdminDashboardController::class, 'index'])->name('adminDashboard');


Route::get('/', [IncidentFormController::class, 'create'])->name('home');
Route::get('/app', [IncidentFormController::class, 'create'])->name('report');
Route::get('/track/search', [IncidentFormController::class, 'trackIncident'])->name('trackIncident');
Route::get('residentDashboard', [IncidentFormController::class, 'getUserIncidents'])->name('residentDashboard');

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

//Route::middleware(['auth'])->get('/residentDashboard', [residentDashboardController::class, 'index'])->name('residentDashboard');
     

Route::get('/track', function () {
    return view('track');
})->name('track');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/AdminDashboard', [AdminDashboardController::class, 'index'])
        ->name('adminDashboard');
});


// Password Reset Link Request

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    Password::sendResetLink($request->only('email'));

    return back()->with('status', 'Reset link sent!');
})->name('password.email');
