<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MotorcycleController;
use App\Http\Controllers\Admin\MotorcycleImageController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Customer - No Auth Required)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{id}', [CatalogController::class, 'show'])->whereNumber('id')->name('catalog.show');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Employee Admin Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Motorcycles Inventory Management
    Route::resource('motorcycles', MotorcycleController::class);

    // Motorcycle Image Management
    Route::delete('/motorcycle-images/{image}', [MotorcycleImageController::class, 'destroy'])->name('images.destroy');
    Route::patch('/motorcycle-images/{image}/primary', [MotorcycleImageController::class, 'setPrimary'])->name('images.setPrimary');
});

// Auth Routes (Login, Logout)
require __DIR__ . '/auth.php';
