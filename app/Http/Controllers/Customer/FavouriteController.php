<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function toggle(Request $request, User $artist)
    {
        abort_unless($artist->hasRole('artist'), 404);

        $customer = $request->user();

        $exists = $customer->favouriteArtists()->where('artist_id', $artist->id)->exists();

        if ($exists) {
            $customer->favouriteArtists()->detach($artist->id);
            $favourited = false;
        } else {
            $customer->favouriteArtists()->attach($artist->id);
            $favourited = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['favourited' => $favourited]);
        }

        return back();
    }
}