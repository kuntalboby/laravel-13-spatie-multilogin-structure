@section('title', 'Login Page')
<x-admin.auth>

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="javascript:void(0);" class="h1"><b>{{env('APP_NAME')}}</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                    <div>
                        @if (session('message'))
                            <div class="alertBox">
                                <p class="text-left text text-{{session('response')}}">{{session('message')}}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="text text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="list-style: none">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                <form action="{{ route('admin.login.submit') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="form-control
                            @error('email') is-invalid @enderror
                            " placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Password" id="password">
                        <div class="input-group-append">
                            <a  href="javascript:void(0)" class="input-group-text cursor-pointer" id="showPassword">
                                <span class="fas fa-eye togglePasswordInput"></span>
                            </a>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @error('password')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('admin.login.forgot-password') }}">I forgot my password</a>
                </p>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-admin.auth>