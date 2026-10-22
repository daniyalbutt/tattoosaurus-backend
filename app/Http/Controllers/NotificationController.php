<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);

        return view('artist.notifications', compact('notifications'));
    }

    public function destroy(Request $request, string $id)
    {
        $request->user()->notifications()->where('id', $id)->delete();
        return back()->with('success', 'Notification removed.');
    }

    // mark one read, then redirect to its url (used when a user clicks a notification)
    public function markRead(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            $url = $notification->data['url'] ?? null;
            if ($url) return redirect($url);
        }

        return back();
    }

    // mark all read (AJAX or plain POST)
    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }
        return back();
    }
}