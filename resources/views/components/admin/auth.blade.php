<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  env('APP_NAME')}} :: @yield('title', 'Authentication Page')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminassets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('adminassets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminassets/dist/css/adminlte.min.css')}}">
</head>

<body class="hold-transition login-page">
   {{ $slot }}
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('adminassets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('adminassets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminassets/dist/js/adminlte.min.js') }}"></script>

    <script src="{{asset('adminassets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src=".{{asset('adminassets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{asset('adminassets/dist/js/validation.js') }}"></script>

    <script>
        $('#showPassword').click(function () {
                if ($('#password').attr('type') === 'text') {
                    $('#password').attr('type', 'password');
                    $('.togglePasswordInput').addClass('fa-eye').removeClass('fa-eye-slash');
                } else {
                    $('#password').attr('type', 'text');
                    $('.togglePasswordInput').addClass('fa-eye-slash').removeClass('fa-eye');
                }

            });
            $('#restPassword').validate({
                    rules: {
                        password: {
                            required: true,
                            minlength: 6
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 6 characters long"
                        },
                        confirm_password: {
                            required: "Please repeat your password",
                            equalTo: "Passwords do not match"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
    </script>
</body>

</html>