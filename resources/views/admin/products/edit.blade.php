@section('title', 'Edit Product :' . $product->name)
<x-admin.inner>
    @php
$params['title'] = 'Edit Product : ' . $product->brand->name . '-' . $product->name;

// work out which tab is open (computed once, not inside the loop)
$nextStep = $product->form_step_counter < config('app.PROD_FORMS_COUNT')
    ? $product->form_step_counter + 1
    : $product->form_step_counter;
$activeStep = strtolower($formSteps[$nextStep] ?? 'basic');

// echo $nextStep; exit;
// if the variation form failed validation, reopen that tab so the errors are visible
$hasVariationErrors = collect($errors->keys())
    ->contains(fn($k) => $k === 'data' || str_starts_with($k, 'data.'));
if ($hasVariationErrors) {
    $activeStep = 'variations';
}
// echo config('app.PROD_FORMS_COUNT'); exit;
if ($nextStep == config('app.PROD_FORMS_COUNT')) {
    $activeStep = 'basic';
}

// old input wins after a failed submit, otherwise show the saved rows
// $savedVariations (optional) = ['colorId_sizeId' => ['quantity'=>..,'actual_price'=>..,'discount_percentage'=>..,'status'=>..]]
$variationData = old('data', $savedVariations ?? []);
    @endphp
    <x-admin.breadcrumb :params="$params" />
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div>
                        @if (session('message'))
                            <div class="alertBox">
                                <p class="text-center text text-{{ session('response') }}">{{ session('message') }}</p>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                @foreach ($formSteps as $k => $formStep)
                                    @php $slug = strtolower($formStep); @endphp
                                    <li class="nav-item">
                                        <a class="nav-link @if ($slug === $activeStep) active @endif" data-toggle="pill"
                                            href="#custom-tabs-five-{{ $slug }}" role="tab" data-segment="{{ $slug }}"
                                            aria-controls="custom-tabs-five-{{ $slug }}"
                                            aria-selected="{{ $slug === $activeStep ? 'true' : 'false' }}">{{ $formStep }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-five-tabContent">

                                {{-- Basic Info --}}
                                <div class="tab-pane fade @if ($activeStep === 'basic') show active @endif"
                                    id="custom-tabs-five-basic" role="tabpanel">
                                    <div class="overlay-wrapper">
                                        <form action="{{ route('admin.masters.products.basicUpdate', $product->randomid) }}"
                                            enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="name">Name *</label>
                                                                    <input type="text" id="name" class="form-control"
                                                                        name="name"
                                                                        value="{{ old('name', $product->name) }}"
                                                                        placeholder="Product Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="category_id">Category *</label>
                                                                    <input type="hidden" name="category_id" value="{{ old('category_id', $product->category_id) }}">
                                                                    <select disabled class="form-control select2"
                                                                        name="category_id" id="category_id">
                                                                        <option value="0">Select Category</option>
                                                                        @foreach ($allCategories as $category)
                                                                            <option value="{{ $category->id }}"
                                                                                @selected(old('category_id', $product->category_id) == $category->id)>
                                                                                {{ $category->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="brand_id">Brands *</label>
                                                                    <input type="hidden" name="brand_id" value="{{ old('brand_id', $product->brand_id) }}">
                                                                    <select class="form-control select2" disabled name="brand_id"
                                                                        id="brand_id">
                                                                        <option value="0">Select Brand</option>
                                                                        @foreach ($allBrands as $brand)
                                                                            <option value="{{ $brand->id }}"
                                                                                @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                                                                {{ $brand->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="product_for">Product For *</label>
                                                                    <input type="hidden" name="product_for" value="{{ old('product_for', $product->product_for) }}">
                                                                    <select class="form-control" disabled name="product_for"
                                                                        id="product_for">
                                                                        <option value="A" @selected(old('product_for', $product->product_for) == 'A')>Adult</option>
                                                                        <option value="K" @selected(old('product_for', $product->product_for) == 'K')>Kids</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="gender_id">Choose Gender *</label>
                                                                    <input type="hidden" name="gender_id" value="{{ old('gender_id', $product->gender_id) }}">
                                                                    <select class="form-control" disabled name="gender_id"
                                                                        id="gender_id">
                                                                        <option value="0">Select Gender</option>
                                                                        @foreach ($genders as $gender)
                                                                            <option value="{{ $gender->id }}"
                                                                                @selected(old('gender_id', $product->gender_id) == $gender->id)>
                                                                                {{ $gender->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sku">GST (If any)</label>
                                                                    <input type="number" id="gst" class="form-control"
                                                                        name="gst"
                                                                        value="{{ old('gst', $product->gst) }}"
                                                                        placeholder="sku" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="manufacturing_date">Manufacturing Date
                                                                        (if any)</label>
                                                                    <input type="date" id="manufacturing_date"
                                                                        class="form-control" name="manufacturing_date"
                                                                        value="{{ old('manufacturing_date', $product->manufacturing_date) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="short_description">Short
                                                                        Description</label>
                                                                    <textarea class="form-control"
                                                                        name="short_description" id="short_description"
                                                                        rows="3"
                                                                        placeholder="Write in brief">{{ old('short_description', $product->short_description) }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="long_description">Long
                                                                        Description</label>
                                                                    <textarea class="form-control"
                                                                        name="long_description" id="long_description"
                                                                        rows="3"
                                                                        placeholder="Write about this product">{{ old('long_description', $product->long_description) }}</textarea>
                                                                </div>
                                                            </div>

                                                            {{-- hidden 0 is sent when the checkbox is unchecked --}}
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_featured">Is Featured?</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        
                                                                        <input class="custom-control-input"
                                                                            name="is_featured"  type="checkbox"
                                                                            id="is_featured"
                                                                            @if ($product->is_featured == '1') checked="checked" @endif
                                                                            value="{{ old('is_featured', $product->is_featured) }}"
                                                                            />
                                                                        <label for="is_featured"
                                                                            class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_promotional">Is Promoted</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                       
                                                                        <input class="custom-control-input"
                                                                            name="is_promotional" 
                                                                            type="checkbox" id="is_promotional"
                                                                             @if ($product->is_promotional == '1') checked="checked" @endif
                                                                            value="{{ old('is_promotional', $product->is_promotional) }}" />
                                                                        <label for="is_promotional"
                                                                            class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="status">Status *</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input"
                                                                            name="status" value="{{old('status', $product->status)}}" type="checkbox"
                                                                            id="status" 
                                                                            @if ($product->status == '0') checked="checked" @endif
                                                                            />
                                                                        <label for="status"
                                                                            class="custom-control-label">Active</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Base Image --}}
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="image" class="form-label" style="font-weight: 600; display: block; margin-bottom: 8px;">
                                                                    Upload Product Image
                                                                </label>
                                                                    <div id="preview-container"
                                                                        style="mb-3 margin-top: 15px; height: 200px; width: auto; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                                                        <img id="image-viewer" src="{{ $product->image ? asset('storage/products/' . $product->image) : '' }}" alt=""
                                                                            style="width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;
                                                                                                                                        display: {{ $product->image ? 'block' : 'none' }};">
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.webp,.gif" class="form-control-file"
                                                                            onchange="previewImage(this)">
                                                                        @error('image')
                                                                            <span class="text-danger" style="font-size: 14px; display: block; margin-top: 5px;">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="related_product_hash_tag">Tags</label>
                                                                    <textarea class="form-control" name="related_product_hash_tag" id="related_product_hash_tag" rows="3"
                                                                        placeholder="Same tag products will be showing as a related products">{{ old('related_product_hash_tag', $product->related_product_hash_tag) }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- end Basic --}}

                                {{-- Price Variations --}}
                                <div class="tab-pane fade @if ($activeStep === 'variations') show active @endif"
                                    id="custom-tabs-five-variations" role="tabpanel">
                                    <div class="overlay-wrapper">
                                        <form id="variationForm"
                                            action="{{ route('admin.masters.products.variations', $product->randomid) }}"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body">
                                                @error('data')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                
                                                <div class="row" id="variationResponse">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="brand_size_id">Choose Size *</label>
                                                            <select class="form-control select2 multiOption" multiple
                                                                name="brand_size_id" id="brand_size_id">
                                                                <option value="0">Select Available Size</option>
                                                                @foreach ($allSizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ strtoupper($size->size) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="color_id">Choose Color *</label>
                                                            <select multiple
                                                                class="form-control color-picker multiOption"
                                                                name="color_id" id="color_id">
                                                                <option value="0">Select Available Color</option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->id }}"
                                                                        data-color="{{ $color->color_code }}">
                                                                        {{ strtoupper($color->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <span class="form-control border-0 p-0 float-right">
                                                                <button type="button" class="btn btn-warning"
                                                                    onclick="makeVariations()">Get All Combinations</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <span class="form-control border-0 p-0 float-left">
                                                                <button type="button" class="btn btn-success" id="downloadAllVariationExcel"
                                                                    data-url="{{ route('admin.masters.products.variations.excel', $product->randomid) }}">
                                                                    Download combination xl
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <input type="file" id="variationExcelFile" class="d-none" accept=".xlsx">
                                                            <span class="form-control border-0 p-0 float-left">
                                                                <button type="button" class="btn btn-info" 
                                                                id="uploadVariationExcel"
                                                                    data-url="{{ route('admin.masters.products.variations.upload-excel', $product->randomid) }}">
                                                                    <i class="fas fa-upload"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-12">
                                                        <!-- actions -->
                                                        <div class="row justify-content-end 
                                                        @if (count($product->productPrices) == 0) d-none @endif " id="actionSection">
                                                            <div class="col-md-12 dsFlx">
                                                                <ul>
                                                                    <li>
                                                                        <button type="button" id="selectAllChck"
                                                                            class="btn btn-info">
                                                                            <i class="fa fa-check"></i> Select All
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button type="button" id="deleteAllVariation"
                                                                            class="btn btn-danger"
                                                                            title="Remove selected rows">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button type="button" id="openModalBtn"
                                                                            class="btn btn-primary">
                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @forelse ($product->productPrices->sortBy(['brand_size_id', 'color_id']) as $pv)
                                                            @php $id = $pv->color_id . '_' . $pv->brand_size_id; @endphp

                                                            <div class="row combinations variation_{{ $loop->index % 2 }}"
                                                                data-color="{{ $pv->color_id }}"
                                                                data-size="{{ $pv->brand_size_id }}"
                                                                data-combination="{{ $id }}" id="pattern_{{ $id }}">

                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="selected_variation_{{ $id }}"
                                                                            class="col-form-label">&nbsp;</label>
                                                                        <input type="checkbox" class="form-control"
                                                                            id="selected_variation_{{ $id }}"
                                                                            value="{{ $id }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="sizeInput_{{ $id }}"
                                                                            class="col-form-label">Size</label>
                                                                        <input readonly class="form-control"
                                                                            id="sizeInput_{{ $id }}"
                                                                            value="{{ strtoupper($pv->brandSize->size ?? '') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="colorInpt_{{ $id }}"
                                                                            class="col-form-label">Color</label>
                                                                        <input readonly class="form-control"
                                                                            id="colorInpt_{{ $id }}"
                                                                            value="{{ strtoupper($pv->color->name ?? '') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="skuInput_{{ $id }}" class="col-form-label">SKU</label>
                                                                        <input name="data[{{ $id }}][sku]" type="text" class="form-control sku_field dynamicFld" id="skuInput_{{ $id }}"
                                                                            value="{{ old("data.$id.sku", $pv->sku) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="quantityInput_{{ $id }}"
                                                                            class="col-form-label">Quantity*</label>
                                                                        <input min="0" step="1"
                                                                            name="data[{{ $id }}][quantity]" type="number"
                                                                            class="form-control qty_field dynamicFld"
                                                                            id="quantityInput_{{ $id }}"
                                                                            value="{{ old("data.$id.quantity", $pv->quantity) }}" />

                                                                        <input type="hidden"
                                                                            name="data[{{ $id }}][original_quantity]"
                                                                            id="originalQty_{{ $id }}"
                                                                            value="{{ old("data.$id.original_quantity", $pv->quantity) }}" />
                                                                    </div>
                                                                </div>

                                                                {{-- b --}}
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="buyingInput_{{ $id }}" class="col-form-label">Buying Price*</label>
                                                                        <input min="0.01" step="0.01" name="data[{{ $id }}][buying_price]" type="number"
                                                                            class="form-control buying_field dynamicFld" id="buyingInput_{{ $id }}"
                                                                            value="{{ old("data.$id.buying_price", $pv->buying_price) }}" />
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="priceInput_{{ $id }}" class="col-form-label">MRP*</label>
                                                                        <input min="0.01" step="0.01" name="data[{{ $id }}][actual_price]" type="number"
                                                                            class="form-control price_field dynamicFld" id="priceInput_{{ $id }}"
                                                                            value="{{ old("data.$id.actual_price", $pv->mrp_price) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="discountInput_{{ $id }}"
                                                                            class="col-form-label">Discount%</label>
                                                                        <input min="0" max="100" step="0.1"
                                                                            name="data[{{ $id }}][discount_percentage]"
                                                                            type="number"
                                                                            class="form-control discount_field dynamicFld"
                                                                            id="discountInput_{{ $id }}"
                                                                            value="{{ old("data.$id.discount_percentage", (float) $pv->discount_percentage) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="status_{{ $id }}"
                                                                            class="col-form-label">Not avalb ?</label>
                                                                        <input type="checkbox" class="form-control"
                                                                            name="data[{{ $id }}][status]"
                                                                            id="status_{{ $id }}" value="1"
                                                                            @checked(old("data.$id.status", $pv->status) == 1) />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">&nbsp;</label>
                                                                        <div class="form-action">
                                                                            <i class="fa fa-trash text text-danger trashbtn"
                                                                                onclick="removeCombination('S','{{ $id }}')"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p class="text text-info">No Variation found!</p>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- /.overlay-wrapper --}}
                                </div>
                                {{-- End Variations --}}

                                {{-- Gallery --}}
                                <x-admin.product-gallery :product="$product" :active="$activeStep === 'gallery'" />
                                {{-- end gallery --}}

                            </div>{{-- /.tab-content --}}
                        </div>{{-- /.card-body --}}
                    </div>{{-- /.card --}}
                </div>{{-- /.col-md-12 --}}
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    @push('cssLinks')
        <link rel="stylesheet" href="{{ asset('adminassets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminassets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <style>
            input[type="checkbox"] { transform: scale(0.5); }
            .custom-control-input[type="checkbox"] { transform: none; }
            #actionSection { display: contents; }
            .dsFlx { display: flex; justify-content: end; }
            #actionSection ul { display: flex; list-style: none; padding: 0; margin: 0; gap: 15px; }
            .trashbtn { cursor: pointer; margin-top: 12px; }

        </style>
    @endpush

    @push('scripts')
        {{-- select2 first, so everything below can use it --}}
        <script src="{{ asset('adminassets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            // data from the server (old input after a failed submit, otherwise saved rows)
            const variationData = @json($variationData);
            const serverErrors  = @json($errors->messages());

            const FIELD_IDS = {
                quantity: 'quantityInput_',
                actual_price: 'priceInput_',
                buying_price: 'buyingInput_',
                sku:'skuInput_',
                discount_percentage: 'discountInput_',
            };

            /* ---------- image preview ---------- */
            function previewImage(input) {
                const viewer = document.getElementById('image-viewer');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => { viewer.src = e.target.result; viewer.style.display = 'block'; };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            /* ---------- select2 ---------- */
            $(function () {
                $('.select2').select2();

                function formatColor(state) {
                    if (!state.id || state.id === '0') return state.text;
                    const color = $(state.element).data('color');
                    const $state = $('<span><span class="color-swatch" style="display:inline-block;width:25px;height:25px;margin-right:8px;border-radius:50%;vertical-align:middle;"></span></span>');
                    $state.find('.color-swatch').css('background', color);
                    $state.append(document.createTextNode(state.text));
                    return $state;
                }

                $('.color-picker').select2({
                    width: '100%',
                    templateResult: formatColor,
                    templateSelection: formatColor
                });

                $('.multiOption').on('change', function () { $('.errorVariation').remove(); });

                restoreVariations();
            });

            /* ---------- helpers ---------- */
            const cleanIds = arr => (arr || []).filter(v => v && v !== '0');
            const optionText = (selector, value) => $.trim($(selector + ' option[value="' + value + '"]').text());

            function toggleActionSection() {
                $('#actionSection').toggleClass('d-none', $('.combinations').length === 0);
            }

            // one place for the row markup (no user text is concatenated in)
            function buildRow(color, size, c) {
                const id = color + '_' + size;
                return `<div class="row combinations variation_${c % 2}"
                            data-color="${color}" data-size="${size}"
                            data-combination="${id}" id="pattern_${id}">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="selected_variation_${id}" class="col-form-label">&nbsp;</label>
                            <input type="checkbox" class="form-control" id="selected_variation_${id}" value="${id}" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="sizeInput_${id}" class="col-form-label">Size</label>
                            <input readonly class="form-control" id="sizeInput_${id}" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="colorInpt_${id}" class="col-form-label">Color</label>
                            <input readonly class="form-control" id="colorInpt_${id}" />
                        </div>
                    </div>
                     <div class="col-md-1">
                        <div class="form-group">
                            <label for="skuInput_${id}" class="col-form-label">SKU</label>
                            <input name="data[${id}][sku]" type="text"
                                class="form-control sku_field dynamicFld" id="skuInput_${id}" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="quantityInput_${id}" class="col-form-label">Quantity*</label>
                            <input min="0" step="1" name="data[${id}][quantity]" type="number"
                                class="form-control qty_field dynamicFld" id="quantityInput_${id}" />
                            <input type="hidden" name="data[${id}][original_quantity]" id="originalQty_${id}" value="0" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="buyingInput_${id}" class="col-form-label">Buying Price*</label>
                            <input min="0.01" step="0.01" name="data[${id}][buying_price]" type="number"
                                class="form-control buying_field dynamicFld" id="buyingInput_${id}" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="priceInput_${id}" class="col-form-label">MRP*</label>
                            <input min="0.01" step="0.01" name="data[${id}][actual_price]" type="number"
                                class="form-control price_field dynamicFld" id="priceInput_${id}" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="discountInput_${id}" class="col-form-label">Discount%</label>
                            <input min="0" max="100" step="0.1" name="data[${id}][discount_percentage]" type="number"
                                class="form-control discount_field dynamicFld" id="discountInput_${id}" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="status_${id}" class="col-form-label">Not avalb ?</label>
                            <input type="checkbox" class="form-control" name="data[${id}][status]"
                                id="status_${id}" value="1" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <div class="form-action">
                                <i class="fa fa-trash text text-danger trashbtn" onclick="removeCombination('S','${id}')"></i>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            // names are set with .val() so they are never parsed as HTML
            function fillNames(color, size) {
                const id = color + '_' + size;
                $('#sizeInput_' + id).val(optionText('#brand_size_id', size));
                $('#colorInpt_' + id).val(optionText('#color_id', color));
            }

            /* ---------- create rows from the dropdowns ---------- */
            function makeVariations() {
                const colors = cleanIds($('#color_id').val());
                const sizes  = cleanIds($('#brand_size_id').val());

                $('.errorVariation').remove();

                if (!colors.length || !sizes.length) {
                    $('#variationResponse').prepend(`<div class="col-md-12 errorVariation">
                        <p class="text text-danger">Select color and size first</p>
                    </div>`);
                    return;
                }

                let html = '';
                const created = [];
                let c = $('.combinations').length;

                sizes.forEach(size => {
                    colors.forEach(color => {
                        const id = color + '_' + size;
                        if ($('#pattern_' + id).length) return; // already added
                        html += buildRow(color, size, c++);
                        created.push([color, size]);
                    });
                });

                $('#actionSection').after(html);
                created.forEach(([color, size]) => fillNames(color, size));
                toggleActionSection();

                $('.multiOption').each(function () { $(this).val(null).trigger('change'); });
            }

            /* ---------- restore rows (saved rows or old input) + server errors ---------- */

            function downlaodVariationExcel(){

            }

            function restoreVariations() {
                const keys = Object.keys(variationData || {});
                if (!keys.length) return;

                let html = '', c = 0;
                keys.forEach(key => {
                    const [color, size] = key.split('_');
                    html += buildRow(color, size, c++);
                });
                $('#actionSection').after(html);

                keys.forEach(key => {
                    const [color, size] = key.split('_');
                    const v = variationData[key] || {};
                    fillNames(color, size);
                    $('#quantityInput_' + key).val(v.quantity ?? '');
                    $('#originalQty_' + key).val(v.original_quantity ?? 0);
                    $('#buyingInput_' + key).val(v.buying_price ?? '');
                    $('#skuInput_' + key).val(v.sku ?? '');
                    $('#priceInput_' + key).val(v.actual_price ?? '');
                    $('#discountInput_' + key).val(v.discount_percentage ?? '');
                    $('#status_' + key).prop('checked', v.status == 2);
                });
                toggleActionSection();

                // show server-side errors on the matching input
                $.each(serverErrors || {}, function (field, msgs) {
                    const m = field.match(/^data\.([^.]+)\.(\w+)$/);
                    if (!m || !FIELD_IDS[m[2]]) return;
                    showFieldError($('#' + FIELD_IDS[m[2]] + m[1]), msgs[0]);
                });

                const first = $('#variationForm .is-invalid').first();
                if (first.length) {
                    $('html, body').animate({ scrollTop: first.offset().top - 150 }, 300);
                }
            }

            function showFieldError(input, message) {
                input.addClass('is-invalid')
                    .closest('.form-group').find('.invalid-feedback').remove();
                input.closest('.form-group')
                    .append($('<div class="invalid-feedback d-block"></div>').text(message));
            }

            function clearFieldError(input) {
                input.removeClass('is-invalid')
                    .closest('.form-group').find('.invalid-feedback').remove();
            }

            $(document).on('input', '.dynamicFld', function () { clearFieldError($(this)); });

            /* ---------- row actions ---------- */
            function removeCombination(type, id) {
                $('#pattern_' + id).remove();
                toggleActionSection();
            }

            $('#selectAllChck').on('click', function () {
                const boxes = $('.combinations input[id^="selected_variation_"]');
                const allChecked = boxes.length && boxes.filter(':checked').length === boxes.length;
                boxes.prop('checked', !allChecked);
            });

            $('#deleteAllVariation').on('click', function () {
                const checked = $('.combinations input[id^="selected_variation_"]:checked');
                if (!checked.length) { alert('Select at least one row.'); return; }
                if (!confirm('Remove the selected rows?')) return;
                checked.each(function () { $('#pattern_' + $(this).val()).remove(); });
                toggleActionSection();
            });

            /* ---------- client-side validation (server still validates) ---------- */
            function validateVariations() {
                let ok = true;
                $('.combinations').each(function () {
                    const row = $(this);
                    const qty = row.find('.qty_field'), buyPrice =  row.find('.buying_field'), price = row.find('.price_field'), disc = row.find('.discount_field');

                    const checks = [
                        [qty,   qty.val() !== '' && Number.isInteger(+qty.val()) && +qty.val() >= 0, 'Enter a whole number (0 or more).'],
                        [buyPrice, buyPrice.val() !== '' && +buyPrice.val() > 0, 'Enter a buying price greater than 0.'],
                        [price, price.val() !== '' && +price.val() > 0, 'Enter a price greater than 0.'],
                        // [skuFld, skuFld.val() === '' || (+skuFld.val() >= 0 && +skuFld.val() <= 100), 'GST must be between 0 and 100.'],
                        [disc,  disc.val() === '' || (+disc.val() >= 0 && +disc.val() <= 100), 'Discount must be between 0 and 100.']
                    ];
                    checks.forEach(([el, valid, msg]) => {
                        if (valid) { clearFieldError(el); }
                        else { showFieldError(el, msg); ok = false; }
                    });
                });
                return ok;
            }

            $('#variationForm').on('submit', function (e) {
                $('.errorVariation').remove();

                if ($('.combinations').length === 0) {
                    e.preventDefault();
                    $('#variationResponse').prepend(`<div class="col-md-12 errorVariation">
                        <p class="text text-danger">Add at least one color and size combination.</p>
                    </div>`);
                    return;
                }
                if (!validateVariations()) {
                    e.preventDefault();
                    const first = $('#variationForm .is-invalid').first();
                    $('html, body').animate({ scrollTop: first.offset().top - 150 }, 300);
                }
            });

            $('#downloadAllVariationExcel').on('click', async function () {
                    const btn = $(this);
                    $('.errorVariation').remove();

                    let sizes = cleanIds($('#brand_size_id').val());
                    let colors = cleanIds($('#color_id').val());

                    if (!sizes.length || !colors.length) {
                        sizes = [...new Set($('.combinations').map((_, el) => String($(el).data('size'))).get())];
                        colors = [...new Set($('.combinations').map((_, el) => String($(el).data('color'))).get())];
                    }

                    if (!sizes.length || !colors.length) {
                        $('#variationResponse').prepend(`<div class="col-md-12 errorVariation">
                         <p class="text text-danger">Select color and size first</p></div>`);
                        return;
                    }

                    const fd = new FormData();
                    fd.append('_token', '{{ csrf_token() }}');
                    sizes.forEach(s => fd.append('size_ids[]', s));
                    colors.forEach(c => fd.append('color_ids[]', c));

                    const original = btn.html();
                    btn.prop('disabled', true).text('Generating...');

                    try {
                        const res = await fetch(btn.data('url'), {
                            method: 'POST',
                            body: fd,
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        });

                        if (!res.ok) {
                            let msg = 'Could not generate the file.';
                            try {
                                const j = await res.json();
                                msg = j.errors ? Object.values(j.errors).flat().join(' ') : (j.message || msg);
                            } catch (_) { }
                            $('#variationResponse').prepend($('<div class="col-md-12 errorVariation"></div>')
                                .append($('<p class="text text-danger"></p>').text(msg)));
                            return;
                        }

                        let filename = 'variations.xlsx';
                        const cd = res.headers.get('Content-Disposition');
                        const m = cd && cd.match(/filename\*?=(?:UTF-8'')?"?([^";]+)"?/i);
                        if (m) filename = decodeURIComponent(m[1]);

                        const url = URL.createObjectURL(await res.blob());
                        const a = document.createElement('a');
                        a.href = url; a.download = filename;
                        document.body.appendChild(a); a.click(); a.remove();
                        URL.revokeObjectURL(url);
                    } catch (e) {
                        alert('Network error. Please try again.');
                    } finally {
                        btn.prop('disabled', false).html(original);
                    }
                });

            $('#uploadVariationExcel').on('click', () => $('#variationExcelFile').trigger('click'));

                $('#variationExcelFile').on('change', async function () {
                        const file = this.files[0];
                        this.value = '';
                        if (!file) return;

                        if (!/\.xlsx$/i.test(file.name)) { alert('Please choose an .xlsx file.'); return; }
                        if (file.size > 2 * 1024 * 1024) { alert('File must be 2 MB or smaller.'); return; }
                        if (!confirm('Add the variations from "' + file.name + '"?')) return;

                        const btn = $('#uploadVariationExcel');
                        btn.text('...');
                        $('.errorVariation').remove();
                        btn.prop('disabled', true);

                        const fd = new FormData();
                        fd.append('excel_file', file);
                        fd.append('_token', '{{ csrf_token() }}');

                        try {
                            const res = await fetch(btn.data('url'), {
                                method: 'POST', body: fd,
                                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            });
                            const j = await res.json().catch(() => ({}));
                            btn.html('<i class="fas fa-upload"></i>');
                            if (!res.ok) {
                                const list = Array.isArray(j.errors) ? j.errors : Object.values(j.errors || {}).flat();
                                const $box = $('<div class="col-md-12 errorVariation"></div>');
                                $box.append($('<p class="text text-danger font-weight-bold mb-1"></p>').text(j.message || 'Upload failed.'));
                                if (list.length) {
                                    const $ul = $('<ul class="text-danger"></ul>');
                                    list.forEach(m => $ul.append($('<li></li>').text(m)));
                                    $box.append($ul);
                                }
                                $('#variationResponse').prepend($box);
                                return;
                            }

                            location.reload();   // saved rows are rendered by Blade, so reload to show them
                        } catch (e) {
                            alert('Network error. Please try again.');
                        } finally {
                            btn.prop('disabled', false);
                        }
                    });

        </script>
    @endpush
</x-admin.inner>