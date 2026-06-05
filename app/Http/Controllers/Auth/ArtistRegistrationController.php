<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistRegisterRequest;
use App\Http\Requests\ArtistDetailsRequest;
use App\Http\Requests\ArtistProfileRequest;
use App\Mail\OtpMail;
use App\Models\ArtistProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ArtistRegistrationController extends Controller
{
    public function showForm()
    {
        return view('auth.artist-register');
    }

    // STEP 1 — create account + send OTP + assign Spatie role
    public function register(ArtistRegisterRequest $request)
    {
        $code = (string) random_int(100000, 999999);

        $user = User::create([
            'name'           => $request->name,
            'username'       => $request->username,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'password'       => $request->password,
            'status'         => 'pending',
            'otp_code'       => $code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $user->assignRole('artist');   // <-- Spatie

        Mail::to($user->email)->send(new OtpMail($code));
        $request->session()->put('registration_user_id', $user->id);

        return response()->json(['ok' => true, 'step' => 'otp']);
    }

    // STEP 2 — verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:6']]);
        $user = $this->currentRegistrant($request);

        if ($user->otp_code !== $request->otp || now()->gt($user->otp_expires_at)) {
            return response()->json(['ok' => false, 'message' => 'Invalid or expired code.'], 422);
        }

        $user->update(['email_verified_at' => now(), 'otp_code' => null, 'otp_expires_at' => null]);
        return response()->json(['ok' => true, 'step' => 'details']);
    }

    public function resendOtp(Request $request)
    {
        $user = $this->currentRegistrant($request);
        $code = (string) random_int(100000, 999999);
        $user->update(['otp_code' => $code, 'otp_expires_at' => now()->addMinutes(10)]);
        Mail::to($user->email)->send(new OtpMail($code));
        return response()->json(['ok' => true]);
    }

    // STEP 3 — country/state/city
    public function saveDetails(ArtistDetailsRequest $request)
    {
        $user = $this->currentRegistrant($request);
        ArtistProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('country_id', 'state_id', 'city_id')
        );
        return response()->json(['ok' => true, 'step' => 'profile']);
    }

    // STEP 4 — bio + images, stays "pending" for admin approval
    public function saveProfile(ArtistProfileRequest $request)
    {
        $user    = $this->currentRegistrant($request);
        $profile = $user->artistProfile()->firstOrNew([]);
        $profile->user_id = $user->id;
        $profile->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            $profile->avatar = $request->file('avatar')->store('artists/avatars', 'public');
        }
        if ($request->hasFile('portfolio')) {
            $profile->portfolio_images = collect($request->file('portfolio'))
                ->map(fn ($img) => $img->store('artists/portfolio', 'public'))
                ->all();
        }
        $profile->save();

        $request->session()->forget('registration_user_id');
        return response()->json(['ok' => true, 'step' => 'done']);
    }

    private function currentRegistrant(Request $request): User
    {
        return User::findOrFail($request->session()->get('registration_user_id'));
    }
}