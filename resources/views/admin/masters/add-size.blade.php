@section('title', 'Create Size')
<x-admin.inner>
        @php
$params['title'] = 'Create Size';
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
                                <h3 class="card-title">Create Size</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.masters.size')}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>

                            <form action="{{route('admin.masters.store.size')}}" 
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
                                                    placeholder="Size" required>
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