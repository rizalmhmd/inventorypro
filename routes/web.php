<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Inventory routes
    Route::get('/categories', function () {
        return view('categories.index');
    })->name('categories.index');
    
    Route::get('/suppliers', function () {
        return view('suppliers.index');
    })->name('suppliers.index');
    
    // Products routes
    Route::get('products', [ProductController::class,'index'])->name('products.index');
    Route::get('products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('products', [ProductController::class,'store'])->name('products.store');
    Route::get('products/{product}', [ProductController::class,'show'])->name('products.show');
    Route::get('products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class,'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class,'destroy'])->name('products.destroy');

    // Stock routes
    Route::get('stock/in', [StockController::class,'inForm'])->name('stock.in.form');
    Route::post('stock/in', [StockController::class,'storeIn'])->name('stock.in');
    Route::get('stock/out', [StockController::class,'outForm'])->name('stock.out.form');
    Route::post('stock/out', [StockController::class,'storeOut'])->name('stock.out');

    // Reports
    Route::get('reports', [ReportController::class,'index'])->name('reports.index');
});

require __DIR__.'/auth.php';