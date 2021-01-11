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
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button> 
                                                <p class="m-0"><strong>Oh snap!</strong> {{$error}}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    @if(Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button> 
                                            <p class="m-0"><strong>Oh snap!</strong> {!! session('error') !!}</p>
                                        </div>
                                    @endif

                                    @if (Session::has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <p class="m-0">{{ Session::get('success') }}</p>
                                        </div>
                                    @endif
                                    
                                    @if (!Session::has('verify'))
                                        <h4 class="text-center mb-4">Sign up your account</h4>
                                        <form method="POST" action="{{ route('usersignup') }}" class="validateFrom">
                                            @csrf
                                            <div class="form-group">
                                                <label class="mb-1"><strong>{{ __('Name') }}</strong></label>
                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1"><strong>{{ __('E-Mail Address') }}</strong></label>
                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1"><strong>{{ __('Password') }}</strong></label>
                                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1"><strong>{{ __('Confirm Password') }}</strong></label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary btn-block">Sign Me Up</button>
                                            </div>
                                        </form>
                                        <div class="new-account mt-3">
                                            <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign In</a></p>
                                        </div>
                                    @else
                                        <h4 class="text-center mb-4">Email Verification</h4>
                                        <form method="POST" action="{{ route('verifysignupotp') }}" class="validateFrom">
                                            @csrf
                                            <p>A 6-digit verification code has been sent to {{ Session::get('data')['email'] }}</p>
                                            <p>Please enter the verification code below to verify your email address</p>
                                            <input type="hidden" name="name" value="{{ Session::get('data')['name'] }}">
                                            <input type="hidden" name="email" value="{{ Session::get('data')['email'] }}">
                                            <input type="hidden" name="password" value="{{ Session::get('data')['password'] }}">
                                            <input type="hidden" name="secretekey" value="{{ Session::get('secretekey') }}">
                                            <div class="form-group">
                                                <label class="mb-1"><strong>{{ __('Verification Code') }}</strong></label>
                                                <input id="otpnumber" type="text" class="form-control" name="otpnumber" value="{{ old('otpnumber') }}" required autocomplete="otpnumber" autofocus>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary btn-block">Verify</button>
                                            </div>
                                        </form>
                                        <div class="new-account mt-3">
                                            <p>Go bak to <a class="text-primary" href="{{ route('register') }}">Sign Up</a></p>
                                        </div>
                                    @endif
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