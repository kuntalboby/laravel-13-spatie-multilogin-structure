@props(['product', 'colors' => null, 'active' => false, 'maxMb' => 5])

@php
$colors = $colors ?? $product->productPrices->unique('color_id')->pluck('color')->filter()->values();

$uploadUrl = route('admin.masters.products.color-media.upload', $product->randomid);
$sortUrl = route('admin.masters.products.color-media.sort', $product->randomid);
@endphp

<div class="tab-pane fade product-gallery @if ($active) show active @endif"
    id="custom-tabs-five-gallery" role="tabpanel" data-max-mb="{{ $maxMb }}">
    <div class="overlay-wrapper">
        <div class="row">
            @forelse ($colors as $uploadedColor)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" style="background: #39cccc">
                            <h3 class="card-title">{{ $uploadedColor->name }}</h3>
                        </div>
                        <div class="card-header" style="background:{{ $uploadedColor->color_code }}"></div>
                        <div class="card-body">

                            <div class="dropzone-box" data-color="{{ $uploadedColor->id }}"
                                data-url="{{ $uploadUrl }}" data-sort-url="{{ $sortUrl }}">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="mb-0">Drag &amp; drop files here, or click to browse</p>
                                <small class="text-muted">Images or videos, max {{ $maxMb }} MB each</small>
                                <input type="file" class="d-none dz-input" multiple
                                    accept="image/jpeg,image/png,image/webp,video/mp4,video/webm">
                            </div>

                            <div class="dz-list">
                                @foreach ($product->galleries->where('color_id', $uploadedColor->id) as $m)
                                    <div class="dz-item" id="media_{{ $m->id }}" data-id="{{ $m->id }}">
                                        @if ($m->file_type === 'video')
                                            <video src="{{ asset('storage/products/colors/' . $m->file_name) }}" muted
                                                preload="metadata"></video>
                                            <span class="dz-play"><i class="fas fa-play"></i></span>
                                        @else
                                            <img src="{{ asset('storage/products/colors/thumbs/' . $m->file_name) }}" alt="">
                                        @endif
                                        <button type="button" class="dz-del"
                                            data-url="{{ route('admin.masters.products.color-media.delete', [$product->randomid, $m->id]) }}"
                                            data-target="#media_{{ $m->id }}">&times;</button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p class="text text-info">Please add product variation first</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- styles and scripts are added once, even if the component is used twice on a page --}}
