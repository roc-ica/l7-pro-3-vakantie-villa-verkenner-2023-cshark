<?php

use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/over-oostenrijk', function () {
    return view('pages.over-oostenrijk');
})->name('over-oostenrijk');

Route::get('/aanbod', function (Request $request) {
    $query = House::query();

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->filled('features')) {
        $selectedFeatures = $request->features;
        $query->whereHas('features', function($q) use ($selectedFeatures) {
            // Use singular table name since join is on `feature`
            $q->whereIn('feature.id', $selectedFeatures);
        });
    }

    if ($request->filled('geoOptions')) {
        $selectedGeoOptions = $request->geoOptions;
        $query->whereHas('geoOptions', function($q) use ($selectedGeoOptions) {
            $q->whereIn('geo_option.id', $selectedGeoOptions);
        });
    }

    $houses = $query->with(['features', 'geoOptions'])->get();
    $allFeatures = Feature::all();
    $allGeoOptions = GeoOption::all();

    return view('pages.aanbod', compact('houses', 'allFeatures', 'allGeoOptions'));
})->name('aanbod');

Route::get('/detail/{id}', function ($id) {
    return view('pages.detail', compact('id'));
})->name('detail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
