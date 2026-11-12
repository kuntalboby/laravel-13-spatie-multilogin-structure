@section('title', 'Add Product')
<x-admin.inner>
    @php
$params['title'] = 'Add Product';
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
                                    <p class="text-center text text-{{session('response')}}">{{session('message')}}</p>
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

                                        <li class="nav-item">
                                            <a class="nav-link 
                                                @if ($k === 1) active @endif " 
                                                href="javascript:void()" 
                                                data-segment="{{strtolower($formStep)}}"
                                                aria-controls="segmentsSwitch custom-tabs-five-{{strtolower($formStep)}}"
                                                aria-selected="true">{{$formStep}}</a>
                                        </li>
                                    @endforeach
                                    
                                    

                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-five-tabContent">
                                    
                                    <div class="tab-pane fade show active" id="custom-tabs-five-basic" role="tabpanel"
                                        aria-labelledby="custom-tabs-five-basic-tab">
                                        <div class="overlay-wrapper">
                                            {{-- Basic info form strarts --}}
                                        <form action="{{route('admin.masters.products.store')}}" 
                                            enctype="multipart/form-data" 
                                            method="post">
                                            @csrf
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text text-danger">
                                                            *N.B-Category, brand, gender and product-for cannot be changed after the product is created.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="name">Name *</label>
                                                                    <input type="text" id="name" class="form-control" name="name" 
                                                                        value="{{ old('name') }}"
                                                                        placeholder="Product Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="category_id">Category *</label>
                                                                    <select class="form-control select2" 
                                                                        name="category_id" id="category_id">
                                                                        <option value="0">Select Category</option>
                                                                        @foreach ($allCategories as $category)
                                                                            <option 
                                                                            @if (old('category_id') == $category->id)
                                                                                selected="selected"
                                                                            @endif
                                                                            value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                                            <option 
                                                                            @if (old('brand_id') == $brand->id)
                                                                                selected="selected"
                                                                            @endif
                                                                            value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="product_for">Product For *</label>
                                                                    <select class="form-control" 
                                                                        name="product_for" id="product_for">
                                                                        <option 
                                                                        @if (old('product_for') == 'A')
                                                                            selected="selected"
                                                                        @endif
                                                                        value="A">Adult</option>
                                                                        <option 
                                                                         @if (old('product_for') == 'K')
                                                                            selected="selected"
                                                                        @endif
                                                                        value="K">Kids</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="gender_id">Choose Gender *</label>
                                                                    <select class="form-control" name="gender_id" id="gender_id">
                                                                        <option value="0">Select Gender</option>
                                                                        @foreach ($genders as $gender)
                                                                            <option 
                                                                             @if (old('gender_id') == $gender->id)
                                                                                selected="selected"
                                                                            @endif

                                                                            value="{{ $gender->id }}">{{ $gender->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sku">GST (If any)</label>
                                                                    <input type="number" id="gst" class="form-control" name="gst"
                                                                        value="{{ old('gst') }}" placeholder="gst " />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="manufacturing_date">Manufacturing Date (if any)</label>
                                                                    <input type="date" id="manufacturing_date" class="form-control" 
                                                                    name="manufacturing_date" value="{{ old('manufacturing_date') }}" placeholder="sku " />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="short_description">Short Description</label>
                                                                    <textarea class="form-control" name="short_description" 
                                                                    id="short_description" rows="3"
                                                                        placeholder="Write in brief">{{ old('short_description') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="long_description">Long Description</label>
                                                                    <textarea class="form-control" name="long_description" id="long_description" rows="3"
                                                                        placeholder="Write about this product">{{ old('long_description') }}</textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_featured">Is Featured?</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input" name="is_featured" value="1" type="checkbox" id="is_featured"
                                                                            {{ old('is_featured', false) ? 'checked' : '' }} />
                                                                        <label for="is_featured" class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="is_promotional">Is Promoted</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input" name="is_promotional" value="1"
                                                                         type="checkbox" id="is_promotional"
                                                                            {{ old('is_promotional', false) ? 'checked' : '' }} />
                                                                        <label for="is_promotional" class="custom-control-label">Yes</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group text-center">
                                                                    <label for="status">Status *</label>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input" name="status" value="1" type="checkbox" id="status"
                                                                            {{ old('status', true) ? 'checked' : '' }} />
                                                                        <label for="status" class="custom-control-label">Active</label>
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
                                                                    <div class="" id="preview-container"
                                                                        style="mb-3 display: block;margin-top: 15px; height: 200px; width: auto; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; ">
                                                                        <img id="image-viewer" src="#" alt="" class="preview-container"
                                                                            style="display: none;max-width: auto; width: 100%;
                                                                                                                                                                max-height: 200px; border-radius: 8px; 
                                                                                                                                                                border: 1px solid #dee2e6; object-fit: cover; display: block;">
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <!-- The File Input Element -->
                                                                        <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.webp,.gif" class="form-control-file"
                                                                            onchange="previewImage(this)">

                                                                        @error('image')
                                                                            <span class="text-danger" style="color: #dc3545; font-size: 14px; display: block; margin-top: 5px;">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                            </div>
                                                            {{-- related products --}}
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="related_product_hash_tag">Tags</label>
                                                                    <textarea class="form-control" name="related_product_hash_tag" id="related_product_hash_tag" rows="3"
                                                                        placeholder="Same tag products will be showing as a related products">{{ old('related_product_hash_tag') }}</textarea>
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
                                              

                                            {{-- end --}}
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                        
                        </div>


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->

        </section>
        @push('cssLinks')
            <link rel="stylesheet" href="{{asset('adminassets/plugins/select2/css/select2.min.css') }}">
            <link rel="stylesheet" href="{{asset('adminassets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        @endpush
        @push('scripts')
            <script>
                $(function () {
                   $('.select2').select2(); 
                });

                $('.segmentsSwitch').on('click',function(){

                });
            </script>
                    <script src="{{asset('adminassets/plugins/select2/js/select2.full.min.js') }}"></script>

        @endpush
</x-admin.inner>