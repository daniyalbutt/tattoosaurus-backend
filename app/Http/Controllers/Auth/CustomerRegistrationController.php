<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:users,username'],
            'email'    => ['required','email','unique:users,email'],
            'phone'    => ['required','string','max:30'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => $data['password'],
            'status'   => 'active',                 // customers active immediately
            'otp_code' => (string) rand(100000, 999999),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $user->assignRole('customer');
        Mail::to($user->email)->send(new OtpMail($user->otp_code));

        session(['registration_user_id' => $user->id]);
        return response()->json(['message' => 'registered'], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required','string','size:6']]);

        $user = User::find(session('registration_user_id'));
        if (! $user) {
            return response()->json(['message' => 'Session expired. Please register again.'], 422);
        }

        if ($user->otp_code !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired code.'], 422);
        }

        $user->update(['otp_code' => null, 'otp_expires_at' => null, 'email_verified_at' => now()]);

        // log them in and send them where they were headed (booking wizard)
        Auth::login($user);

        return response()->json([
            'redirect' => session('intended_url') ?? route('home'),
        ], 200);
    }

    public function resendOtp(Request $request)
    {
        $user = User::find(session('registration_user_id'));
        if (! $user) {
            return response()->json(['message' => 'Session expired.'], 422);
        }

        $user->update([
            'otp_code' => (string) rand(100000, 999999),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($user->otp_code));
        return response()->json(['message' => 'resent'], 200);
    }
}