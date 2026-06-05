<?php
// app/Http/Controllers/Admin/ArtistController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ArtistApprovedMail;
use Illuminate\Support\Facades\Mail;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = User::role('artist')
            ->with('artistProfile')
            ->latest()
            ->paginate(10);

        return view('admin.artists.index', compact('artists'));
    }

    public function show(User $user)
    {
        $user->load('artistProfile.country', 'artistProfile.state', 'artistProfile.city');
        $profile = $user->artistProfile;
        return view('admin.artists.show', compact('user', 'profile'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'active']);

        try {
            Mail::to($user->email)->send(new ArtistApprovedMail($user));
            $msg = "{$user->name} has been approved and notified by email.";
        } catch (\Throwable $e) {
            report($e); // logs it
            $msg = "{$user->name} was approved, but the email could not be sent.";
        }

        return back()->with('success', $msg);
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        return back()->with('success', "{$user->name} has been rejected.");
    }

    public function toggleTop(User $user)
    {
        $profile = $user->artistProfile;
        if ($profile) {
            $profile->update(['is_top' => ! $profile->is_top]);
        }
        return back()->with('success',
            $profile?->is_top ? "{$user->name} marked as Top Artist." : "{$user->name} removed from Top Artists.");
    }

    public function toggleFeatured(User $user)
    {
        $profile = $user->artistProfile;
        if ($profile) {
            $profile->update(['is_featured' => ! $profile->is_featured]);
        }
        return back()->with('success',
            $profile?->is_featured ? "{$user->name} marked as Featured." : "{$user->name} removed from Featured.");
    }
}