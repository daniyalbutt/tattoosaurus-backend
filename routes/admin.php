<?php
// routes/admin.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\TestimonialController;

// Guest (login) routes
Route::middleware('guest')->group(function () {
    Route::get('login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.attempt');
});

// Protected admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout',   [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('artists',                  [ArtistController::class, 'index'])->name('artists.index');
    Route::get('artists/{user}',           [ArtistController::class, 'show'])->name('artists.show');
    Route::patch('artists/{user}/approve', [ArtistController::class, 'approve'])->name('artists.approve');
    Route::patch('artists/{user}/reject',  [ArtistController::class, 'reject'])->name('artists.reject');
    Route::patch('artists/{user}/toggle-top',      [ArtistController::class, 'toggleTop'])->name('artists.toggleTop');
    Route::patch('artists/{user}/toggle-featured', [ArtistController::class, 'toggleFeatured'])->name('artists.toggleFeatured');

    Route::resource('testimonials', TestimonialController::class);
    
});