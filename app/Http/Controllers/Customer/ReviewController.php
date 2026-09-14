<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ArtistReview;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, User $artist)
    {
        // only active artists can be reviewed
        abort_unless($artist->hasRole('artist') && $artist->status === 'active', 404);

        // can't review yourself
        abort_if($artist->id === auth()->id(), 403);

        $data = $request->validate([
            'rating'  => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        ArtistReview::updateOrCreate(
            ['artist_id' => $artist->id, 'customer_id' => auth()->id()],
            ['rating' => $data['rating'] ?? null, 'comment' => $data['comment']]
        );

        return response()->json(['ok' => true, 'message' => 'Review submitted.']);
    }
}