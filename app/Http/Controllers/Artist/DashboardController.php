<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\TattooRequest;
use App\Models\Conversation;

class DashboardController extends Controller
{
    public function index()
    {
        $profile  = auth()->user()->artistProfile;
        $artistId = auth()->id();

        $base = TattooRequest::whereHas('conversation', fn ($q) => $q->where('artist_id', $artistId))
            ->with('conversation.customer')
            ->latest();

        $pending   = (clone $base)->where('status', 'pending')->get();
        $approved  = (clone $base)->where('status', 'approved')->get();
        $upcoming  = (clone $base)->where('status', 'approved')
                          ->where('payment_status', 'booking_confirmed')->get();
        $completed = (clone $base)->where('payment_status', 'fully_paid')->get();

        $stats = [
            'new_requests' => $pending->count(),
            'approved'     => $approved->count(),
            'upcoming'     => $upcoming->count(),
            'completed'    => $completed->count(),
        ];

        return view('artist.dashboard', compact(
            'profile', 'stats', 'pending', 'approved', 'upcoming', 'completed'
        ));
    }

    // AJAX: data for the #ms-recent-activity slide-out
    public function requestDetail(TattooRequest $tattooRequest)
    {
        $conv = $tattooRequest->conversation;
        abort_unless($conv && $conv->artist_id === auth()->id(), 403);

        $tattooRequest->load('conversation.customer');
        $platformFee = config('services.stripe.platform_fee', 10);
        [$statusLabel, $statusColor] = $tattooRequest->status_label;

        return response()->json([
            'customer'      => $conv->customer->name ?? 'Customer',
            'status_label'  => $statusLabel,
            'status_color'  => $statusColor,
            'placement'     => $tattooRequest->placement,
            'size'          => $tattooRequest->size,
            'idea'          => $tattooRequest->idea,
            'budget'        => $tattooRequest->budget,
            'days'          => !empty($tattooRequest->days) ? implode(', ', $tattooRequest->days) : null,
            'time_pref'     => $tattooRequest->time_preference,
            'tattoo_price'  => $tattooRequest->tattoo_price,
            'deposit'       => $tattooRequest->deposit_amount,
            'platform_fee'  => $platformFee,
            'remaining'     => $tattooRequest->remaining_balance,
            'images'        => collect($tattooRequest->reference_images ?? [])
                                   ->map(fn ($p) => asset('storage/'.$p))->values(),
            'chat_url'      => route('artist.requests.show', $conv),
        ]);
    }
}