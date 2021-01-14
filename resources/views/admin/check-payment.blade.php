@extends('wallet.layouts.master')
{{-- 
@section('my-style')

@endsection --}}


@section('page-content')
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
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
                            <h4 class="text-center font-weight-normal mb-3">Send Pending Coin</h4>
                            <form class="validateFrom" method="POST" action="{{ route('admin/check-payment') }}">
                                @csrf                                
                                <fieldset class="form-group">
                                    <input id="paymentID" type="text" class="form-control" placeholder="Enter Payment ID" name="paymentID" required autofocus>            
                                </fieldset>
                                <button type="submit" class="btn btn-success btn-lg btn-block"><i class="ft-lock"></i> Send</button>
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

    <script>
        $('form').submit(function(){
            if ($(this).valid()) {
                $(this).find('button[type=submit]').prop('disabled', true);
            } else {
                $(this).find('button[type=submit]').prop('disabled', false);
            }
        });
    </script>
@endsection