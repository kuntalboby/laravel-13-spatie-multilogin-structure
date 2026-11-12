<x-admin.inner>
    @php
$params['title'] = 'All Brands';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Brand List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.masters.create.brand')}}"
                                    class="btn btn-primary text text-light">
                                    <i class="fas fa-plus"></i> Create
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30px">#</th>
                                        <th style="width: 2px">&nbsp;</th>
                                        <th style="width: 60px">Name</th>
                                        <th style="width: 60px">Code</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($allbrands as $key => $brand)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                 @if ($brand->brand_logo && Storage::disk('public')->exists('uploads/brands/' . $brand->brand_logo))
                                                <img src="{{ asset('storage/uploads/brands/' . $brand->brand_logo) }}" 
                                                alt="{{ $brand->name }}"
                                                    class="img-thumbnail" style="max-width: 50px; max-height: 50px;" />
                                                  @else
                                                    <img src="{{ asset('storage/icons/noimg.png') }}" alt="No image" class="img-thumbnail" style="max-width: 50px; max-height: 50px;"  />
                                                @endif  
                                            </td>
                                            <td>{{ $brand->brand_code }}</td>
                                            <td>
                                                {{ $brand->brand_code }}
                                            </td>
                                            <td>
                                                @if ($brand->status == 0)
                                                    <i class="fas fa-check text-success"></i>
                                                @else
                                                    <i class="fas fa-times text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a 
                                                            href="{{ route('admin.masters.brand.sizes', $brand->randomid) }}" 
                                                            class="btn mr-1" title="Brand Sizes"><i
                                                                class="fas fa-clipboard-list text text-warning"></i>
                                                            </a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="{{ route('admin.masters.editbrand', $brand->randomid) }}"
                                                            class="btn mr-2" title="Edit"><i
                                                                class="fa fa-pen text text-info"></i></a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a onclick="if(confirm('Are you sure you want to delete this & its child brand?')){ return true;}else{ return false; }"
                                                            href="{{ route('admin.masters.delete', ['brand', $brand->randomid]) }}"
                                                            title="Delete"><i class="fa fa-trash text text-danger"></i></a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                                    <tr>
                                                        <th colspan="5" class="text text-warning text-center">No brand found</th>
                                                    </tr>
                                        </div>
                                    @endforelse

                        </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
        </div><!-- /.container-fluid -->
    </section>

</x-admin.inner>