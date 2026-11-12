<x-admin.inner>
    @php
$params['title'] = 'All Colors';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Color List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.masters.create.color')}}"
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
                                        <th style="width: 20px">Color Shade</th>
                                        <th style="width: 30px">Name</th>
                                        <th style="width: 60px">Description</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($allcolors as $key => $color)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td style="background: {{ $color->color_code }}; 
                                                width: 20px; height: 20px; padding: 5px;"></td>

                                            <td> {{ ucfirst($color->name) }} </td>
                                            <td> {{ $color->description }} </td>
                                            <td>
                                                @if ($color->status == 0)
                                                    <i class="fas fa-check text-success"></i>
                                                @else
                                                    <i class="fas fa-times text-danger"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('admin.masters.editcolor', $color->randomid) }}"
                                                            class="btn mr-5" title="Edit"><i
                                                                class="fa fa-pen text text-info"></i></a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <a onclick="if(confirm('Are you sure you want to delete this & its child color?')){ return true;}else{ return false; }"
                                                            href="{{ route('admin.masters.delete', ['color', $color->randomid]) }}"
                                                            title="Delete"><i class="fa fa-trash text text-danger"></i></a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                                    <tr>
                                                        <th colspan="6" class="text text-warning text-center">No color found</th>
                                                    </tr>
                                        </div>
                                    @endforelse

                        </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                       <div class="float-right">{{ $allcolors->links('pagination::bootstrap-4') }} </div>  
                    </div>
                </div>


            </div>

        </div>
        </div><!-- /.container-fluid -->
    </section>

</x-admin.inner>