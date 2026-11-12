{{-- Main image + thumbnails. Thumbnails switch with the selected color (event "pv:color"). --}}
@props(['product'])

@php
    $items = collect();

    if ($product->image) {
        $items->push([
            'type'  => 'image',
            'color' => null,
            'url'   => asset('storage/products/' . $product->image),
            'thumb' => asset('storage/products/thumbs/' . $product->image),
        ]);
    }

    foreach ($product->galleries as $g) {
        $isVideo = $g->file_type === 'video';
        $items->push([
            'type'  => $isVideo ? 'video' : 'image',
            'color' => $g->color_id ?? null,      // needs color_id in the galleries select
            'url'   => asset('storage/products/colors/' . $g->file_name),
            'thumb' => $isVideo ? null : asset('storage/products/colors/thumbs/' . $g->file_name),
        ]);
    }
@endphp

<div class="pv-gallery" id="pvGallery">
    <div class="pv-stage">
        @if ($items->isEmpty())
            <span class="text-muted"><i class="far fa-image fa-3x"></i><br>No image</span>
        @endif
        <img id="pvMainImage" class="product-image {{ $items->isEmpty() ? 'd-none' : '' }}"
            src="{{ $items->first()['type'] ?? '' === 'image' ? $items->first()['url'] : '' }}" alt="{{ $product->name }}">
        <video id="pvMainVideo" class="d-none" controls preload="metadata"></video>
    </div>

    <div class="pv-thumbs">
        @foreach ($items as $it)
            <button type="button" class="pv-thumb {{ $loop->first ? 'active' : '' }}"
                data-type="{{ $it['type'] }}" data-url="{{ $it['url'] }}" data-color="{{ $it['color'] }}">
                @if ($it['type'] === 'video')
                    <video src="{{ $it['url'] }}" muted preload="metadata"></video>
                    <span class="pv-play"><i class="fas fa-play"></i></span>
                @else
                    <img src="{{ $it['thumb'] }}" alt="">
                @endif
            </button>
        @endforeach
    </div>
</div>

@pushOnce('cssLinks', 'pv-gallery-css')
    <style>
        .pv-stage {
            height: 380px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; overflow: hidden; text-align: center;
        }
        .pv-stage img, .pv-stage video { max-width: 100%; max-height: 100%; object-fit: contain; }
        .pv-thumbs { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
        .pv-thumb {
            position: relative; width: 72px; height: 72px; padding: 0; background: #fff;
            border: 2px solid #dee2e6; border-radius: 6px; overflow: hidden; cursor: pointer;
        }
        .pv-thumb:hover { border-color: #adb5bd; }
        .pv-thumb.active { border-color: #007bff; }
        .pv-thumb img, .pv-thumb video { width: 100%; height: 100%; object-fit: cover; }
        .pv-play {
            position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
            width: 24px; height: 24px; border-radius: 50%; background: rgba(0,0,0,.55); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 9px;
        }
    </style>
@endPushOnce

@pushOnce('scripts', 'pv-gallery-js')
    <script>
        (function () {
            let activeColor = null;

            const $ = id => document.getElementById(id);
            const thumbs = () => Array.from(document.querySelectorAll('#pvGallery .pv-thumb'));

            function select(thumb) {
                const img = $('pvMainImage'), vid = $('pvMainVideo');
                if (!thumb || !img || !vid) return;

                thumbs().forEach(t => t.classList.toggle('active', t === thumb));
                vid.pause();

                if (thumb.dataset.type === 'video') {
                    img.classList.add('d-none');
                    vid.src = thumb.dataset.url;
                    vid.classList.remove('d-none');
                } else {
                    vid.classList.add('d-none');
                    vid.removeAttribute('src');
                    img.src = thumb.dataset.url;
                    img.classList.remove('d-none');
                }
            }

            // color changed: show shared thumbs (no color) plus the ones of this color
            function applyColor() {
                const all = thumbs();
                if (!all.length) return;

                all.forEach(t => {
                    const c = t.dataset.color;
                    t.style.display = (!c || c === activeColor) ? '' : 'none';
                });

                const visible  = all.filter(t => t.style.display !== 'none');
                const ofColor  = visible.find(t => t.dataset.color && t.dataset.color === activeColor);
                select(ofColor || visible[0]);
            }

            document.addEventListener('click', function (e) {
                const t = e.target.closest('#pvGallery .pv-thumb');
                if (t) select(t);
            });

            document.addEventListener('pv:color', function (e) {
                activeColor = String(e.detail.color);
                applyColor();
            });

            // first image: make sure the stage matches the first thumb
            function init() { const first = thumbs()[0]; if (first) select(first); }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
        })();
    </script>
@endPushOnce
