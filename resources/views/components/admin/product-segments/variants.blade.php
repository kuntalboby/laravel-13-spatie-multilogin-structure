{{-- Color + size pickers, price box and the selected variant's admin details --}}
@props(['product'])

@php
    $prices = $product->productPrices->filter(fn ($p) => ($p->is_deleted ?? '0') == '0');

    $colors = $prices->sortBy('color_id')->unique('color_id')->pluck('color')->filter()->values();
    $sizes  = $prices->sortBy('brand_size_id')->unique('brand_size_id')->pluck('brandSize')->filter()->values();

    // valid hex only, otherwise gray (needs color_code in the eager load)
    $hex = fn ($code) => preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', (string) $code) ? $code : '#ced4da';

    // 'colorId_sizeId' => variant data, read by the script below
    $map = $prices->mapWithKeys(fn ($p) => [
        $p->color_id . '_' . $p->brand_size_id => [
            'sku'       => $p->sku,
            'qty'       => (int) $p->quantity,
            'buying'    => (float) $p->buying_price,
            'mrp'       => (float) $p->mrp_price,
            'discount'  => (float) $p->discount_percentage,
            'price'     => (float) $p->selling_price,
            'available' => (string) $p->status === '0',     // 0 = available, 1 = not available
        ],
    ]);

    $firstOk      = $prices->first(fn ($p) => (string) $p->status === '0' && $p->quantity > 0);
    $initialColor = $firstOk->color_id ?? ($colors->first()->id ?? '');

    $gst = rtrim(rtrim(number_format((float) $product->gst, 2, '.', ''), '0'), '.');
@endphp

<div id="pvVariants" data-initial-color="{{ $initialColor }}">
    @if ($prices->isEmpty())
        <div class="alert alert-info mt-3">
            No variations added yet.
                <a href="{{ route('admin.masters.products.edit', $product->randomid) }}">Add variations</a>
        </div>
    @else
        <script type="application/json" id="pvVariantData">{!! json_encode($map, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

        <hr>
        <h4>Colors <small id="pvColorName" class="text-muted"></small></h4>
        <div class="pv-options">
            @foreach ($colors as $color)
                <button type="button" class="pv-color" 
                data-color="{{ $color->id }}" title="{{ $color->name }}"
                    style="background:{{ $color->color_code }}">
                    <span class="pv-swatch"></span>
                    <span class="pv-label">{{ $color->name }}</span>
                </button>
            @endforeach
        </div>

        <h4 class="mt-3">Sizes</h4>
        <div class="pv-options">
            @foreach ($sizes as $size)
                <button type="button" class="pv-size" data-size="{{ $size->id }}">{{ strtoupper($size->size) }}</button>
            @endforeach
        </div>
        <small class="text-muted d-block mt-1">Crossed-out sizes are out of stock or not available for the selected color.</small>

        {{-- price --}}
        <div class="bg-plain py-2 px-3 mt-4">
            <h2 class="mb-0">
                <span id="pvPrice">—</span>
                <small class="text-muted ml-2"><del id="pvMrp"></del></small>
                <span id="pvOff" class="badge badge-danger ml-1 d-none"></span>
            </h2>
            <h4 class="mt-0"><small>Selling price{{ (float) $product->gst > 0 ? ', GST ' . $gst . '% included' : '' }}</small></h4>
        </div>

        {{-- admin details of the selected variant --}}
        <table class="table table-sm table-bordered mt-3 mb-0">
            <tbody>
                <tr><th style="width:140px">SKU</th><td id="pvSku">—</td></tr>
                <tr><th>Stock</th><td><span id="pvStock" class="badge badge-secondary">—</span></td></tr>
                <tr><th>Buying price</th><td id="pvBuying">—</td></tr>
                <tr><th>Discount</th><td id="pvDiscount">—</td></tr>
                <tr><th>Availability</th><td><span id="pvStatus" class="badge badge-secondary">—</span></td></tr>
            </tbody>
        </table>
    @endif

    {{-- admin actions --}}
    {{-- <div class="mt-4">
        @if (\Illuminate\Support\Facades\Route::has('admin.masters.products.edit'))
            <a href="{{ route('admin.masters.products.edit', $product->randomid) }}" class="btn btn-primary btn-lg btn-flat">
                <i class="fas fa-edit fa-lg mr-2"></i> Edit Product
            </a>
        @endif
        @if (\Illuminate\Support\Facades\Route::has('admin.masters.products.index'))
            <a href="{{ route('admin.masters.products.index') }}" class="btn btn-default btn-lg btn-flat">
                <i class="fas fa-arrow-left fa-lg mr-2"></i> Back to list
            </a>
        @endif
    </div> --}}
</div>

@pushOnce('cssLinks', 'pv-variants-css')
    <style>
        .pv-options { display: flex; flex-wrap: wrap; gap: 8px; }
        .pv-color, .pv-size {
            background: #fff; border: 1px solid #ced4da; border-radius: 6px; cursor: pointer;
            padding: 6px 12px; line-height: 1.2;
        }
        .pv-color { display: inline-flex; align-items: center; gap: 8px; }
        .pv-swatch { width: 22px; height: 22px; border-radius: 50%; background: var(--pv-c); border: 1px solid rgba(0,0,0,.25); }
        .pv-size { min-width: 48px; font-weight: 600; text-align: center; }
        .pv-color:hover, .pv-size:hover:not(:disabled) { border-color: #007bff; }
        .pv-color.active, .pv-size.active { border-color: #007bff; box-shadow: 0 0 0 2px rgba(0,123,255,.25); background: #f0f7ff; }
        .pv-size:disabled { opacity: .35; cursor: not-allowed; background: #f8f9fa; }
        .pv-out { color: #adb5bd; }
        .pv-size.pv-out { text-decoration: line-through; }
        .pv-color.pv-out .pv-label { text-decoration: line-through; }
    </style>
@endPushOnce

@pushOnce('scripts', 'pv-variants-js')
    <script>
        (function () {
            function ready(fn) {
                if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn();
            }

            ready(function () {
                const root = document.getElementById('pvVariants');
                const dataEl = document.getElementById('pvVariantData');
                if (!root || !dataEl) return;

                const map = JSON.parse(dataEl.textContent);
                const $   = id => document.getElementById(id);
                const colorBtns = Array.from(root.querySelectorAll('.pv-color'));
                const sizeBtns  = Array.from(root.querySelectorAll('.pv-size'));

                const money = n => '₹' + Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                const key   = (c, s) => c + '_' + s;
                const ok    = v => !!v && v.available && v.qty > 0;
                const badge = (el, cls, text) => { el.className = 'badge ' + cls; el.textContent = text; };

                let color = root.dataset.initialColor || (colorBtns[0] ? colorBtns[0].dataset.color : null);
                let size  = null;

                function pickSize() {
                    const sizes = sizeBtns.map(b => b.dataset.size);
                    if (size && map[key(color, size)]) return;                       // keep the current size if it exists
                    size = sizes.find(s => ok(map[key(color, s)]))                   // else first one in stock
                        || sizes.find(s => map[key(color, s)])                       // else first one that exists
                        || null;
                }

                function render() {
                    pickSize();

                    colorBtns.forEach(b => {
                        const c = b.dataset.color;
                        b.classList.toggle('active', c === String(color));
                        b.classList.toggle('pv-out', !Object.keys(map).some(k => k.startsWith(c + '_') && ok(map[k])));
                        if (c === String(color)) $('pvColorName').textContent = '— ' + b.title;
                    });

                    sizeBtns.forEach(b => {
                        const v = map[key(color, b.dataset.size)];
                        b.disabled = !v;
                        b.classList.toggle('pv-out', !!v && !ok(v));
                        b.classList.toggle('active', b.dataset.size === String(size));
                    });

                    const v = size ? map[key(color, size)] : null;

                    $('pvPrice').textContent = v ? money(v.price) : '—';
                    $('pvMrp').textContent   = v && v.mrp > v.price ? 'MRP ' + money(v.mrp) : '';
                    const off = $('pvOff');
                    off.classList.toggle('d-none', !(v && v.discount > 0));
                    off.textContent = v ? v.discount + '% off' : '';

                    $('pvSku').textContent      = v && v.sku ? v.sku : '—';
                    $('pvBuying').textContent   = v ? money(v.buying) : '—';
                    $('pvDiscount').textContent = v ? v.discount + '%' : '—';

                    const stock = $('pvStock'), status = $('pvStatus');
                    if (!v)               { badge(stock, 'badge-secondary', '—');                    badge(status, 'badge-secondary', '—'); }
                    else {
                        if (v.qty === 0)      badge(stock, 'badge-danger',  'Out of stock');
                        else if (v.qty <= 5)  badge(stock, 'badge-warning', 'Only ' + v.qty + ' left');
                        else                  badge(stock, 'badge-success', v.qty + ' in stock');

                        if (v.available) badge(status, 'badge-success', 'Available');
                        else             badge(status, 'badge-secondary', 'Not available');
                    }

                    document.dispatchEvent(new CustomEvent('pv:color', { detail: { color: color } }));
                    document.dispatchEvent(new CustomEvent('pv:size',  { detail: { color: color, size: size } }));
                }

                root.addEventListener('click', function (e) {
                    const cb = e.target.closest('.pv-color');
                    const sb = e.target.closest('.pv-size');
                    if (cb) { color = cb.dataset.color; render(); }
                    if (sb && !sb.disabled) { size = sb.dataset.size; render(); }
                });

                render();
            });
        })();
    </script>
@endPushOnce
