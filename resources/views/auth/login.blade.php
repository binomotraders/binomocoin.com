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
                                    
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="POST" action="{{ route('login') }}" class="validateFrom">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>{{ __('E-Mail Address') }}</strong></label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>{{ __('Password') }}</strong></label>
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
                                                    <input class="custom-control-input" type="checkbox" name="remember" id="basic_checkbox_1" {{ old('remember') ? 'checked' : '' }}>
													<label class="custom-control-label" for="basic_checkbox_1">{{ __('Remember Me') }}</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="{{ route('register') }}">Sign up</a></p>
                                    </div>
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
</body>
</html>