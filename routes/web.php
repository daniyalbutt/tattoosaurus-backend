<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ArtistRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Stubs — point these at real controllers as you build each page
Route::post('/login',  [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/tattoo-artist/{user}', [HomeController::class, 'show'])->name('artist.public.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::view('/tattoo-gallery', 'tattoo-gallery')->name('tattoo.gallery');
Route::view('/flash-gallery', 'flash-gallery')->name('flash.gallery');
Route::view('/tattoo-artist', 'tattoo-artist')->name('artist.search');
Route::view('/events', 'event')->name('events');

Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('countries',            [LocationController::class, 'countries'])->name('countries');
    Route::get('states/{country}',     [LocationController::class, 'states'])->name('states');
    Route::get('cities/{state}',       [LocationController::class, 'cities'])->name('cities');
});

Route::prefix('register/artist')->name('artist.register.')->group(function () {
    Route::get('/',           [ArtistRegistrationController::class, 'showForm'])->name('form');
    Route::post('/',          [ArtistRegistrationController::class, 'register'])->name('store');
    Route::post('/otp',       [ArtistRegistrationController::class, 'verifyOtp'])->name('otp');
    Route::post('/otp/resend',[ArtistRegistrationController::class, 'resendOtp'])->name('otp.resend');
    Route::post('/details',   [ArtistRegistrationController::class, 'saveDetails'])->name('details');
    Route::post('/profile',   [ArtistRegistrationController::class, 'saveProfile'])->name('profile');
});