<x-admin.inner>
    @php
$params['title'] = 'All Sizes';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Size List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.masters.create.size')}}"
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
                                        <th style="width: 60px">Name</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($allsize as $key => $size)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ ucfirst($size->name) }}
                                            </td>

                                            <td>
                                                @if ($size->status == 0)
                                                    <i class="fas fa-check text-success"></i>
                                                @else
                                                    <i class="fas fa-times text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('admin.masters.editsize', $size->randomid) }}"
                                                            class="btn mr-5" title="Edit"><i
                                                                class="fa fa-pen text text-info"></i></a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <a onclick="if(confirm('Are you sure you want to delete this & its child size?')){ return true;}else{ return false; }"
                                                            href="{{ route('admin.masters.delete', ['size', $size->randomid]) }}"
                                                            title="Delete"><i class="fa fa-trash text text-danger"></i></a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
        </div><!-- /.container-fluid -->
    </section>

</x-admin.inner>