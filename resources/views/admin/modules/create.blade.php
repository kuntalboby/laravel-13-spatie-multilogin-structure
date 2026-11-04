@section('title', 'Create Module')
<x-admin.inner>
        
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
                                <h3 class="card-title">Create Module</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.modules.index')}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>

                            <form action="{{route('admin.modules.store')}}" 
                                enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="title">Name *</label>
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" 
                                                    placeholder="Module name (e.g. Category)" required>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="title">Actions *</label>
                                                <input type="text" class="form-control" name="actions" 
                                                    value="{{ old('actions') }}" placeholder="view, add, update, delete" required>
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