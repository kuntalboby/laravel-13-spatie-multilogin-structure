@section('title', 'Create Color')
<x-admin.inner>
        @php
$params['title'] = 'Create Color';
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
                                <h3 class="card-title">Create Color</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.masters.color')}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>

                            <form action="{{route('admin.masters.store.color')}}" 
                                enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="text" id="name" class="form-control" 
                                                    name="name" value="{{ old('name') }}" 
                                                    placeholder="Color name" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="color_code">Color Code *</label>
                                            <div class="input-group">
                                                <input type="text" name="color_code" class="form-control" placeholder="Color Code"
                                                    value="{{ old('color_code') }}" id="color_code">
                                                <div class="input-group-append">
                                                    <a  id="showColorCode" href="javascript:void(0)"
                                                        class="input-group-text cursor-pointer">
                                                        <span class=""></span>
                                                    </a>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
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
                                                <textarea class="form-control" name="description" id="description"  rows="3" 
                                                    placeholder="Write about the color ...">{{ old('description') }}</textarea>
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