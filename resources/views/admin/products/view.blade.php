@section('title', 'Product : ' . $productInfo->name)
<x-admin.inner>
    @php
$params['title'] = 'Product : ' . ($productInfo->brand->name ?? '') . ' - ' . $productInfo->name;
    @endphp
    <x-admin.breadcrumb :params="$params" />

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">View</h3>
                    <div class="card-tools">
                        <a href="{{route('admin.masters.products.edit', $productInfo->randomid)}}" class="btn btn-primary text text-light">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <x-admin.product-segments.gallery :product="$productInfo" />
                        </div>
                        <div class="col-12 col-md-6">
                            <x-admin.product-segments.summary :product="$productInfo" />
                            <x-admin.product-segments.variants :product="$productInfo" />
                        </div>
                    </div>

                    <x-admin.product-segments.tabs :product="$productInfo" />
                </div>
            </div>
        </div>
    </section>
</x-admin.inner>