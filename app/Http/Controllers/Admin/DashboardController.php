<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalArtists'   => User::role('artist')->count(),
            'pendingCount'   => User::role('artist')->where('status', 'pending')->count(),
            'activeArtists'  => User::role('artist')->where('status', 'active')->count(),
            'totalCustomers' => User::role('customer')->count(),
        ];

        return view('admin.dashboard', $data);
    }
}