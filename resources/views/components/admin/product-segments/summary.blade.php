{{-- Title, status badges, short description and basic details --}}
@props(['product'])

@php
    $tags = preg_split('/\s+/', trim((string) $product->related_product_hash_tag), -1, PREG_SPLIT_NO_EMPTY);
    $gst  = rtrim(rtrim(number_format((float) $product->gst, 2, '.', ''), '0'), '.');
    $hsn  = in_array((string) $product->hsn_code, ['', '0'], true) ? '—' : $product->hsn_code;
@endphp

<h3 class="my-3">{{ $product->name }}</h3>

<div class="mb-2">
    @if ($product->status == 1)
        <span class="badge badge-success">Active</span>
    @else
        <span class="badge badge-secondary">Inactive</span>
    @endif
    @if ($product->is_featured == 1)
        <span class="badge badge-info">Featured</span>
    @endif
    @if ($product->is_promotional == 1)
        <span class="badge badge-warning">Promoted</span>
    @endif
</div>

@if ($product->short_description)
    <p class="text-muted">{{ $product->short_description }}</p>
@endif

<table class="table table-sm table-borderless mb-2" style="max-width: 420px;">
    <tbody>
        <tr><th class="text-muted font-weight-normal" style="width:110px">Brand</th><td>{{ $product->brand->name ?? '—' }}</td></tr>
        <tr><th class="text-muted font-weight-normal">Category</th><td>{{ $product->category->name ?? '—' }}</td></tr>
        <tr><th class="text-muted font-weight-normal">Gender</th><td>{{ $product->gender->name ?? '—' }}</td></tr>
        <tr><th class="text-muted font-weight-normal">For</th><td>{{ $product->product_for === 'K' ? 'Kids' : 'Adult' }}</td></tr>
        <tr><th class="text-muted font-weight-normal">GST / HSN</th><td>{{ $gst }}% &middot; {{ $hsn }}</td></tr>
    </tbody>
</table>

@if (count($tags))
    <div class="mb-2">
        @foreach ($tags as $tag)
            <span class="badge badge-light border">{{ $tag }}</span>
        @endforeach
    </div>
@endif
