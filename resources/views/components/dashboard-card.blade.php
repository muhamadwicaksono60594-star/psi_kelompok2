@props([
    'title' => '',
    'icon'  => 'bi bi-info-circle',
    'color' => 'primary',
    'value' => null, // default null -> fallback ke slot
])

<div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <div class="mb-2">
                <i class="{{ $icon }} fs-2 text-{{ $color }}"></i>
            </div>

            <h6 class="text-muted">{{ $title }}</h6>

            {{-- Jika ada value, tampilkan. Kalau tidak, tampilkan slot (isi custom) --}}
            @if(!is_null($value))
                <h4 class="fw-bold">{{ $value }}</h4>
            @else
                <div>
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</div>
