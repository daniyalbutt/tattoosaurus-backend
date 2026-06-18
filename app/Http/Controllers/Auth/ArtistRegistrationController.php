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
use App\Mail\NewArtistRegistered;

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

        $user->assignRole('artist');

        Mail::to($user->email)->send(new OtpMail($code, $user->name));
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
        Mail::to($user->email)->send(new OtpMail($code, $user->name));
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

    // STEP 4 — image, shop, bio  (NO session forget — more steps follow)
    public function saveProfile(ArtistProfileRequest $request)
    {
        $user    = $this->currentRegistrant($request);
        $profile = $user->artistProfile()->firstOrNew([]);
        $profile->user_id   = $user->id;
        $profile->bio       = $request->bio;
        $profile->shop_name = $request->shop_name;

        if ($request->hasFile('avatar')) {
            $profile->avatar = $request->file('avatar')->store('artists/avatars', 'public');
        }
        $profile->save();

        return response()->json(['ok' => true, 'step' => 'gallery']);
    }

    // STEP 6 — gallery
    public function saveGallery(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);
        $user = $this->currentRegistrant($request);

        $paths = collect($request->file('images'))
            ->map(fn ($img) => $img->store('artists/portfolio', 'public'))
            ->all();

        $user->artistProfile()->update(['portfolio_images' => $paths]);
        return response()->json(['ok' => true, 'step' => 'flash']);
    }

    // STEP 7 — flash gallery
    public function saveFlash(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);
        $user = $this->currentRegistrant($request);

        $paths = collect($request->file('images'))
            ->map(fn ($img) => $img->store('artists/flash', 'public'))
            ->all();

        $user->artistProfile()->update(['flash_images' => $paths]);
        return response()->json(['ok' => true, 'step' => 'availability']);
    }

    // STEP 8 — availability
    public function saveAvailability(Request $request)
    {
        $data = $request->validate([
            'availability'                => ['required', 'array'],
            'availability.*.day'          => ['required', 'string'],
            'availability.*.enabled'      => ['required', 'boolean'],
            'availability.*.ranges'       => ['array'],
            'availability.*.ranges.*.from'=> ['required_with:availability.*.ranges', 'string'],
            'availability.*.ranges.*.to'  => ['required_with:availability.*.ranges', 'string'],
        ]);

        $user = $this->currentRegistrant($request);
        $user->artistProfile()->update(['availability' => $data['availability']]);
        return response()->json(['ok' => true, 'step' => 'social']);
    }

    // STEP 9 — social media
    public function saveSocial(Request $request)
    {
        $data = $request->validate([
            'facebook'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter'   => ['nullable', 'url', 'max:255'],
            'website'   => ['nullable', 'url', 'max:255'],
        ]);
        $user = $this->currentRegistrant($request);

        $user->artistProfile()->update(['social_links' => $data]);
        return response()->json(['ok' => true, 'step' => 'pricing']);
    }

    // STEP 10 — pricing (final data step) → clears session

    public function savePricing(Request $request)
    {
        $data = $request->validate(['hourly_rate' => ['required', 'numeric', 'min:0', 'max:100000']]);
        $user = $this->currentRegistrant($request);

        $user->artistProfile()->update(['hourly_rate' => $data['hourly_rate']]);

        // notify admin from config (.env)
        $adminEmail = config('mail.admin_address');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new NewArtistRegistered($user->fresh('artistProfile')));
        }

        $request->session()->forget('registration_user_id');
        return response()->json(['ok' => true, 'step' => 'done']);
    }

    private function currentRegistrant(Request $request): User
    {
        return User::findOrFail($request->session()->get('registration_user_id'));
    }
}