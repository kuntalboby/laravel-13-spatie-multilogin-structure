{{-- Every color/size combination with stock and prices --}}
@props(['product'])

@php
    $prices = $product->productPrices
        ->filter(fn ($p) => ($p->is_deleted ?? '0') == '0')
        ->sortBy([['color_id', 'asc'], ['brand_size_id', 'asc']]);

    // $hex = fn ($code) => preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', (string) $code) ? $code : '#ced4da';
@endphp

@if ($prices->isEmpty())
    <span class="text-muted">No variations added yet.</span>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>Color</th>
                    <th>Size</th>
                    <th>SKU</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Buying</th>
                    <th class="text-right">MRP</th>
                    <th class="text-right">Disc %</th>
                    <th class="text-right">Selling</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prices as $p)
                    <tr>
                        <td>
                            <span style="display:inline-block;width:14px;height:14px;border-radius:50%;
                            vertical-align:middle;margin-right:6px;border:1px solid rgba(0,0,0,.25);
                            background:{{ $p->color->color_code }}"></span>
                            {{ $p->color->name ?? '—' }}
                        </td>
                        <td>{{ strtoupper($p->brandSize->size ?? '—') }}</td>
                        <td>{{ $p->sku ?: '—' }}</td>
                        <td class="text-right">
                            <span class="badge {{ $p->quantity == 0 ? 'badge-danger' : ($p->quantity <= 5 ? 'badge-warning' : 'badge-success') }}">{{ $p->quantity }}</span>
                        </td>
                        <td class="text-right">₹{{ number_format((float) $p->buying_price, 2) }}</td>
                        <td class="text-right">₹{{ number_format((float) $p->mrp_price, 2) }}</td>
                        <td class="text-right">{{ rtrim(rtrim(number_format((float) $p->discount_percentage, 2, '.', ''), '0'), '.') ?: '0' }}</td>
                        <td class="text-right">₹{{ number_format((float) $p->selling_price, 2) }}</td>
                        <td>
                            @if ((string) $p->status === '0')
                                <span class="badge badge-success">Available</span>
                            @else
                                <span class="badge badge-secondary">Not available</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
