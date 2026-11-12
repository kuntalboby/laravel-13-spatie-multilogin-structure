@section('title', 'Brand Sizes')
<x-admin.inner>
    @php
$params['title'] = 'Brand Sizes';
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
                        
                        <div class="card card-primary card-outline ">
                            <div class="card-header">
                                <h3 class="card-title">Add Size </h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.masters.brand.createSize', $brand->randomid)}}" class="btn btn-primary text text-light">
                                        <i class="fas fa-plus"></i> Create
                                    </a>
                            </div>
                        </div>
                        
                        </div>


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
</x-admin.inner>