@section('title', 'Login Page')
<x-admin.auth>

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="javascript:void(0);" class="h1"><b>{{env('APP_NAME')}}</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Enter your new password</p>
                    <div>
                        @if (session('message'))
                            <div class="alertBox">
                                <p class="text-left text text-{{session('response')}}">{{session('message')}}</p>
                            </div>
                        @endif

                    </div>
                <form action="{{ route('login.new.password') }}"
                id="restPassword"
                method="post">
                    @csrf
                    <input type="hidden" value="{{$token}}" name="token" />
                    <input type="hidden" value="{{request('email')}}" name="email" />
                    
                    
                    <div class="input-group mb-3">
                        <label for="password">Password *</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control " value="{{ old('password') }}"
                                placeholder="Password must be at least 6 characters long" id="password">
                            <div class="input-group-append">
                                <a href="javascript:void(0)" data-fld="password" class="input-group-text cursor-pointer showHidePass"
                                    id="showPassword">
                                    <span class="fas fa-eye showPassword"></span>
                                </a>
                            </div>
                    
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="password_confirmation">Confirm Password *</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="form-control"
                                value="{{ old('password_confirmation') }}" placeholder="Confirm Password" id="password_confirmation">
                            <div class="input-group-append">
                                <a href="javascript:void(0)" data-fld="password_confirmation"
                                    class="input-group-text cursor-pointer showHidePass" id="showConfirmPassword">
                                    <span class="fas fa-eye showConfirmPassword"></span>
                                </a>
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Reset</button>
                        </div>
                    </div>
                
                </form>

                

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-admin.auth>