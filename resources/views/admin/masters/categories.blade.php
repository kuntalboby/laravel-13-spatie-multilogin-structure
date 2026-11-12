<x-admin.inner>
    @php
$params['title'] = 'All Categories';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Category List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.masters.create.category')}}" class="btn btn-primary text text-light">
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
                                        <th style="width: 60px">Name</th>
                                        <th style="width: 10px">Featured?</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($allcategory as $key => $category)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ ucfirst($category->name) }}
                                            </td>
                                            <td>
                                                @if ($category->featured == 0)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            <td>
                                                @if ($category->status == 0)
                                                    <i class="fas fa-check text-success"></i>
                                                @else
                                                    <i class="fas fa-times text-danger"></i>
                                                @endif                                       
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('admin.masters.editcategory', $category->randomid) }}" class="btn mr-5" title="Edit"><i
                                                                class="fa fa-pen text text-info"></i></a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <a 
                                                        onclick="if(confirm('Are you sure you want to delete this & its child category?')){ return true;}else{ return false; }"
                                                        href="{{ route('admin.masters.delete', ['category', $category->randomid]) }}"
                                                            title="Delete"><i class="fa fa-trash text text-danger"></i></a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="5" class="text text-warning text-center">No category found</th>
                                        </tr>
                                        </div>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        
                    </div>


                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

</x-admin.inner>