@pushOnce('cssLinks', 'product-gallery-css')
    <style>
        .dropzone-box {
            border: 2px dashed #adb5bd; border-radius: 8px; padding: 18px 10px;
            text-align: center; cursor: pointer; color: #6c757d; transition: .15s;
        }
        .dropzone-box i { font-size: 28px; display: block; margin-bottom: 6px; }
        .dropzone-box:hover, .dropzone-box.dragover { border-color: #007bff; background: #f0f7ff; color: #007bff; }

        .dz-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .dz-item {
            position: relative; width: 90px; height: 90px; border-radius: 6px;
            border: 1px solid #dee2e6; overflow: hidden; background: #f8f9fa; cursor: grab;
        }
        .dz-item:active { cursor: grabbing; }
        .dz-item img, .dz-item video { width: 100%; height: 100%; object-fit: cover; }
        .dz-play {
            position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
            background: rgba(0,0,0,.55); color: #fff; width: 26px; height: 26px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;
        }
        .dz-del {
            position: absolute; top: 3px; right: 3px; border: 0; border-radius: 50%;
            width: 20px; height: 20px; line-height: 18px; padding: 0;
            background: rgba(220,53,69,.9); color: #fff; cursor: pointer;
        }
        .dz-uploading { padding: 6px; font-size: 11px; display: flex; flex-direction: column; justify-content: center; cursor: default; }
        .dz-uploading .dz-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-bottom: 4px; }
        .dz-uploading .progress { height: 6px; }
        .dz-error { border-color: #dc3545; color: #dc3545; }
        .dz-ghost { opacity: .4; border: 2px dashed #007bff; }
    </style>
@endPushOnce

@pushOnce('scripts', 'product-gallery-js')
    {{-- SortableJS must load before the code below --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        (function () {
            const CSRF    = '{{ csrf_token() }}';
            const ALLOWED = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm'];

            function initGallery(root) {
                const maxMb    = Number(root.data('max-mb')) || 5;
                const maxBytes = maxMb * 1024 * 1024;

                /* ---------- drag & drop / click to upload ---------- */
                root.find('.dropzone-box').each(function () {
                    const box = $(this), input = box.find('.dz-input');

                    box.on('click', function (e) { if (!$(e.target).is('input')) input.trigger('click'); });
                    input.on('change', function () { handleFiles(box, this.files); this.value = ''; });

                    box.on('dragenter dragover', function (e) {
                        e.preventDefault(); e.stopPropagation(); box.addClass('dragover');
                    });
                    box.on('dragleave dragend drop', function (e) {
                        e.preventDefault(); e.stopPropagation(); box.removeClass('dragover');
                    });
                    box.on('drop', function (e) { handleFiles(box, e.originalEvent.dataTransfer.files); });
                });

                function handleFiles(box, files) {
                    Array.from(files).forEach(file => {
                        if (!ALLOWED.includes(file.type)) return showTempError(box, file.name, 'Type not allowed.');
                        if (file.size > maxBytes)         return showTempError(box, file.name, 'Over ' + maxMb + ' MB.');
                        uploadOne(box, file);
                    });
                }

                function listOf(box) { return box.closest('.card-body').find('.dz-list'); }

                function uploadOne(box, file) {
                    const $item = $('<div class="dz-item dz-uploading"><div class="dz-name"></div>' +
                        '<div class="progress"><div class="progress-bar" style="width:0%"></div></div></div>');
                    $item.find('.dz-name').text(file.name);
                    listOf(box).append($item);

                    const fd = new FormData();
                    fd.append('file', file);
                    fd.append('color_id', box.data('color'));
                    fd.append('_token', CSRF);

                    $.ajax({
                        url: box.data('url'), type: 'POST', data: fd,
                        processData: false, contentType: false, dataType: 'json',
                        headers: { 'Accept': 'application/json' },
                        xhr: function () {
                            const x = $.ajaxSettings.xhr();
                            if (x.upload) x.upload.addEventListener('progress', e => {
                                if (e.lengthComputable) {
                                    $item.find('.progress-bar').css('width', Math.round(e.loaded / e.total * 100) + '%');
                                }
                            });
                            return x;
                        },
                        success: res => $item.replaceWith(buildItem(res)),
                        error: xhr => {
                            let msg = xhr.responseJSON?.errors?.file?.[0] || xhr.responseJSON?.message || 'Upload failed.';
                            if (xhr.status === 413) msg = 'File too large for the server.';
                            $item.removeClass('dz-uploading').addClass('dz-error').empty().text(msg);
                            setTimeout(() => $item.fadeOut(300, () => $item.remove()), 4000);
                        }
                    });
                }

                function showTempError(box, name, msg) {
                    const $e = $('<div class="dz-item dz-uploading dz-error"></div>').text(name + ': ' + msg);
                    listOf(box).append($e);
                    setTimeout(() => $e.fadeOut(300, () => $e.remove()), 4000);
                }

                // built with .attr()/.text(), so server values are never parsed as HTML
                function buildItem(m) {
                    const $i = $('<div class="dz-item"></div>')
                        .attr('id', 'media_' + m.randomid)
                        .attr('data-id', m.randomid);

                    if (m.type === 'video') {
                        $i.append($('<video muted preload="metadata"></video>').attr('src', m.url));
                        $i.append('<span class="dz-play"><i class="fas fa-play"></i></span>');
                    } else {
                        $i.append($('<img alt="">').attr('src', m.thumb_url));
                    }
                    $i.append($('<button type="button" class="dz-del">&times;</button>')
                        .attr('data-url', m.delete_url).attr('data-target', '#media_' + m.randomid));
                    return $i;
                }

                /* ---------- delete ---------- */
                root.on('click', '.dz-del', function () {
                    if (!confirm('Delete this file?')) return;
                    const target = $(this).data('target');
                    $.ajax({
                        url: $(this).data('url'), type: 'DELETE', data: { _token: CSRF },
                        success: () => $(target).remove(),
                        error: () => alert('Could not delete the file.'),
                    });
                });

                /* ---------- drag to sort (per color) ---------- */
                root.find('.dz-list').each(function () {
                    const list = this;
                    const box  = $(list).closest('.card-body').find('.dropzone-box');
                    let before = [];

                    const sortable = new Sortable(list, {
                        animation: 150,
                        ghostClass: 'dz-ghost',
                        filter: '.dz-uploading, .dz-del',   // not draggable: files still uploading, and the delete button
                        preventOnFilter: false,             // so the delete button still receives the click
                        onStart: () => { before = sortable.toArray(); },
                        onEnd: function () {
                            const ids = sortable.toArray().filter(Boolean);
                            if (JSON.stringify(ids) === JSON.stringify(before.filter(Boolean))) return;   // nothing moved

                            $.ajax({
                                url: box.data('sort-url'),
                                type: 'POST',
                                data: { _token: CSRF, _method: 'PUT', color_id: box.data('color'), ids: ids },
                                error: function () {
                                    sortable.sort(before);   // put the items back
                                    alert('Could not save the new order.');
                                }
                            });
                        }
                    });
                });
            }

            $(function () {
                $('.product-gallery').each(function () { initGallery($(this)); });
            });
        })();
    </script>
@endPushOnce
