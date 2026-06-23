@extends('artist.layouts.app')
@section('title', 'Availability')

@push('styles')
<style>
    .avail-row { padding:16px 0; border-bottom:1px solid #eee; }
    .day-pill { display:inline-block; border:1px solid #ccc; border-radius:8px; padding:8px 18px; font-weight:600; font-size: 15px; }
    .range-add, .range-remove {
        width:36px; height:36px; flex-shrink:0; border:none; border-radius:50%;
        background:#111; color:#fff; font-size:18px; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        margin-left: 20px;
    }
    .range-add:hover, .range-remove:hover { background:#d4af37; }
    .range-item .form-control { max-width:140px; }
</style>
@endpush

@section('content')
@php
    $saved = collect($availability)->keyBy('day');
    $days = ['sun'=>'Sun','mon'=>'Mon','tue'=>'Tue','wed'=>'Wed','thu'=>'Thu','fri'=>'Fri','sat'=>'Sat'];
@endphp

<div class="row">
    <div class="col-md-12">
        <h2 class="title">Availability</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-body">
                <form id="availabilityForm">
                    @csrf
                    <div id="availabilityRows">
                        @foreach($days as $key => $label)
                            @php
                                $row = $saved->get($key);
                                $enabled = $row['enabled'] ?? false;
                                $ranges  = $row['ranges'] ?? [['from'=>'09:00','to'=>'21:00']];
                                if (empty($ranges)) $ranges = [['from'=>'09:00','to'=>'21:00']];
                            @endphp
                            <div class="avail-row" data-day="{{ $key }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="day-pill">{{ $label }}</span>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input day-toggle" type="checkbox" role="switch"
                                               id="toggle-{{ $key }}" {{ $enabled ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="time-wrap mt-2" style="display:{{ $enabled ? 'block' : 'none' }};">
                                    <label>Time Range</label>
                                    <div class="ranges">
                                        @foreach($ranges as $r)
                                            <div class="range-item d-flex align-items-center gap-2 mb-2">
                                                <input type="time" class="form-control time-from" value="{{ $r['from'] }}">
                                                <span class="ml-3 mr-3">To</span>
                                                <input type="time" class="form-control time-to" value="{{ $r['to'] }}">
                                                <button type="button" class="range-add">+</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-black mt-3">Save Availability</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // toggle day → show/hide ranges
    $(document).on('change', '.day-toggle', function () {
        $(this).closest('.avail-row').find('.time-wrap').toggle(this.checked);
    });

    // + add / − remove range
    $('#availabilityRows').on('click', '.range-add', function () {
        const item = `
            <div class="range-item d-flex align-items-center gap-2 mb-2">
                <input type="time" class="form-control time-from" value="09:00">
                <span class="ml-3 mr-3">To</span>
                <input type="time" class="form-control time-to" value="21:00">
                <button type="button" class="range-remove">&minus;</button>
            </div>`;
        $(this).closest('.ranges').append(item);
    });
    $('#availabilityRows').on('click', '.range-remove', function () {
        $(this).closest('.range-item').remove();
    });

    // submit
    $('#availabilityForm').on('submit', async function (e) {
        e.preventDefault();
        const availability = $('.avail-row').map(function () {
            const $row = $(this);
            const enabled = $row.find('.day-toggle').is(':checked');
            const ranges = enabled ? $row.find('.range-item').map(function () {
                return { from: $(this).find('.time-from').val(), to: $(this).find('.time-to').val() };
            }).get() : [];
            return { day: $row.data('day'), enabled, ranges };
        }).get();

        const res = await fetch('{{ route('artist.availability.update') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ availability }),
        });
        if (res.ok) {
            location.reload();
        } else {
            alert('Could not save. Please try again.');
        }
    });
});
</script>
@endpush