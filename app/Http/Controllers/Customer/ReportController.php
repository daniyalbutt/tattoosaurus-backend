<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ArtistReport;
use App\Models\User;
use App\Mail\ArtistReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function store(Request $request, User $artist)
    {
        // only active artists can be reported
        abort_unless($artist->hasRole('artist') && $artist->status === 'active', 404);

        // can't report yourself
        abort_if($artist->id === auth()->id(), 403);

        $data = $request->validate([
            'reason'  => ['required', 'string', 'max:100'],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        $report = ArtistReport::create([
            'artist_id'   => $artist->id,
            'reporter_id' => auth()->id(),
            'reason'      => $data['reason'],
            'details'     => $data['details'] ?? null,
            'status'      => 'open',
        ]);

        // notify admin
        $adminEmail = config('mail.admin_address');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ArtistReported($report));
        }

        return response()->json(['ok' => true, 'message' => 'Report submitted.']);
    }
}