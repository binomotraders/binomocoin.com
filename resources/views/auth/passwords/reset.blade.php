<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Binomo Coin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('wallet/images/favicon.png') }}">
    <link href="{{ asset('wallet/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">                        
                                <div class="text-center pt-4">
                                    <a href="{{ route('login') }}" class="logo logo-admin"><img src="{{ asset('wallet/images/binomo-coin-dark.png') }}" height="65" alt="logo"></a>
                                </div>
                                <div class="auth-form">

                                    @error('email')
                                        <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                                            <p class="m-0"><strong>Oh snap!</strong> {{ $message }}</p>
                                        </div>
                                    @enderror

                                    @error('password')
                                        <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                                            <p class="m-0"><strong>Oh snap!</strong> {{ $message }}</p>
                                        </div>
                                    @enderror

                                    <h4 class="text-center mb-4">{{ __('Reset Password') }}</h4>
                                    <form method="POST" action="{{ route('password.update') }}" class="validateFrom">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group">
                                            <label><strong>{{ __('E-Mail Address') }}</strong></label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                                        </div>

                                        <div class="form-group">
                                            <label><strong>{{ __('New Password') }}</strong></label>
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label><strong>{{ __('Confirm New Password') }}</strong></label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('wallet/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('wallet/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('wallet/js/custom.min.js') }}"></script>
    <script src="{{ asset('wallet/js/deznav-init.js') }}"></script>

    <!-- Jquery Validation -->
    <script src="{{ asset('wallet/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Form validate init -->
    <script src="{{ asset('wallet/js/plugins-init/jquery.validate-init.js') }}"></script>

    <script>
        $('form').submit(function(){
            if ($(this).valid()) {
                $(this).find('button[type=submit]').prop('disabled', true);
            } else {
                $(this).find('button[type=submit]').prop('disabled', false);
            }
        });
    </script>
</body>
</html>