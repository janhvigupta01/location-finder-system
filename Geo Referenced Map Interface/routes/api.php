<?php

use App\Http\Controllers\Api\LocationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public route to check API status
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Geo Referenced Map Interface API is running',
    ]);
});

// Protected API routes - Authentication required
Route::middleware('auth:sanctum')->group(function () {
    // Get current authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Location API endpoints
    Route::prefix('locations')->group(function () {
        Route::get('/', [LocationApiController::class, 'index']); // GET all locations
        Route::post('/', [LocationApiController::class, 'store']); // POST create location
        Route::get('/{id}', [LocationApiController::class, 'show']); // GET single location
        Route::put('/{id}', [LocationApiController::class, 'update']); // PUT update location
        Route::delete('/{id}', [LocationApiController::class, 'destroy']); // DELETE location
        Route::get('/geojson/all', [LocationApiController::class, 'geoJson']); // GET GeoJSON format
    });

    // Category endpoints
    Route::get('/categories', [LocationApiController::class, 'getCategories']);
});
