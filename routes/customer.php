<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\RequestController;
use App\Http\Controllers\Customer\FavouriteController;
use App\Http\Controllers\Customer\BoardController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\ReportController;


Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('dashboard',  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('center',     [DashboardController::class, 'center'])->name('center');
    Route::get('board',      [DashboardController::class, 'board'])->name('board');
    Route::get('favourites', [DashboardController::class, 'favourites'])->name('favourites');

    // favourite artist toggle (AJAX)
    Route::post('artists/{artist}/favourite', [FavouriteController::class, 'toggle'])->name('favourites.toggle');

    // request detail (AJAX) + chat redirect — both take {tattooRequest}, put before {conversation}
    Route::get('requests/{tattooRequest}/detail', [DashboardController::class, 'requestDetail'])->name('requests.detail');
    Route::get('requests/{tattooRequest}/chat',   [DashboardController::class, 'openChat'])->name('requests.chat');

    // conversation list + thread
    Route::get('requests',                         [RequestController::class, 'index'])->name('requests');
    Route::get('requests/{conversation}',          [RequestController::class, 'show'])->name('requests.show');
    Route::post('requests/{conversation}/message', [RequestController::class, 'sendMessage'])->name('requests.message');

    Route::post('board/toggle', [BoardController::class, 'toggle'])->name('board.toggle');
    
    Route::post('/artist/{artist}/review', [ReviewController::class, 'store'])->middleware(['auth', 'role:customer'])->name('artist.review');

    Route::post('/artist/{artist}/report', [ReportController::class, 'store'])->middleware(['auth'])->name('artist.report');

});