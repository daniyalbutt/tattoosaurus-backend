<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArtistProfile;
use Illuminate\Http\Request;

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

    public function show(ArtistProfile $artistProfile)
    {
        $user = $artistProfile->user;

        abort_unless(
            $user && $user->hasRole('artist') && $user->status === 'active',
            404
        );

        $artistProfile->load(['country', 'state', 'city', 'user']);

        return view('tattoo-artist-details', [
            'user'    => $user,
            'profile' => $artistProfile,
        ]);
    }

    public function tattooGallery(){
        return view('tattoo-gallery');
    }

    public function flashGallery(){
        return view('flash-gallery');
    }

    public function artistSearch(Request $request)
    {
        $q = $request->input('q');

        $artists = User::role('artist')
            ->where('status', 'active')
            ->whereHas('artistProfile')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhereHas('artistProfile', function ($p) use ($q) {
                            $p->where('shop_name', 'like', "%{$q}%")
                            ->orWhereHas('city',    fn ($c) => $c->where('name', 'like', "%{$q}%"))
                            ->orWhereHas('country', fn ($c) => $c->where('name', 'like', "%{$q}%"));
                        });
                });
            })
            ->with(['artistProfile.city', 'artistProfile.country', 'artistProfile.user'])
            ->latest()
            ->get();

        $highlighted = User::role('artist')
            ->where('status', 'active')
            ->whereHas('artistProfile', fn ($p) =>
                $p->where(fn ($sub) => $sub->where('is_featured', true)->orWhere('is_top', true))
            )
            ->with(['artistProfile.city', 'artistProfile.country', 'artistProfile.user'])
            ->take(10)
            ->get();

        return view('tattoo-artist', compact('artists', 'highlighted'));
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