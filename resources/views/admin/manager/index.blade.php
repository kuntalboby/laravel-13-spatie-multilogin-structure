<x-admin.inner>
    @php
$params['title'] = 'All Managers';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Manager List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.manager.create')}}"
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
                                        <th style="width: 20px">First Name</th>
                                        <th style="width: 20px">Last Name</th>
                                        <th style="width: 30px">Email</th>
                                        <th style="width: 20px">Gender</th>
                                        <th style="width: 10px">Status</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ ucfirst($user->first_name) }}
                                            </td>
                                            <td>
                                                {{ ucfirst($user->last_name) }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                {{ ($user->gender == 'M' ? 'Male' : ($user->gender == 'F' ? 'Female' : 'Transgender'))  }}
                                            </td>
                                            <td>
                                                @if ($user->status == 0)
                                                    <sapn class="text text-success">Active</sapn>
                                                @elseif ($user->status == 1)
                                                        <sapn class="text text-info">Pending</sapn>
                                                @elseif ($user->status == 2)
                                                    <sapn class="text text-warning">Suspended</sapn>
                                                @elseif ($user->status == 3)
                                                    <sapn class="text text-danger">Inactive</sapn>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{{ route('admin.manager.edit', $user->randomid) }}"
                                                            class="btn mr-5" title="Edit"><i
                                                                class="fa fa-pen text text-info"></i></a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <a onclick="if(confirm('Are you sure you want to delete?')){ return true;}else{ return false; }"
                                                            href="{{ route('admin.manager.delete', $user->randomid) }}"
                                                            title="Delete"><i class="fa fa-trash text text-danger"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                             <tr>
                                                <th colspan="7" class="text text-warning text-center">No Manager found</th>
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