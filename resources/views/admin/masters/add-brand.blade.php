@section('title', 'Create Brand')
<x-admin.inner>
        @php
$params['title'] = 'Create Brand';
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
                        <!-- general form elements -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Create Brand</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.masters.brand')}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>

                            <form action="{{route('admin.masters.store.brand')}}" 
                                enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Name *</label>
                                                        <input type="text" id="name" class="form-control" 
                                                            name="name" value="{{ old('name') }}" 
                                                            placeholder="Brand Name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="brand_code">Code</label>
                                                        <input type="text" id="brand_code" class="form-control" name="brand_code" value="{{ old('brand_code') }}" placeholder="Brand Code"
                                                            />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group text-center">
                                                        <label for="status">Status</label>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" 
                                                                name="status" 
                                                                value="1" 
                                                                type="checkbox" 
                                                                id="status" 
                                                                {{ old('status', true) ? 'checked' : '' }} />
                                                            <label for="status" class="custom-control-label">Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="description" id="description" rows="3"
                                                            placeholder="Write about the brand ...">{{ old('description') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        {{-- logo --}}
                                        <div class="col-md-4">
                                            
                                            
                                            <div class="" id="preview-container" style="display: block; 
                                            margin-top: 15px; height: 200px; width: auto; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; ">
                                                <img id="image-viewer" src="#" alt=""
                                                    class="preview-container"
                                                    style="display: none;max-width: auto; width: 100%;
                                                     max-height: 200px; border-radius: 8px; 
                                                     border: 1px solid #dee2e6; object-fit: cover; display: block;">
                                            </div>
                                            <div class="mb-2">
                                                <label for="brand_logo" class="form-label" style="font-weight: 600; display: block; margin-bottom: 8px;">
                                                    Upload Brand Logo
                                                </label>
                                            
                                                <!-- The File Input Element -->
                                                <input type="file" name="brand_logo" id="brand_logo" accept=".png,.jpg,.jpeg,.webp,.gif" class="form-control"
                                                    onchange="previewImage(this)">
                                            
                                                @error('brand_logo')
                                                    <span class="text-danger" style="color: #dc3545; font-size: 14px; display: block; margin-top: 5px;">
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
                        <!-- /.card -->


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    
</x-admin.inner>