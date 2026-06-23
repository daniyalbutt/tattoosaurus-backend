<?php
namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->artistProfile;
        $availability = $profile?->availability ?? [];
        return view('artist.availability', compact('profile', 'availability'));
    }

    public function update(Request $request)
    {
        $data = $request->validate(['availability' => ['required', 'array']]);
        auth()->user()->artistProfile()->update(['availability' => $data['availability']]);
        return back()->with('success', 'Availability updated.');
    }
}