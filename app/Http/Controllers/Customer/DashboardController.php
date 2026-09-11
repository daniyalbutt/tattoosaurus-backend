<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TattooRequest;
use App\Models\Conversation;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $requests = TattooRequest::where('customer_id', $userId)
            ->with('artist')
            ->latest()
            ->get();

        $conversations = Conversation::where('customer_id', $userId)
            ->with('artist')
            ->latest()
            ->get();

        $favourites = auth()->user()->favouriteArtists()
            ->with('artistProfile')
            ->latest('favourites.created_at')
            ->take(4)
            ->get();

        return view('customer.dashboard', compact('requests', 'conversations', 'favourites'));
    }

    public function center()
    {
        $requests = TattooRequest::where('customer_id', auth()->id())
            ->with(['artist.artistProfile', 'conversation'])
            ->latest()
            ->get();

        // group by status into the three tabs
        $pending   = $requests->where('status', 'pending');
        $upcoming  = $requests->whereIn('status', ['accepted', 'approved']);
        $completed = $requests->where('status', 'completed');

        return view('customer.center', compact('pending', 'upcoming', 'completed'));
    }

    public function openChat(\App\Models\TattooRequest $tattooRequest)
    {
        abort_unless($tattooRequest->customer_id === auth()->id(), 403);

        $conversation = \App\Models\Conversation::where('tattoo_request_id', $tattooRequest->id)->first();
        abort_unless($conversation, 404);

        return redirect()->route('customer.requests.show', $conversation);
    }

    public function requestDetail(\App\Models\TattooRequest $tattooRequest)
    {
        abort_unless($tattooRequest->customer_id === auth()->id(), 403);
        $tattooRequest->load('artist.artistProfile');

        $conversation = \App\Models\Conversation::where('tattoo_request_id', $tattooRequest->id)->first();

        return response()->json([
            'idea'        => $tattooRequest->idea ?: '—',
            'size'        => $tattooRequest->size ?: '—',
            'placement'   => $tattooRequest->placement ?: '—',
            'days'        => !empty($tattooRequest->days) ? implode(', ', $tattooRequest->days) : '—',
            'time'        => $tattooRequest->time_preference ?: '—',
            'budget'      => $tattooRequest->budget ?: '—',
            'pronouns'    => $tattooRequest->pronouns ?: '—',
            'timeframe'   => $tattooRequest->timeframe ?: '—',
            'status'      => ucfirst($tattooRequest->status),
            'artist'      => $tattooRequest->artist->name,
            'shop'        => $tattooRequest->artist->artistProfile?->shop_name ?: '',
            'artistAvatar'=> $tattooRequest->artist->artistProfile?->avatar
                ? asset('storage/'.$tattooRequest->artist->artistProfile->avatar)
                : 'https://ui-avatars.com/api/?name='.urlencode($tattooRequest->artist->name).'&size=60',
            'images'      => collect($tattooRequest->reference_images ?? [])
                            ->map(fn($p) => asset('storage/'.$p))->values(),
            'chatUrl'     => $conversation ? route('customer.requests.show', $conversation) : null,
        ]);
    }



    public function board()
    {
        $items = auth()->user()->boardItems()
            ->with('artist.artistProfile')
            ->latest()
            ->get();

        return view('customer.board', compact('items'));
    }

    public function favourites()
    {
        $favourites = auth()->user()->favouriteArtists()
            ->with('artistProfile')
            ->get();

        return view('customer.favourites', compact('favourites'));
    }
}