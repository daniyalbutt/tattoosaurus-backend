@extends('artist.layouts.app')
@section('title', 'Edit Profile')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Update Profile</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <form method="POST"
                      action="{{ route('artist.profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- ── AVATAR ──────────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label>Profile Photo</label>
                        <div class="d-flex align-items-center gap-3 mb-2" style="gap: 20px;">
                            <img id="avatar-preview"
                                 src="{{ $profile->avatar
                                        ? asset('storage/' . $profile->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80' }}"
                                 alt="Avatar"
                                 style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:2px solid #dee2e6;">
                            <div>
                                <input type="file" name="avatar" id="avatar"
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="form-control">
                                <small class="text-muted">JPG, PNG or WebP · max 2 MB</small>
                            </div>
                        </div>
                        @error('avatar')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ── BIO ─────────────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" rows="4"
                                  placeholder="Tell clients about yourself…">{{ old('bio', $profile->bio) }}</textarea>
                        @error('bio')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TATTOO SHOP ──────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label>Tattoo Shop</label>
                        <input type="text" name="shop_name" class="form-control"
                            value="{{ old('shop_name', $profile->shop_name) }}"
                            placeholder="Your studio or shop name">
                        @error('shop_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ── LOCATION ─────────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label>Country</label>
                        <select name="country_id" id="country_id" class="form-control">
                            <option value="">— Select Country —</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $profile->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>State / Province</label>
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">— Select State —</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}"
                                    {{ old('state_id', $profile->state_id) == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <select name="city_id" id="city_id" class="form-control">
                            <option value="">— Select City —</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ old('city_id', $profile->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Responds Within</label>
                        <input type="text" name="response_time" class="form-control"
                               value="{{ old('response_time', $profile->response_time) }}"
                               placeholder="Responds within 2 days">
                    </div>

                    {{-- ── SOCIAL LINKS ──────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label>Social Links</label>
                        @foreach(['facebook','twitter','instagram','linkedin'] as $platform)
                            <input type="url"
                                   name="social_links[{{ $platform }}]"
                                   class="form-control mb-1"
                                   value="{{ old("social_links.$platform", $profile->social_links[$platform] ?? '') }}"
                                   placeholder="{{ ucfirst($platform) }} URL">
                        @endforeach
                    </div>

                    {{-- ── TATTOO STYLES ─────────────────────────────────────────── --}}
                    <div class="form-group">
                        <label class="mt-3 d-block">Tattoo Styles</label>
                        @php $selected = old('styles', $profile->styles ?? []); @endphp
                        @foreach(['fineline','dotwork','illustrative','blackwork','realism','traditional'] as $style)
                            <label class="me-3 mr-3">
                                <input type="checkbox" name="styles[]" value="{{ $style }}"
                                       {{ in_array($style, $selected) ? 'checked' : '' }}>
                                {{ ucfirst($style) }}
                            </label>
                        @endforeach
                    </div>

                    <button class="btn btn-black mt-3 w-auto">Save Profile</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Avatar live preview ───────────────────────────────────────────────────
document.getElementById('avatar').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('avatar-preview').src = e.target.result;
    reader.readAsDataURL(file);
});

// ── Cascading dropdowns ───────────────────────────────────────────────────
const statesUrl = "{{ route('artist.profile.states') }}";
const citiesUrl = "{{ route('artist.profile.cities') }}";

async function loadOptions(url, params, selectEl, placeholder) {
    selectEl.innerHTML = `<option value="">${placeholder}</option>`;
    selectEl.disabled = true;

    try {
        const qs = new URLSearchParams(params).toString();
        const res = await fetch(`${url}?${qs}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error('Network error');
        const items = await res.json();
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.name;
            selectEl.appendChild(opt);
        });
    } catch (e) {
        console.error(e);
    } finally {
        selectEl.disabled = false;
    }
}

document.getElementById('country_id').addEventListener('change', function () {
    const stateSelect = document.getElementById('state_id');
    const citySelect  = document.getElementById('city_id');
    citySelect.innerHTML = '<option value="">— Select City —</option>';

    if (!this.value) {
        stateSelect.innerHTML = '<option value="">— Select State —</option>';
        return;
    }
    loadOptions(statesUrl, { country_id: this.value }, stateSelect, '— Select State —');
});

document.getElementById('state_id').addEventListener('change', function () {
    const citySelect = document.getElementById('city_id');
    if (!this.value) {
        citySelect.innerHTML = '<option value="">— Select City —</option>';
        return;
    }
    loadOptions(citiesUrl, { state_id: this.value }, citySelect, '— Select City —');
});
</script>
@endpush