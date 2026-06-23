<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\City;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->artistProfile;

        if (!$profile) {
            $profile = auth()->user()->artistProfile()->create([]);
        }

        $countries = Country::orderBy('name')->get(['id', 'name']);

        $states = $profile->country_id
            ? State::where('country_id', $profile->country_id)->orderBy('name')->get(['id', 'name'])
            : collect();

        $cities = $profile->state_id
            ? City::where('state_id', $profile->state_id)->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('artist.profile-edit', compact('profile', 'countries', 'states', 'cities'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'bio'           => ['nullable', 'string', 'max:2000'],
            'shop_name'     => ['nullable', 'string', 'max:120'],   // ← add
            'avatar'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'country_id'    => ['nullable', 'integer', 'exists:countries,id'],
            'state_id'      => ['nullable', 'integer', 'exists:states,id'],
            'city_id'       => ['nullable', 'integer', 'exists:cities,id'],
            'availability'  => ['nullable', 'string', 'max:255'],
            'response_time' => ['nullable', 'string', 'max:255'],
            'hourly_rate'   => ['nullable', 'numeric', 'min:0'],
            'social_links'  => ['nullable', 'array'],
            'styles'        => ['nullable', 'array'],
            'styles.*'      => ['string', 'max:50'],
            'faqs'          => ['nullable', 'array'],
            'faqs.*.q'      => ['nullable', 'string', 'max:255'],
            'faqs.*.a'      => ['nullable', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('avatar')) {
            $old = auth()->user()->artistProfile->avatar;
            if ($old && \Storage::disk('public')->exists($old)) {
                \Storage::disk('public')->delete($old);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!$request->filled('country_id')) {
            $data['state_id'] = null;
            $data['city_id']  = null;
        }
        if (!$request->filled('state_id')) {
            $data['city_id'] = null;
        }

        auth()->user()->artistProfile->update($data);

        return back()->with('success', 'Profile updated.');
    }

    // AJAX — states for a country
    public function states(Request $request)
    {
        $request->validate(['country_id' => ['required', 'integer']]);
        return response()->json(
            State::where('country_id', $request->country_id)
                 ->orderBy('name')
                 ->get(['id', 'name'])
        );
    }

    // AJAX — cities for a state
    public function cities(Request $request)
    {
        $request->validate(['state_id' => ['required', 'integer']]);
        return response()->json(
            City::where('state_id', $request->state_id)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    public function faqs()
    {
        $profile = auth()->user()->artistProfile;

        if (!$profile) {
            $profile = auth()->user()->artistProfile()->create([]);
        }

        return view('artist.faqs', compact('profile'));
    }

    public function updateFaqs(Request $request)
    {
        $data = $request->validate([
            'faqs'       => ['nullable', 'array', 'max:20'],
            'faqs.*.q'   => ['nullable', 'string', 'max:255'],
            'faqs.*.a'   => ['nullable', 'string', 'max:1000'],
        ]);

        // Strip completely empty pairs before saving
        $cleaned = collect($data['faqs'] ?? [])
            ->filter(fn($faq) => !empty(trim($faq['q'] ?? '')) || !empty(trim($faq['a'] ?? '')))
            ->values()
            ->toArray();

        auth()->user()->artistProfile->update(['faqs' => $cleaned]);

        return back()->with('success', 'FAQs updated.');
    }

    public function portfolio()
    {
        $profile = auth()->user()->artistProfile;

        if (!$profile) {
            $profile = auth()->user()->artistProfile()->create([]);
        }

        return view('artist.portfolio', compact('profile'));
    }

    public function updatePortfolio(Request $request)
    {
        $request->validate([
            'images'   => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove'   => ['nullable', 'array'],
        ]);

        $profile  = auth()->user()->artistProfile;
        $existing = $profile->portfolio_images ?? [];

        // remove selected (by index)
        if ($request->filled('remove')) {
            foreach ($request->remove as $i) {
                unset($existing[(int) $i]);
            }
            $existing = array_values($existing); // reindex
        }

        // add new uploads (flat paths)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $existing[] = $img->store('artists/portfolio', 'public');
            }
        }

        $profile->update(['portfolio_images' => $existing]);
        return back()->with('success', 'Portfolio updated.');
    }

    public function featurePortfolio($index)
    {
        $profile = auth()->user()->artistProfile;
        abort_if($index < 0 || $index >= count($profile->portfolio_images ?? []), 404);

        $profile->update([
            'featured_source'          => 'portfolio',
            'featured_portfolio_index' => (int) $index,
        ]);
        return back()->with('success', 'Featured image updated.');
    }

    public function featureFlash($index)
    {
        $profile = auth()->user()->artistProfile;
        abort_if($index < 0 || $index >= count($profile->flash_images ?? []), 404);

        $profile->update([
            'featured_source'          => 'flash',
            'featured_portfolio_index' => (int) $index,   // same column as gallery
        ]);
        return back()->with('success', 'Featured image updated.');
    }

    public function editPricing()   // or wherever this page loads from
    {
        $profile = auth()->user()->artistProfile;
        return view('artist.pricing-faqs', compact('profile'));
    }

    public function updatePricing(Request $request)
    {
        $data = $request->validate([
            'hourly_rate' => ['required', 'numeric', 'min:0', 'max:100000'],
        ]);
        auth()->user()->artistProfile()->update(['hourly_rate' => $data['hourly_rate']]);
        return back()->with('success', 'Pricing updated.');
    }

    public function flash()
    {
        $profile = auth()->user()->artistProfile;
        return view('artist.flash', compact('profile'));
    }

    public function updateFlash(Request $request)
    {
        $request->validate([
            'images'   => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove'   => ['nullable', 'array'],
        ]);

        $profile  = auth()->user()->artistProfile;
        $existing = $profile->flash_images ?? [];

        if ($request->filled('remove')) {
            foreach ($request->remove as $i) {
                unset($existing[(int) $i]);
            }
            $existing = array_values($existing);
            $profile->featured_flash_index = null; // reset since indexes shifted
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $existing[] = $img->store('artists/flash', 'public');
            }
        }

        $profile->flash_images = $existing;
        $profile->save();

        return back()->with('success', 'Flash gallery updated.');
    }

}