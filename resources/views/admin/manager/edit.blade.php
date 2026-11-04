@section('title', 'Manager :' . $user->first_name)
<x-admin.inner>
    @php
$params['title'] = 'Manager ' . $user->first_name;
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
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Manager : {{ $user->first_name . ' ' . $user->last_name }}</h3>
                            <div class="card-tools">

                                <a href="{{route('admin.manager.index')}}" class="btn btn-light">
                                    Back
                                </a>

                            </div>
                        </div>

                        <form action="{{route('admin.manager.update', ['slug' => $user->randomid])}}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="gender">Gender *</label>
                                            <select class="form-control" name="gender" id="gender">
                                                @foreach ($gender as $gk => $gen)
                                                <option value="{{ $gk }}"
                                                @if ($user->gender == $gk)
                                                   selected="selected" 
                                                @endif
                                                >{{$gen}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="first_name">First Name *</label>
                                            <input type="text" id="first_name" class="form-control" name="first_name"
                                                value="{{ old('first_name', $user->first_name) }}" placeholder="Manager's first name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="last_name">Last Name *</label>
                                            <input type="text" id="last_name" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                                placeholder="Manager's last name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="text" id="email" class="form-control" name="email" value="{{ old('email', $user->email) }}"
                                                placeholder="Manager's email" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        
                                            <div class="form-group">
                                                <label for="status">Account Status *</label>
                                                <select class="form-control" name="status" id="status">
                                                    @foreach ($status as $sk => $st)
                                                        <option value="{{ $sk }}"
                                                        @if ($user->status == $sk)
                                                               selected="selected" 
                                                        @endif
                                                        >{{$st}}</option>
                                                    @endforeach
                                                </select>
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

                    {{-- Password Form --}}
                     <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Update Password For: {{ $user->first_name . ' ' . $user->last_name }}</h3>
                        </div>

                        <form action="{{route('admin.manager.updatePassword', ['slug' => $user->randomid])}}"
                            enctype="multipart/form-data" method="post" id="passwordForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <label for="current_password">Current Password *</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" 
                                                class="form-control" placeholder="Current Password" 
                                                value="{{ old('current_password') }}"
                                                id="current_password">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" data-fld="current_password" class="input-group-text cursor-pointer showHidePass" id="showCurrentPassword">
                                                    <span class="fas fa-eye showCurrentPassword"></span>
                                                </a>
                                            </div>
                                        @error('current_password')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="password">Password *</label>
                                        <div class="input-group">
                                            <input type="password" 
                                            name="password" class="form-control " 
                                            value="{{ old('password') }}"
                                            placeholder="Password must be at least 6 characters long" 
                                            id="password">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" data-fld="password" class="input-group-text cursor-pointer showHidePass" id="showPassword">
                                                    <span class="fas fa-eye showPassword"></span>
                                                </a>
                                            </div>
                                        
                                        @error('password')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password_confirmation">Confirm Password *</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation"
                                             class="form-control" 
                                             value="{{ old('password_confirmation') }}"
                                            placeholder="Confirm Password" id="password_confirmation">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" data-fld="password_confirmation" class="input-group-text cursor-pointer showHidePass" id="showConfirmPassword">
                                                    <span class="fas fa-eye showConfirmPassword"></span>
                                                </a>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
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


                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

</x-admin.inner>