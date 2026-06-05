<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->artistProfile;
        return view('artist.dashboard', compact('profile'));
    }
}