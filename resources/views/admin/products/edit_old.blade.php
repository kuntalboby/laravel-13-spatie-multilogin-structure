@section('title', 'Edit Product :' . $product->name)
<x-admin.inner>
    @php
$params['title'] = 'Edit Product : ' . $product->brand->name . '-' . $product->name;

// work out which tab is open (computed once, not inside the loop)
$nextStep = $product->form_step_counter < config('app.PROD_FORMS_COUNT')
    ? $product->form_step_counter + 1
    : $product->form_step_counter;
$activeStep = strtolower($formSteps[$nextStep] ?? 'basic');

// if the variation form failed validation, reopen that tab so the errors are visible
$hasVariationErrors = collect($errors->keys())
    ->contains(fn($k) => $k === 'data' || str_starts_with($k, 'data.'));
if ($hasVariationErrors) {
    $activeStep = 'variations';
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
                                        <a class="nav-link @if ($slug === $activeStep) active @endif"
                                            data-toggle="pill"
                                            href="#custom-tabs-five-{{ $slug }}"
                                            role="tab"
                                            data-segment="{{ $slug }}"
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
                                        <form action="{{ route('admin.masters.products.store', $product->randomid) }}"
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
                                                                    <input type="text" id="name" class="form-control" name="name"
                                                                        value="{{ old('name', $product->name) }}"
                                                                        placeholder="Product Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="category_id">Category *</label>
                                                                    <select class="form-control select2" name="category_id" id="category_id">
                                                                        <option value="0">Select Category</option>
                                                                        @foreach ($allCategories as $category)
                                                                            <option value="{{ $category->id }}"
                                                                                @selected(old('category_id', $product->category_id) == $category->id)>
                                                                                {{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="brand_id">Brands *</label>
                                                                    <select class="form-control select2" name="brand_id" id="brand_id">
                                                                        <option value="0">Select Brand</option>
                                                                        @foreach ($allBrands as $brand)
                                                                            <option value="{{ $brand->id }}"
                                                                                @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                                                                {{ $brand->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="product_for">Product For *</label>
                                                                    <select class="form-control" name="product_for" id="product_for">
                                                                        <option value="A" @selected(old('product_for', $product->product_for) == 'A')>Adult</option>
                                                                        <option value="K" @selected(old('product_for', $product->product_for) == 'K')>Kids</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="gender_id">Choose Gender *</label>
                                                                    <select class="form-control" name="gender_id" id="gender_id">
                                                                        <option value="0">Select Gender</option>
                                                                        @foreach ($genders as $gender)
                                                                            <option value="{{ $gender->id }}"
                                                                                @selected(old('gender_id', $product->gender_id) == $gender->id)>
                                                                                {{ $gender->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sku">SKU *</label>
                                                                    <input type="text" id="sku" class="form-control" name="sku"
                                                                        value="{{ old('sku', $product->sku) }}" placeholder="sku" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="manufacturing_date">Manufacturing Date (if any)</label>
                                                                    <input type="date" id="manufacturing_date" class="form-control"
                                                                        name="manufacturing_date"
                                                                        value="{{ old('manufacturing_date', $product->manufacturing_date) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="short_description">Short Description</label>
                                                                    <textarea class="form-control" name="short_description"
                                                                        id="short_description" rows="3"
                                                                        placeholder="Write in brief">{{ old('short_description', $product->short_description) }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="long_description">Long Description</label>
                                                                    <textarea class="form-control" name="long_description"
                                                                        id="long_description" rows="3"
                                                                        placeholder="Write about this product">{{ old('long_description', $product->long_description) }}</textarea>
                                                                </div>
                                                            </div>

                                                            {{-- hidden 0 is sent when the checkbox is unchecked --}}
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_featured">Is Featured?</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="is_featured" value="0">
                                                                        <input class="custom-control-input" name="is_featured" value="1"
                                                                            type="checkbox" id="is_featured"
                                                                            @checked(old('is_featured', $product->is_featured)) />
                                                                        <label for="is_featured" class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_promotional">Is Promoted</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="is_promotional" value="0">
                                                                        <input class="custom-control-input" name="is_promotional" value="1"
                                                                            type="checkbox" id="is_promotional"
                                                                            @checked(old('is_promotional', $product->is_promotional)) />
                                                                        <label for="is_promotional" class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="status">Status *</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="hidden" name="status" value="0">
                                                                        <input class="custom-control-input" name="status" value="1"
                                                                            type="checkbox" id="status"
                                                                            @checked(old('status', $product->status)) />
                                                                        <label for="status" class="custom-control-label">Active</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Base Image --}}
                                                    <div class="col-md-3">
                                                        <div id="preview-container"
                                                            style="margin-top: 15px; height: 200px; width: auto; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                                            <img id="image-viewer"
                                                                src="{{ $product->image ? asset('storage/products/' . $product->image) : '' }}"
                                                                alt=""
                                                                style="width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;
                                                                       display: {{ $product->image ? 'block' : 'none' }};">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="image" class="form-label"
                                                                style="font-weight: 600; display: block; margin-bottom: 8px;">
                                                                Upload Product Image
                                                            </label>
                                                            <input type="file" name="image" id="image"
                                                                accept=".png,.jpg,.jpeg,.webp,.gif"
                                                                class="form-control-file" onchange="previewImage(this)">
                                                            @error('image')
                                                                <span class="text-danger"
                                                                    style="font-size: 14px; display: block; margin-top: 5px;">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
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
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="brand_size_id">Choose Size *</label>
                                                            <select class="form-control select2 multiOption" multiple
                                                                name="brand_size_id" id="brand_size_id">
                                                                <option value="0">Select Available Size</option>
                                                                @foreach ($allSizes as $size)
                                                                    <option value="{{ $size->id }}">{{ strtoupper($size->size) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label for="color_id">Choose Color *</label>
                                                            <select multiple class="form-control color-picker multiOption"
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!-- actions -->
                                                        <div class="row justify-content-end d-none" id="actionSection">
                                                            <div class="col-md-12 dsFlx">
                                                                <ul>
                                                                    <li>
                                                                        <button type="button" id="selectAllChck" class="btn btn-info">
                                                                            <i class="fa fa-check"></i> Select All
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button type="button" id="deleteAllVariation" class="btn btn-danger"
                                                                            title="Remove selected rows">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button type="button" id="openModalBtn" class="btn btn-primary">
                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @forelse ($product->productPrices->sortBy(['brand_size_id', 'color_id']) as $pv)
                                                            @php $id = $pv->color_id . '_' . $pv->brand_size_id; @endphp

                                                            <div class="row combinations variation_{{ $loop->index % 2 }}" data-color="{{ $pv->color_id }}"
                                                                data-size="{{ $pv->brand_size_id }}" data-combination="{{ $id }}" id="pattern_{{ $id }}">

                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="selected_variation_{{ $id }}" class="col-form-label">&nbsp;</label>
                                                                        <input type="checkbox" class="form-control" id="selected_variation_{{ $id }}" value="{{ $id }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="sizeInput_{{ $id }}" class="col-form-label">Size</label>
                                                                        <input readonly class="form-control" id="sizeInput_{{ $id }}"
                                                                            value="{{ strtoupper($pv->brandSize->size ?? '') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="colorInpt_{{ $id }}" class="col-form-label">Color</label>
                                                                        <input readonly class="form-control" id="colorInpt_{{ $id }}"
                                                                            value="{{ strtoupper($pv->color->name ?? '') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="quantityInput_{{ $id }}" class="col-form-label">Quantity*</label>
                                                                        <input min="0" step="1" name="data[{{ $id }}][quantity]" type="number"
                                                                            class="form-control qty_field dynamicFld" id="quantityInput_{{ $id }}"
                                                                            value="{{ old("data.$id.quantity", $pv->quantity) }}" />

                                                                        <input type="hidden" name="data[{{ $id }}][original_quantity]" id="originalQty_{{ $id }}"
                                                                                value="{{ old("data.$id.original_quantity", $pv->quantity) }}" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="priceInput_{{ $id }}" class="col-form-label">Actual Price*</label>
                                                                        <input min="0.01" step="0.01" name="data[{{ $id }}][actual_price]" type="number"
                                                                            class="form-control price_field dynamicFld" id="priceInput_{{ $id }}"
                                                                            value="{{ old("data.$id.actual_price", $pv->mrp_price) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="discountInput_{{ $id }}" class="col-form-label">Discount%</label>
                                                                        <input min="0" max="100" step="1" name="data[{{ $id }}][discount_percentage]" type="number"
                                                                            class="form-control discount_field dynamicFld" id="discountInput_{{ $id }}"
                                                                            value="{{ old("data.$id.discount_percentage", (float) $pv->discount_percentage) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label for="status_{{ $id }}" class="col-form-label">Not avalb ?</label>
                                                                        <input type="checkbox" class="form-control" name="data[{{ $id }}][status]" id="status_{{ $id }}" value="1"
                                                                            @checked(old("data.$id.status", $pv->status) == 1) />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">&nbsp;</label>
                                                                        <div class="form-action">
                                                                            <i class="fa fa-trash text text-danger trashbtn" onclick="removeCombination('S','{{ $id }}')"></i>
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
                                    <div class="tab-pane fade @if ($activeStep === 'gallery') show active @endif" id="custom-tabs-five-gallery"
                                        role="tabpanel">
                                        <div class="overlay-wrapper">
                                            <div class="row">
                                                @forelse ($productColors as $uploadedColor)
                                                    <div class="col-md-4">
                                                        <div class="card">
                                                            <div class="card-header bg-secondary">
                                                                <h3 class="card-title">{{ $uploadedColor->name }}</h3>
                                                            </div>
                                                            <div class="card-header" style="background:{{ $uploadedColor->color_code }}"></div>
                                                            <div class="card-body">

                                                                <div class="dropzone-box" data-color="{{ $uploadedColor->id }}"
                                                                    data-sort-url="{{ route('admin.masters.products.color-media.sort', $product->randomid) }}"
                                                                    data-url="{{ route('admin.masters.products.color-media.upload', $product->randomid) }}">
                                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                                    <p class="mb-0">Drag &amp; drop files here, or click to browse</p>
                                                                    <small class="text-muted">Images or videos, max 5 MB each</small>
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

                    /* gallery */
                    .dropzone-box {
            border: 2px dashed #adb5bd; border-radius: 8px; padding: 18px 10px;
            text-align: center; cursor: pointer; color: #6c757d; transition: .15s;
        }
        .dropzone-box i { font-size: 28px; display: block; margin-bottom: 6px; }
        .dropzone-box:hover, .dropzone-box.dragover { border-color: #007bff; background: #f0f7ff; color: #007bff; }

        .dz-list { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .dz-item {
            position: relative; width: 90px; height: 90px; border-radius: 6px;
            border: 1px solid #dee2e6; overflow: hidden; background: #f8f9fa;
        }
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
        .dz-uploading { padding: 6px; font-size: 11px; display: flex; flex-direction: column; justify-content: center; }
        .dz-uploading .dz-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-bottom: 4px; }
        .dz-uploading .progress { height: 6px; }
        .dz-error { border-color: #dc3545; color: #dc3545; }
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantityInput_${id}" class="col-form-label">Quantity*</label>
                            <input min="0" step="1" name="data[${id}][quantity]" type="number"
                                class="form-control qty_field dynamicFld" id="quantityInput_${id}" />
                            <input type="hidden" name="data[${id}][original_quantity]" id="originalQty_${id}" value="0" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="priceInput_${id}" class="col-form-label">Actual Price*</label>
                            <input min="0.01" step="0.01" name="data[${id}][actual_price]" type="number"
                                class="form-control price_field dynamicFld" id="priceInput_${id}" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="discountInput_${id}" class="col-form-label">Discount%</label>
                            <input min="0" max="100" step="1" name="data[${id}][discount_percentage]" type="number"
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
                    const qty = row.find('.qty_field'), price = row.find('.price_field'), disc = row.find('.discount_field');

                    const checks = [
                        [qty,   qty.val() !== '' && Number.isInteger(+qty.val()) && +qty.val() >= 0, 'Enter a whole number (0 or more).'],
                        [price, price.val() !== '' && +price.val() > 0, 'Enter a price greater than 0.'],
                        [disc,  disc.val() === '' || (+disc.val() >= 0 && +disc.val() <= 100), 'Discount must be between 0 and 100.'],
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

            // gallery
            const CSRF = '{{ csrf_token() }}';
                const MAX_BYTES = 5 * 1024 * 1024;
                const ALLOWED = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm'];

                $('.dropzone-box').each(function () {
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
                        if (file.size > MAX_BYTES) return showTempError(box, file.name, 'Over 5 MB.');
                        uploadOne(box, file);
                    });
                }

                function uploadOne(box, file) {
                    const $item = $('<div class="dz-item dz-uploading"><div class="dz-name"></div>' +
                        '<div class="progress"><div class="progress-bar" style="width:0%"></div></div></div>');
                    $item.find('.dz-name').text(file.name);
                    box.closest('.card-body').find('.dz-list').append($item);

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
                    box.closest('.card-body').find('.dz-list').append($e);
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

                $(document).on('click', '.dz-del', function () {
                    if (!confirm('Delete this file?')) return;
                    const target = $(this).data('target');
                    $.ajax({
                        url: $(this).data('url'), type: 'DELETE', data: { _token: CSRF },
                        success: () => $(target).remove(),
                        error: () => alert('Could not delete the file.'),
                    });
                });

                $('.dz-list').each(function () {
                        const list = this;
                        const box = $(list).closest('.card-body').find('.dropzone-box');
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
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    @endpush
</x-admin.inner>