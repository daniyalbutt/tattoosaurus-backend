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
            // Delete old avatar if exists
            $old = auth()->user()->artistProfile->avatar;
            if ($old && \Storage::disk('public')->exists($old)) {
                \Storage::disk('public')->delete($old);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Clear state/city if parent changed
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
            'items'                => ['nullable', 'array', 'max:50'],
            'items.*.description'  => ['nullable', 'string', 'max:150'],
            'items.*.image'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'remove'               => ['nullable', 'array'],
            'remove.*'             => ['integer'],
        ]);

        $profile  = auth()->user()->artistProfile;
        $existing = $profile->portfolio_images ?? [];

        // Remove deleted items (by index, descending to preserve order)
        $toRemove = $request->input('remove', []);
        rsort($toRemove);
        foreach ($toRemove as $idx) {
            if (isset($existing[$idx])) {
                \Storage::disk('public')->delete($existing[$idx]['image']);
                array_splice($existing, $idx, 1);
            }
        }

        // Append new uploads
        foreach ($request->file('items', []) as $i => $files) {
            if (!empty($files['image'])) {
                $path = $files['image']->store('portfolio', 'public');
                $existing[] = [
                    'image'       => $path,
                    'description' => trim($request->input("items.$i.description") ?? ''),
                ];
            }
        }

        $profile->update(['portfolio_images' => array_values($existing)]);

        return back()->with('success', 'Portfolio updated.');
    }

    public function featurePortfolio($index)
    {
        $profile = auth()->user()->artistProfile;
        $images  = $profile->portfolio_images ?? [];

        if (! isset($images[$index])) {
            return back()->with('error', 'Image not found.');
        }

        // exactly one featured: set on chosen index, clear the rest
        foreach ($images as $i => &$item) {
            $item['featured'] = ((string) $i === (string) $index);
        }
        unset($item);

        $profile->update(['portfolio_images' => $images]);

        return back()->with('success', 'Featured image updated.');
    }
}