<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ArtistRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomerRegistrationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Stubs — point these at real controllers as you build each page
Route::post('/login',  [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/tattoo-artist/{user}', [HomeController::class, 'show'])->name('artist.public.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/term-conditions', [HomeController::class, 'termConditions'])->name('term.conditions');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/cookie-policy', [HomeController::class, 'cookiePolicy'])->name('cookie.policy');

Route::get('/tattoo-gallery', [HomeController::class, 'tattooGallery'])->name('tattoo.gallery');
Route::get('/flash-gallery', [HomeController::class, 'flashGallery'])->name('flash.gallery');
Route::get('/tattoo-artist', [HomeController::class, 'artistSearch'])->name('artist.search');
Route::get('/events', [HomeController::class, 'events'])->name('events');

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

// web.php
Route::middleware('auth')->group(function () {
    Route::get('/tattoo-request/{artist}',  [BookingController::class, 'create'])->name('tattoo.request');
    Route::post('/tattoo-request/{artist}', [BookingController::class, 'store'])->name('tattoo.request.store');

    Route::get('/chat/{conversation}',       [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}',      [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversation}/poll',  [ChatController::class, 'poll'])->name('chat.poll');
});

Route::prefix('register/customer')->name('customer.register.')->group(function () {
    Route::post('/',            [CustomerRegistrationController::class, 'register'])->name('store');
    Route::post('/otp',         [CustomerRegistrationController::class, 'verifyOtp'])->name('otp');
    Route::post('/otp/resend',  [CustomerRegistrationController::class, 'resendOtp'])->name('otp.resend');
});