@section('title', 'Edit Category :' . $category->name)
<x-admin.inner>
        @php
$params['title'] = 'Category' . $category->name;
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
                                <h3 class="card-title">Create Cateroy</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.masters.category')}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>

                            <form action="{{route('admin.masters.update', ['slug' => $category->randomid])}}" 
                                enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Name *</label>
                                                <input type="text" id="name" class="form-control" 
                                                    name="name" value="{{ old('name', $category->name) }}" 
                                                    placeholder="category name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="parentCat">Parent Category *</label>
                                                <select class="form-control"
                                                name="parent_id" 
                                                id="parentCat">
                                                    <option value="0">Parent</option>
                                                    @foreach ($allcategory as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group text-center">
                                                <label for="is_featured">Is Featured ?</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" 
                                                        name="featured" 
                                                        value="1"
                                                        type="checkbox" 
                                                        id="is_featured"
                                                        @if ($category->featured == '0')
                                                            checked="checked"
                                                        @endif
                                                        {{ old('featured') ? 'checked' : '' }} />
                                                    <label for="is_featured" class="custom-control-label">Yes</label>
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
                                                        @if ($category->status == '0')
                                                            checked="checked"
                                                        @endif 
                                                        {{ old('status') ? 'checked' : '' }} />
                                                    <label for="status" class="custom-control-label">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description *</label>
                                                <textarea class="form-control" name="description" id="description"  rows="3" 
                                                    placeholder="Write about the category ...">{{ old('description', $category->description) }}</textarea>
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