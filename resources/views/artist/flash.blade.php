@extends('artist.layouts.app')
@section('title', 'Manage Flash Gallery')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Manage Flash Gallery</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                {{-- ── EXISTING ITEMS ─────────────────────────────────────── --}}
                @php
                    $flash = $profile->flash_images ?? [];
                @endphp

                @if(!empty($flash))
                    <h2 class="mb-3">Existing Flash Designs</h2>
                    <form method="POST" action="{{ route('artist.flash.update') }}" id="remove-form">
                        @csrf
                        <div class="row" id="existing-grid">
                            @foreach($flash as $idx => $path)
                            @php
                                $isFeatured = $profile->featured_source === 'flash'
                                    && (int)$profile->featured_portfolio_index === $idx;
                            @endphp
                            <div class="col-md-3 col-sm-4 col-6 mb-4 portfolio-card" id="card-{{ $idx }}">
                                <div class="card h-100">
                                    <div class="position-relative">
                                        <a href="{{ asset('storage/' . $path) }}" data-fancybox="flash">
                                            <img src="{{ asset('storage/' . $path) }}" alt=""
                                                class="card-img-top"
                                                style="height:180px;object-fit:cover;cursor:zoom-in;">
                                        </a>

                                        {{-- Featured badge --}}
                                        @if($isFeatured)
                                            <span class="badge bg-warning position-absolute" style="top:6px;left:6px;">
                                                <i class="fa fa-star"></i> Featured
                                            </span>
                                        @endif

                                        {{-- Remove button --}}
                                        <button type="button"
                                                class="btn btn-sm btn-danger position-absolute remove-existing"
                                                data-index="{{ $idx }}"
                                                style="top:6px;right:6px;min-width:auto;padding:2px 7px;margin-top:1px;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-2">
                                        <button type="button"
                                                class="btn btn-sm w-100 feature-btn {{ $isFeatured ? 'btn-warning' : 'btn-outline-warning' }}"
                                                data-feature-url="{{ route('artist.flash.feature', $idx) }}">
                                            <i class="fa fa-star"></i>
                                            {{ $isFeatured ? 'Featured' : 'Set as Featured' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>

                        <div id="remove-inputs"></div>

                        <button class="btn btn-danger w-auto mb-4" id="save-removals" style="display:none;">
                            Remove Selected
                        </button>
                    </form>
                    <hr>
                @endif

                {{-- ── ADD NEW FLASH ───────────────────────────────────────── --}}
                <h2 class="mb-3">Add New Flash Design</h2>
                <form method="POST" action="{{ route('artist.flash.update') }}" enctype="multipart/form-data">
                    @csrf

                    <div id="upload-wrapper">
                        <div class="upload-item mb-4" data-index="0">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <input type="file"
                                                name="images[]"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                class="dropify"
                                                data-max-file-size="3M"
                                                data-allowed-file-extensions="jpg jpeg png webp"
                                                data-height="180">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger remove-upload mt-0"
                                                    disabled>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template id="upload-template">
                        <div class="upload-item mb-4" data-index="__INDEX__">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <input type="file"
                                                name="images[]"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                class="dropify"
                                                data-max-file-size="3M"
                                                data-allowed-file-extensions="jpg jpeg png webp"
                                                data-height="180">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger remove-upload mt-0">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="d-flex align-items-center mt-2 mb-4" style="gap:16px;">
                        <button type="button" id="add-upload" class="btn btn-outline-secondary mt-0">Add Another</button>
                        <small class="text-muted" id="upload-count-hint"></small>
                    </div>

                    <button class="btn btn-black w-auto">Upload Flash</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const MAX           = 50;
    const uploadWrapper = document.getElementById('upload-wrapper');
    const uploadTpl     = document.getElementById('upload-template');
    const addUploadBtn  = document.getElementById('add-upload');
    const uploadHint    = document.getElementById('upload-count-hint');
    const csrf          = '{{ csrf_token() }}';

    function initDropify(input) {
        $(input).dropify({
            messages: {
                default: 'Click or drag & drop an image here',
                replace: 'Click or drag & drop to replace',
                remove:  'Remove',
                error:   'Sorry, this file is too large or invalid.',
            }
        });
    }

    function updateUploadUI() {
        const count = uploadWrapper.querySelectorAll('.upload-item').length;
        uploadWrapper.querySelectorAll('.remove-upload').forEach(btn => {
            btn.disabled = count === 1;
        });
        addUploadBtn.style.display = count >= MAX ? 'none' : 'inline-flex';
        uploadHint.textContent = count >= MAX
            ? `Maximum ${MAX} uploads per batch`
            : `${count} item${count !== 1 ? 's' : ''} queued`;
    }

    function attachRemove(item) {
        item.querySelector('.remove-upload').addEventListener('click', function () {
            if (uploadWrapper.querySelectorAll('.upload-item').length <= 1) return;
            const drInput = item.querySelector('.dropify');
            if (drInput) {
                const dr = $(drInput).data('dropify');
                if (dr) dr.destroy();
            }
            item.remove();
            updateUploadUI();
        });
    }

    initDropify(uploadWrapper.querySelector('.dropify'));
    attachRemove(uploadWrapper.querySelector('.upload-item'));
    updateUploadUI();

    addUploadBtn.addEventListener('click', function () {
        const count = uploadWrapper.querySelectorAll('.upload-item').length;
        if (count >= MAX) return;

        const html    = uploadTpl.innerHTML.replaceAll('__INDEX__', count);
        const tmp     = document.createElement('div');
        tmp.innerHTML = html;
        const newItem = tmp.firstElementChild;

        uploadWrapper.appendChild(newItem);
        initDropify(newItem.querySelector('.dropify'));
        attachRemove(newItem);
        updateUploadUI();
        newItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // Feature button → standalone PATCH form
    document.querySelectorAll('.feature-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.dataset.featureUrl;
            form.innerHTML =
                `<input type="hidden" name="_token" value="${csrf}">` +
                `<input type="hidden" name="_method" value="PATCH">`;
            document.body.appendChild(form);
            form.submit();
        });
    });

    // Remove existing items
    const removeForm   = document.getElementById('remove-form');
    const removeInputs = document.getElementById('remove-inputs');
    const saveRemovals = document.getElementById('save-removals');

    if (removeForm) {
        let toRemove = new Set();
        document.querySelectorAll('.remove-existing').forEach(btn => {
            btn.addEventListener('click', function () {
                const idx  = parseInt(this.dataset.index);
                const card = document.getElementById(`card-${idx}`);

                if (toRemove.has(idx)) {
                    toRemove.delete(idx);
                    card.style.opacity = '1';
                    this.innerHTML = '<i class="fa fa-times"></i>';
                } else {
                    toRemove.add(idx);
                    card.style.opacity = '0.4';
                    this.innerHTML = '<i class="fa fa-undo"></i>';
                }

                removeInputs.innerHTML = '';
                toRemove.forEach(i => {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = 'remove[]';
                    inp.value = i;
                    removeInputs.appendChild(inp);
                });

                saveRemovals.style.display = toRemove.size > 0 ? 'inline-block' : 'none';
            });
        });
    }

    $('[data-fancybox="flash"]').fancybox({
        buttons: ['zoom', 'slideShow', 'fullScreen', 'download', 'close'],
        loop: true,
        animationEffect: 'zoom',
        transitionEffect: 'slide',
    });
})();
</script>
@endpush