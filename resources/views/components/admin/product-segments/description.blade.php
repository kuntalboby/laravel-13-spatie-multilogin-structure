@props(['product'])

@if ($product->long_description)
    {!! nl2br(e($product->long_description)) !!}
@elseif ($product->short_description)
    {{ $product->short_description }}
@else
    <span class="text-muted">No description added yet.</span>
@endif
