@extends('artist.layouts.app')
@section('title', 'Manage Pricing & FAQs')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Pricing & FAQs</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ── PRICING ──────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Pricing</h2>
            <button type="button" class="btn btn-black" data-toggle="modal" data-target="#pricingModal" style="width: auto;">
                {{ $profile?->hourly_rate ? 'Add New Pricing' : 'Add New Pricing' }}
            </button>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                @if($profile?->hourly_rate)
                    <span class="badge badge-pill border mb-3 text-uppercase" style="border-radius:20px;color: black;font-size: 15px;padding: 12px 30px;">Hourly</span>
                    <h2 class="mb-0">
                        ${{ number_format($profile->hourly_rate, 2) }}
                        <small class="text-muted fs-14">/per tattoo</small>
                    </h2>
                @else
                    <p class="text-muted mb-0">No pricing set yet. Click "Add New Pricing" to set your hourly rate.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── FAQs ─────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-3">FAQ</h2>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('artist.faqs.update') }}">
                    @csrf

                    <div id="faqs-wrapper">
                        @php
                            $faqs = old('faqs', $profile->faqs ?? []);
                            if (empty($faqs)) {
                                $faqs = [['q' => '', 'a' => '']];
                            }
                        @endphp

                        @foreach($faqs as $i => $faq)
                            <div class="faq-item mb-3" data-index="{{ $i }}">
                                <div class="card">
                                    <div class="d-flex justify-content-between align-items-center mb-2 card-header">
                                        <h2 class="mb-0 faq-number">FAQ #{{ $i + 1 }}</h2>
                                        <button type="button"
                                                class="btn btn-sm btn-danger remove-faq mt-0"
                                                {{ count($faqs) === 1 ? 'disabled' : '' }} style="min-width: auto;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Question</label>
                                            <input type="text"
                                                name="faqs[{{ $i }}][q]"
                                                class="form-control"
                                                value="{{ $faq['q'] ?? '' }}"
                                                placeholder="e.g. How long does a tattoo session take?">
                                            @error("faqs.$i.q")
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-0">
                                            <label>Answer</label>
                                            <textarea name="faqs[{{ $i }}][a]"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Write your answer here…">{{ $faq['a'] ?? '' }}</textarea>
                                            @error("faqs.$i.a")
                                                <br>
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <template id="faq-template">
                        <div class="faq-item mb-3" data-index="__INDEX__">
                            <div class="card">
                                <div class="d-flex justify-content-between align-items-center mb-2 card-header">
                                    <h2 class="mb-0 faq-number">FAQ #__INDEX__</h2>
                                    <button type="button" class="btn btn-sm btn-danger remove-faq mt-0" style="min-width: auto;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Question</label>
                                        <input type="text"
                                            name="faqs[__INDEX__][q]"
                                            class="form-control"
                                            placeholder="e.g. How long does a tattoo session take?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Answer</label>
                                        <textarea name="faqs[__INDEX__][a]"
                                                class="form-control"
                                                rows="3"
                                                placeholder="Write your answer here…"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="d-flex align-items-center gap-3 mt-2 mb-4" style="gap: 20px;">
                        <button type="button" id="add-faq" class="btn btn-outline-secondary mt-0">Add Another FAQ</button>
                        <small class="text-muted" id="faq-count-hint"></small>
                    </div>

                    <button class="btn btn-black w-auto">Save FAQs</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Pricing Modal ────────────────────────────────────── --}}
<div class="modal fade" id="pricingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('artist.pricing.update') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ $profile?->hourly_rate ? 'Update' : 'Add' }} Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label>Hourly Rate ($)</label>
                        <input type="number" name="hourly_rate" class="form-control" min="0" step="0.01"
                               value="{{ old('hourly_rate', $profile?->hourly_rate) }}" placeholder="e.g. 120" required>
                        @error('hourly_rate')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-black">Save Pricing</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const wrapper   = document.getElementById('faqs-wrapper');
    const template  = document.getElementById('faq-template');
    const addBtn    = document.getElementById('add-faq');
    const countHint = document.getElementById('faq-count-hint');
    const MAX       = 20;

    function reindex() {
        const items = wrapper.querySelectorAll('.faq-item');
        items.forEach((item, idx) => {
            // Update heading
            item.querySelector('.faq-number').textContent = `FAQ #${idx + 1}`;
            // Update input names
            item.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/faqs\[\d+\]/, `faqs[${idx}]`);
            });
        });
        updateUI();
    }

    function updateUI() {
        const count = wrapper.querySelectorAll('.faq-item').length;
        // Disable remove btn when only 1 left
        wrapper.querySelectorAll('.remove-faq').forEach(btn => {
            btn.disabled = count === 1;
        });
        // Hide add btn at max
        addBtn.style.display = count >= MAX ? 'none' : 'inline-flex';
        countHint.textContent = count >= MAX ? `Maximum ${MAX} FAQs reached.` : `${count} FAQ${count !== 1 ? 's' : ''} added`;
    }

    // Add FAQ
    addBtn.addEventListener('click', function () {
        const count = wrapper.querySelectorAll('.faq-item').length;
        if (count >= MAX) return;

        const html = template.innerHTML.replaceAll('__INDEX__', count);
        const tmp  = document.createElement('div');
        tmp.innerHTML = html;
        const newItem = tmp.firstElementChild;

        // Attach remove listener
        newItem.querySelector('.remove-faq').addEventListener('click', removeFaq);

        wrapper.appendChild(newItem);
        reindex();

        // Scroll into view smoothly
        newItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // Remove FAQ (delegated + direct)
    function removeFaq() {
        const items = wrapper.querySelectorAll('.faq-item');
        if (items.length <= 1) return;
        this.closest('.faq-item').remove();
        reindex();
    }

    // Attach listeners to existing remove buttons
    wrapper.querySelectorAll('.remove-faq').forEach(btn => {
        btn.addEventListener('click', removeFaq);
    });

    // Init UI state
    updateUI();
})();
</script>
@endpush