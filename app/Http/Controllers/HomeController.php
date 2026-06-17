<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $topArtists = User::role('artist')
            ->where('status', 'active')
            ->whereHas('artistProfile', fn ($q) => $q->where('is_top', true))
            ->with(['artistProfile.city', 'artistProfile.country'])
            ->take(10)
            ->get();

        $featuredArtists = User::role('artist')
            ->where('status', 'active')
            ->whereHas('artistProfile', fn ($q) => $q->where('is_featured', true))
            ->with(['artistProfile.city', 'artistProfile.country'])
            ->take(10)
            ->get();

        return view('home', compact('topArtists', 'featuredArtists'));
    }

    public function show(User $user)
    {
        // only active artists are publicly viewable
        abort_unless(
            $user->hasRole('artist') && $user->status === 'active',
            404
        );

        $user->load(['artistProfile.country', 'artistProfile.state', 'artistProfile.city']);

        return view('tattoo-artist-details', [
            'user'    => $user,
            'profile' => $user->artistProfile,
        ]);
    }

    public function tattooGallery(){
        return view('tattoo-gallery');
    }

    public function flashGallery(){
        return view('flash-gallery');
    }

    public function artistSearch(){
        return view('tattoo-artist');
    }

    public function about()
    {
        return view('about');
    }

    public function faqs()
    {
        return view('faqs');
    }

    public function contact()
    {
        return view('contact');
    }

    public function events(){
        return view('events');
    }

    public function termConditions(){
        return view('term-conditions');
    }

    public function privacyPolicy(){
        return view('privacy-policy');
    }

    public function cookiePolicy(){
        return view('cookie-policy');
    }
}