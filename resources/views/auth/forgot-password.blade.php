<x-admin.auth>

    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>{{ env('APP_NAME') }}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                    <div>
                        @if (session('message'))
                            <div class="alertBox">
                                <p class="text-left text text-{{session('response')}}">{{session('message')}}</p>
                            </div>
                        @endif
                        
                    </div>
                <form action="{{ route('admin.login.generateResetPassword') }}" method="post" id="forgorPassword">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email"
                        name="email"
                        class="form-control" placeholder="Enter your email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
    
                <p class="mt-3 mb-1">
                    <a href="{{ route('admin.login') }}">Login</a>
                </p>
                
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</x-admin.auth>