@section('title', 'Edit Permission')
<x-admin.inner>
    @php
$params['title'] = 'Roles & Permissions';
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
                        
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="nav-link {{ $role->name == 'manager' ? 'active' : '' }}" 
                                            href="{{ route('admin.permissions.edit', 'manager') }}" 
                                            aria-controls="custom-tabs-five-manager"
                                            aria-selected="{{ $role->name == 'manager' ? true : false }}">Manager</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $role->name == 'customer' ? 'active' : '' }}"
                                            href="{{ route('admin.permissions.edit', 'customer') }}" 
                                            aria-controls="custom-tabs-five-customer"
                                            aria-selected="{{ $role->name == 'customer' ? true : false }}">Customer</a>
                                    </li>
                                    

                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-five-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-five- @php $role @endphp" role="tabpanel"
                                        aria-labelledby="custom-tabs-five- @php $role @endphp -tab">
                                        <div class="overlay-wrapper">
                                            {{-- strarts --}}
                                    <form method="POST" action="{{ route('admin.permissions.update', $role->name) }}">
                                            @csrf
                                            @method('PUT')
                                            
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">Permissions</h3>
                                                <div class="card-tool">
                                                    <div class="custom-control custom-checkbox float-right">
                                                        <input class="custom-control-input selectAll" type="checkbox"
                                                            id="grrp_all"
                                                            data-mode="A"
                                                            />
                                                        <label for="grrp_all" class="custom-control-label text-white">Select All</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($modules as $module)
                                                <div class="card-body">
                                                        
                                                        <div class="row mx-5">
                                                            <div class="col-md-12 border-bottom mb-3">
                                                                <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input selectAll"
                                                                     data-slug="{{ $module->slug }}"
                                                                     data-mode="individual"
                                                                    type="checkbox" name="{{ $module->slug }}" id="grrp_{{ $module->id }}" 
                                                                    />
                                                                    <label for="grrp_{{ $module->id }}" class="custom-control-label">{{$module->name}}</label>
                                                                </div>
                                                            </div>
                                                            @foreach($module->actions as $action)
                                                            @php($perm = $module->slug . '.' . $action)
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input class="custom-control-input permissionCheckboxes" 
                                                                            type="checkbox" 
                                                                            data-slug="{{ $module->slug }}"
                                                                            id="permsn_{{ $perm }}"
                                                                            name="permissions[]" value="{{ $perm }}" 
                                                                            @checked(in_array($perm, $granted))
                                                                            />
                                                                        <label for="permsn_{{ $perm }}"
                                                                                class="custom-control-label">{{ ucfirst($action) }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>                            
                                                    
                                                </div>
                                                
                                            @endforeach
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                @if(session('success'))
                                                    <p>{{ session('success') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </form>        
                                            {{-- end --}}
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        
                        </div>


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
</x-admin.inner>