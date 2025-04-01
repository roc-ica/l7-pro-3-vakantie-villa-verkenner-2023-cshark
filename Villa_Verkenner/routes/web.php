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

// Admin Routes - PLACE THESE FIRST
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

// Load auth routes LAST
require __DIR__ . '/auth.php';