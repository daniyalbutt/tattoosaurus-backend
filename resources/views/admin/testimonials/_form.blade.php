@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @method($method)

    {{-- Name --}}
    <div class="mb-3">
        <label class="form-label fw-medium">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $testimonial?->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="e.g. Joel Jensen">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Location --}}
    <div class="mb-3">
        <label class="form-label fw-medium">Location</label>
        <input type="text" name="location" value="{{ old('location', $testimonial?->location) }}"
               class="form-control @error('location') is-invalid @enderror"
               placeholder="e.g. Los Angeles">
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Message --}}
    <div class="mb-3">
        <label class="form-label fw-medium">Message <span class="text-danger">*</span></label>
        <textarea name="message" rows="4"
                  class="form-control @error('message') is-invalid @enderror"
                  placeholder="Testimonial text...">{{ old('message', $testimonial?->message) }}</textarea>
        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Image --}}
    <div class="mb-3">
        <label class="form-label fw-medium">Photo</label>
        @if($testimonial?->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $testimonial->image) }}"
                     alt="Current" class="rounded"
                     style="width:70px;height:70px;object-fit:cover;">
                <small class="text-muted ms-2">Current photo — upload a new one to replace it</small>
            </div>
        @endif
        <input type="file" name="image" accept="image/*"
               class="form-control @error('image') is-invalid @enderror">
        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Sort Order + Status --}}
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label class="form-label fw-medium">Sort Order</label>
            <input type="number" name="sort_order" min="0"
                   value="{{ old('sort_order', $testimonial?->sort_order ?? 0) }}"
                   class="form-control @error('sort_order') is-invalid @enderror">
            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label fw-medium">Status</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                       id="isActive"
                       {{ old('is_active', $testimonial?->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="isActive">Active (show on website)</label>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex gap-2 mt-1">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i>
            {{ $testimonial ? 'Update Testimonial' : 'Save Testimonial' }}
        </button>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Cancel</a>
    </div>
</form>