<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\DashboardController;
use App\Http\Controllers\Artist\ProfileController;
use App\Http\Controllers\Artist\AvailabilityController;
use App\Http\Controllers\Artist\RequestController;
use App\Http\Controllers\Artist\StripeConnectController;

Route::middleware(['auth', 'role:artist'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile',        [ProfileController::class, 'update'])->name('profile.update');

    // AJAX cascading dropdowns
    Route::get('profile/states',  [ProfileController::class, 'states'])->name('profile.states');
    Route::get('profile/cities',  [ProfileController::class, 'cities'])->name('profile.cities');

    Route::get('faqs',  [ProfileController::class, 'faqs'])->name('faqs.edit');
    Route::post('faqs', [ProfileController::class, 'updateFaqs'])->name('faqs.update');

    Route::post('pricing', [ProfileController::class, 'updatePricing'])->name('pricing.update');

    Route::get('portfolio',  [ProfileController::class, 'portfolio'])->name('portfolio.edit');
    Route::post('portfolio', [ProfileController::class, 'updatePortfolio'])->name('portfolio.update');
    Route::patch('portfolio/feature/{index}', [ProfileController::class, 'featurePortfolio'])->name('portfolio.feature');

    Route::get('availability',  [AvailabilityController::class, 'edit'])->name('availability.edit');
    Route::post('availability', [AvailabilityController::class, 'update'])->name('availability.update');

    Route::get('flash',  [ProfileController::class, 'flash'])->name('flash.edit');
    Route::post('flash', [ProfileController::class, 'updateFlash'])->name('flash.update');
    Route::patch('flash/feature/{index}', [ProfileController::class, 'featureFlash'])->name('flash.feature');

    Route::get('requests',                    [RequestController::class, 'index'])->name('requests');
    Route::get('requests/{conversation}',     [RequestController::class, 'show'])->name('requests.show');
    Route::post('requests/{conversation}',    [RequestController::class, 'sendMessage'])->name('requests.message');

    Route::get('payouts',          [StripeConnectController::class, 'index'])->name('payouts');
    Route::post('payouts/connect', [StripeConnectController::class, 'connect'])->name('payouts.connect');
    Route::get('payouts/return',   [StripeConnectController::class, 'return'])->name('payouts.return');
    Route::get('payouts/refresh',  [StripeConnectController::class, 'refresh'])->name('payouts.refresh');

    Route::post('requests/{conversation}/pricing', [RequestController::class, 'setPricing'])->name('requests.pricing');

    Route::post('requests/{conversation}/approve', [RequestController::class, 'approve'])->name('requests.approve');
    Route::post('requests/{conversation}/decline', [RequestController::class, 'decline'])->name('requests.decline');
    
    Route::get('approved-requests', [RequestController::class, 'approved'])->name('requests.approved');
    Route::get('request-detail/{tattooRequest}', [DashboardController::class, 'requestDetail'])->name('request.detail');
});