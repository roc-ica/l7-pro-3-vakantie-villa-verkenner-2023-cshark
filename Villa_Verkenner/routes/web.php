<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

Route::get('/over-oostenrijk', function () {
    return view('pages.over-oostenrijk');
})->name('over-oostenrijk');

Route::get('/aanbod', function () {
    return view('pages.aanbod');
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

require __DIR__.'/auth.php';
