{{-- Tabs under the product block. Comments and Rating are empty placeholders for now. --}}
@props(['product'])

<div class="row mt-4">
    <nav class="w-100">
        <div class="nav nav-tabs" id="product-tab" role="tablist">
            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
            <a class="nav-item nav-link" id="product-size-tab" data-toggle="tab" href="#product-size"
                role="tab" aria-controls="product-size" aria-selected="false">Size Chart</a>
            <a class="nav-item nav-link" id="product-variations-tab" data-toggle="tab" href="#product-variations"
                role="tab" aria-controls="product-variations" aria-selected="false">Variations</a>
            <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments"
                role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
            <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating"
                role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
        </div>
    </nav>

    <div class="tab-content p-3 w-100" id="nav-tabContent">
        <div class="tab-pane fade active show" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
            <x-admin.product-segments.description :product="$product" />
        </div>
        <div class="tab-pane fade" id="product-size" role="tabpanel" aria-labelledby="product-size-tab">
            <x-admin.product-segments.size-chart :product="$product" />
        </div>
        <div class="tab-pane fade" id="product-variations" role="tabpanel" aria-labelledby="product-variations-tab">
            <x-admin.product-segments.variations-table :product="$product" />
        </div>
        <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
            <x-admin.product-segments.comments :product="$product" />
        </div>
        <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
            <x-admin.product-segments.rating :product="$product" />
        </div>
    </div>
</div>
