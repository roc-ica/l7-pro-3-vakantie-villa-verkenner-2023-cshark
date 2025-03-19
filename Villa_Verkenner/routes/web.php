<?php

use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/over-oostenrijk', function () {
    return view('pages.over-oostenrijk');
})->name('over-oostenrijk');

Route::get('/aanbod', function (Request $request) {
    try {
        $query = House::query();

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int)$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int)$request->max_price);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('features')) {
            $selectedFeatures = $request->features;
            if (!is_array($selectedFeatures)) {
                $selectedFeatures = [$selectedFeatures];
            }
            $selectedFeatures = array_map('intval', $selectedFeatures);
            $query->whereHas('features', function ($q) use ($selectedFeatures) {
                $q->whereIn('feature.id', $selectedFeatures);
            });
        }

        if ($request->filled('geoOptions')) {
            $selectedGeoOptions = $request->geoOptions;
            if (!is_array($selectedGeoOptions)) {
                $selectedGeoOptions = [$selectedGeoOptions];
            }
            $selectedGeoOptions = array_map('intval', $selectedGeoOptions);
            $query->whereHas('geoOptions', function ($q) use ($selectedGeoOptions) {
                $q->whereIn('geo_option.id', $selectedGeoOptions);
            });
        }

        $houses = $query->with(['features', 'geoOptions'])->get();
        $allFeatures = Feature::all();
        $allGeoOptions = GeoOption::all();

        if ($request->ajax()) {
            $view = view('partials.houses', compact('houses'))->render();
            return response()->json(['html' => $view]);
        }

        return view('pages.aanbod', compact('houses', 'allFeatures', 'allGeoOptions'));
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        if ($request->ajax()) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        abort(500, $e->getMessage());
    }
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
