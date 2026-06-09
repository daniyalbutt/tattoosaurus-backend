<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TattooRequest;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(User $artist)
    {
        abort_unless($artist->hasRole('artist') && $artist->status === 'active', 404);
        $artist->load('artistProfile.city');
        return view('tattoo-request', ['artist' => $artist]);
    }

    public function store(Request $request, User $artist)
    {
        abort_unless($artist->hasRole('artist') && $artist->status === 'active', 404);

        $data = $request->validate([
            'reference_images'   => ['required', 'array', 'min:1'],
            'reference_images.*' => ['image','mimes:jpeg,png,jpg,webp','max:4096'],
            'idea'            => ['required','string','max:2000'],
            'size'            => ['required','string','max:50'],
            'placement'       => ['required','string','max:50'],
            'days'            => ['required','array','min:1'],
            'time_preference' => ['required','string','max:50'],
            'budget'          => ['required','string','max:50'],
            'age_confirm'     => ['required','string','in:18+'],
            'pronouns'        => ['required','string','max:50'],
            'timeframe'       => ['required','string','max:500'],
        ]);

        // store reference images
        $paths = [];
        foreach ($request->file('reference_images') as $img) {
            $paths[] = $img->store('tattoo-requests', 'public');
        }

        // create the tattoo request
        $tattooRequest = TattooRequest::create([
            'customer_id'     => auth()->id(),
            'artist_id'       => $artist->id,
            'reference_images'=> $paths,
            'idea'            => $data['idea'],
            'size'            => $data['size'],
            'placement'       => $data['placement'],
            'days'            => $data['days'],
            'time_preference' => $data['time_preference'],
            'budget'          => $data['budget'],
            'age_confirm'     => $data['age_confirm'],
            'pronouns'        => $data['pronouns'],
            'timeframe'       => $data['timeframe'],
            'status'          => 'pending',
        ]);

        // ALWAYS create a NEW conversation for this request (not firstOrCreate)
        $conversation = Conversation::create([
            'customer_id'      => auth()->id(),
            'artist_id'        => $artist->id,
            'tattoo_request_id'=> $tattooRequest->id,
        ]);

        // redirect to this specific conversation
        return redirect()->route('customer.requests.show', $conversation);
    }
}