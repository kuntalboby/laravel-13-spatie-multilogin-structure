@section('title', 'Sizes of ' . $brand->name)
<x-admin.inner>
    @php
$params['title'] = 'Sizes of ' . $brand->name;
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
                                <h3 class="card-title">List of Sizes </h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.masters.brand.createSize', $brand->randomid)}}" class="btn btn-primary text text-light">
                                        <i class="fas fa-plus"></i> Create
                                    </a>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <table class="table table-bordered">
                                <thead>
                                    {{-- <tr><th colspan="4">Catename</th></tr> --}}
                                    <tr>
                                        <th style="width: 30px">#</th>
                                        <th style="width: 60px">Size</th>
                                        <th style="width: 10px">Size For</th>
                                        <th style="width: 50px">Target Age</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listOfSizes as $catName => $Category)
                                        <tr class="bg-info">
                                            <td colspan="4">{{ $catName }}</td>
                                        </tr>
                                        @foreach ($Category as $ks=>$sizes)
                                               <tr>
                                                <th>{{ $ks+1 }}</th>
                                                <th>{{ $sizes->size }}</th>
                                                <th>{{ ($sizes->product_type =='T' ? 'Topwear' : ($sizes->product_type == 'B' ? 'Bottomwear': 'Shoes'))  }}</th>
                                                <th>{{ $sizes->size_of == 'K' ? 'Kids' : 'Adult' }}</th>
                                               </tr>
                                        @endforeach
                                        <tr></tr>
                                    @empty
                                        <tr>
                                            <th colspan="5" class="text text-warning text-center">No size found</th>
                                        </tr>
                                        </div>
                                    @endforelse
                            
                                </tbody>
                            </table>
                        </div>
                        
                        </div>


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
</x-admin.inner>