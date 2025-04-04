<?php

use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ProfileController;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Protected admin routes using the AdminMiddleware
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // House management routes
        Route::get('/houses/create', [AdminController::class, 'createHouse'])->name('houses.create');
        Route::post('/houses', [AdminController::class, 'storeHouse'])->name('houses.store');
        Route::get('/houses/{house}/edit', [AdminController::class, 'editHouse'])->name('houses.edit');
        Route::put('/houses/{house}', [AdminController::class, 'updateHouse'])->name('houses.update');
        Route::delete('/houses/{house}', [AdminController::class, 'destroyHouse'])->name('houses.destroy');
        Route::get('/houses/deleted', [AdminController::class, 'deletedHouses'])->name('houses.deleted');
        Route::post('/houses/{house}/restore', [AdminController::class, 'restoreHouse'])->name('houses.restore');

        // Feature management routes
        Route::get('/features', [AdminController::class, 'featureIndex'])->name('features.index');
        Route::get('/features/create', [AdminController::class, 'featureCreate'])->name('features.create');
        Route::post('/features', [AdminController::class, 'featureStore'])->name('features.store');
        Route::get('/features/{feature}/edit', [AdminController::class, 'featureEdit'])->name('features.edit');
        Route::put('/features/{feature}', [AdminController::class, 'featureUpdate'])->name('features.update');
        Route::delete('/features/{feature}', [AdminController::class, 'featureDestroy'])->name('features.destroy');

        // GeoOption management routes
        Route::get('/geo-options', [AdminController::class, 'geoOptionIndex'])->name('geo-options.index');
        Route::get('/geo-options/create', [AdminController::class, 'geoOptionCreate'])->name('geo-options.create');
        Route::post('/geo-options', [AdminController::class, 'geoOptionStore'])->name('geo-options.store');
        Route::get('/geo-options/{geoOption}/edit', [AdminController::class, 'geoOptionEdit'])->name('geo-options.edit');
        Route::put('/geo-options/{geoOption}', [AdminController::class, 'geoOptionUpdate'])->name('geo-options.update');
        Route::delete('/geo-options/{geoOption}', [AdminController::class, 'geoOptionDestroy'])->name('geo-options.destroy');
    });
});

// Regular routes
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/over-oostenrijk', function () {
    return view('pages.over-oostenrijk');
})->name('over-oostenrijk');

Route::get('/aanbod', [FilterController::class, 'filterHouses'])->name('aanbod');

Route::get('/detail/{id}', function ($id) {
    return view('pages.detail', compact('id'));
})->name('detail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';