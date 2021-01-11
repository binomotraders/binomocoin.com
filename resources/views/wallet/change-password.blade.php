@extends('wallet.layouts.master')
{{-- 
@section('my-style')

@endsection --}}


@section('page-content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <div>
                                <h4 class="fs-20 text-black">Change Password</h4>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->has('current-password'))
                                <div class="alert alert-danger">
                                {{ $errors->first('current-password') }}
                                </div>
                            @endif
                            @if ($errors->has('new-password'))
                                <div class="alert alert-danger">
                                {{ $errors->first('new-password') }}
                                </div>
                            @endif

                            <form id="changePasswordForm" method="POST" action="{{ URL('changePassword') }}" class="validateFrom">
                                @csrf
                                
                                <fieldset class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} position-relative has-icon-left">
                                    <input id="current-password" type="password" class="form-control" placeholder="Current Password" name="current-password" required>            
                                </fieldset>
                                
                                <fieldset class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} position-relative has-icon-left">
                                    <input id="new-password" type="password" class="form-control" placeholder="New Password" name="new-password" required>   
                                </fieldset>

                                <fieldset class="form-group position-relative has-icon-left">
                                    <input id="new-password-confirm" type="password" class="form-control" placeholder="Confirm New Password" name="new-password_confirmation" required>
                                </fieldset>
                                
                                <button type="submit" class="btn btn-success btn-lg btn-block" id="btnchangePassword"><i class="ft-lock"></i> Change Password</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection


@section('my-script')
    <!-- Jquery Validation -->
    <script src="{{ asset('wallet/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Form validate init -->
    <script src="{{ asset('wallet/js/plugins-init/jquery.validate-init.js') }}"></script>
@endsection