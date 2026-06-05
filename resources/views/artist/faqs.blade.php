@extends('artist.layouts.app')
@section('title', 'Manage FAQs')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Manage FAQs</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('artist.faqs.update') }}">
                    @csrf

                    <div id="faqs-wrapper">
                        @php
                            $faqs = old('faqs', $profile->faqs ?? []);
                            // Ensure at least one empty row
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

                    {{-- Hidden template cloned by JS --}}
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