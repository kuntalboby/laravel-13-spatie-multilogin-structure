{{-- Size chart from brand_sizes.size_chart ("inches|cm"). The row of the selected size is highlighted. --}}
@props(['product'])

@php
    $sizes = $product->productPrices
        ->filter(fn ($p) => ($p->is_deleted ?? '0') == '0')
        ->sortBy('brand_size_id')->unique('brand_size_id')
        ->pluck('brandSize')->filter()->values();

    $charts = $sizes->mapWithKeys(function ($s) {
        $c = $s->size_chart;
        if (is_string($c)) $c = json_decode($c, true);
        return [$s->id => is_array($c) ? $c : []];
    });

    $keys = $charts->flatMap(fn ($c) => array_keys($c))->unique()->values();
@endphp

@if ($sizes->isEmpty() || $keys->isEmpty())
    <span class="text-muted">No size chart available.</span>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-sm text-center mb-1" id="pvSizeChart">
            <thead class="thead-light">
                <tr>
                    <th>Size</th>
                    @foreach ($keys as $k)
                        <th>{{ \Illuminate\Support\Str::headline($k) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $s)
                    <tr data-size="{{ $s->id }}">
                        <th>{{ strtoupper($s->size) }}</th>
                        @foreach ($keys as $k)
                            @php
                                $val = $charts[$s->id][$k] ?? null;
                                [$in, $cm] = array_pad(explode('|', (string) $val, 2), 2, null);
                            @endphp
                            <td>
                                @if ($val)
                                    {{ $in }} in <small class="text-muted">/ {{ $cm }} cm</small>
                                @else
                                    —
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <small class="text-muted">Measurements are in inches / centimeters.</small>
@endif

@pushOnce('scripts', 'pv-sizechart-js')
    <script>
        document.addEventListener('pv:size', function (e) {
            document.querySelectorAll('#pvSizeChart tbody tr').forEach(function (tr) {
                tr.classList.toggle('table-warning', tr.dataset.size === String(e.detail.size));
            });
        });
    </script>
@endPushOnce
