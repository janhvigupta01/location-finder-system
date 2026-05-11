<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Language switching
Route::get('/language/{language}', function ($language) {
    session(['locale' => $language]);
    return back();
})->name('set-language');

// Protected routes - Authentication required
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Locations - CRUD
    Route::resource('locations', LocationController::class);

    // Map
    Route::get('/map', [MapController::class, 'index'])->name('map');
    Route::get('/api/geojson', [MapController::class, 'getGeoJson'])->name('geojson');
});

require __DIR__.'/auth.php';