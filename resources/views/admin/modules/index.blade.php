<x-admin.inner>
    @php
        $params['title'] = 'All Modules';
        // $params['title'] = 'All Modules';
    @endphp
        <x-admin.breadcrumb :params="$params" />
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="card-header">
                                <h3 class="card-title">Module List</h3>
                                <div class="card-tools">
                                    <a href="{{route('admin.modules.create')}}" class="btn btn-primary text text-light">
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
                                            <th>Name</th>
                                            <th style="width: 50px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modules as $key => $module)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ ucfirst($module->name) }}
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <a href="javascript:void(0);" class="btn mr-5" title="Edit"><i class="fa fa-pen text text-info"></i></a></div>
                                                        <div class="col-md-8">
                                                            <form method="POST" action="{{ route('admin.modules.destroy', $module) }}"
                                                                onsubmit="return confirm('Delete this module and its permissions?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn text-white text-center"><i class="fa fa-trash text text-danger"></i></button>
                                                            </form>
                                                            {{-- <a href="{{ route('admin.modules.destroy', $module) }}" title="Delete"><i class="fa fa-trash text text-danger"></i></a> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div> --}}
                        </div>
       
                       
                    </div>
                   
                </div>               
            </div><!-- /.container-fluid -->
        </section>
    
</x-admin.inner>