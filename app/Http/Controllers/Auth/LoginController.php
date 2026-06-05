<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required'],            // email OR phone, so just required
            'password' => ['required'],
        ]);

        // allow login by email OR phone
        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $attempt = Auth::attempt([
            $field     => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'));

        if (! $attempt) {
            return response()->json([
                'message' => 'Invalid credentials.',
                'errors'  => ['email' => ['These credentials do not match our records.']],
            ], 422);
        }

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            return response()->json([
                'message' => 'Your account is not active yet. Please wait for approval.',
                'errors'  => ['email' => ['Your account is pending approval.']],
            ], 422);
        }

        $request->session()->regenerate();

        // decide redirect by role
        $redirect = match (true) {
            $user->hasRole('artist')   => route('artist.dashboard'),
            $user->hasRole('customer') => route('customer.dashboard'),
            $user->hasRole('admin')    => route('admin.dashboard'),
            default                    => url('/'),
        };

        return response()->json(['redirect' => $redirect]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}