<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\DashboardController;
use App\Http\Controllers\Artist\ProfileController;

Route::middleware(['auth', 'role:artist'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile',        [ProfileController::class, 'update'])->name('profile.update');

    // AJAX cascading dropdowns
    Route::get('profile/states',  [ProfileController::class, 'states'])->name('profile.states');
    Route::get('profile/cities',  [ProfileController::class, 'cities'])->name('profile.cities');

    Route::get('faqs',  [ProfileController::class, 'faqs'])->name('faqs.edit');
    Route::post('faqs', [ProfileController::class, 'updateFaqs'])->name('faqs.update');

    Route::get('portfolio',  [ProfileController::class, 'portfolio'])->name('portfolio.edit');
    Route::post('portfolio', [ProfileController::class, 'updatePortfolio'])->name('portfolio.update');
    Route::patch('portfolio/feature/{index}', [ProfileController::class, 'featurePortfolio'])->name('portfolio.feature');
});