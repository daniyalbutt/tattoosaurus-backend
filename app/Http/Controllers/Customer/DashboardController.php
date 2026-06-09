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

        return view('customer.dashboard', compact('requests', 'conversations'));
    }

    public function center()
    {
        return view('customer.center');
    }

    public function board()
    {
        return view('customer.board');
    }

    public function favourites()
    {
        return view('customer.favourites');
    }
}