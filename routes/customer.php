<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\RequestController;

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('dashboard',       [DashboardController::class, 'index'])->name('dashboard');
    Route::get('center',          [DashboardController::class, 'center'])->name('center');
    Route::get('board',          [DashboardController::class, 'board'])->name('board');
    Route::get('requests',        [RequestController::class, 'index'])->name('requests');
    Route::get('requests/{conversation}', [RequestController::class, 'show'])->name('requests.show');
    Route::post('requests/{conversation}/message', [RequestController::class, 'sendMessage'])->name('requests.message');
    Route::get('favourites',      [DashboardController::class, 'favourites'])->name('favourites');
    
});