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
                                <h4 class="fs-20 text-black">Transfer BNC</h4>                                
                            </div>
                        </div>
                        <div class="card-body">
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
                            
                            <form method="POST" class="validateFrom" id="formConfirmSendBNC" action="{{ route('transfer-bnc') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="mb-1"><strong>{{ __('Enter the number of BNC to buy') }}</strong></label>
                                    <input id="noBNCToSend" type="text" class="form-control fs-18" name="noBNCToSend" value="{{ old('noBNCToSend') }}" placeholder="0" required autocomplete="noBNCToSend" autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="mb-1"><strong>{{ __('Wallet address to transfer BNC') }}</strong></label>
                                    <input id="walletAddress" type="text" class="form-control fs-12" name="walletAddress" value="{{ old('walletAddress') }}" placeholder="Enter Wallet address here" required autocomplete="walletAddress" autofocus>
                                </div>
                                <input type="hidden" name="price_per_coin" id="price_per_coin">
                                <input type="hidden" name="total_price" id="total_price">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">SEND</button>
                                </div>
                                <p class="mb-0 pt-4 text-danger fs-16"><b>Note: </b>You need to collect the amount manually from the account holder to whom your sending the BNC.</p>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmTransferModal" tabindex="-1" role="dialog" aria-labelledby="confirmTransferModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <h3 class="text-dark">Continue to Transfer ?</h3>
                    <p class="pt-3"><span>You will get <span class="fs-18 font-w400 text-black mb-0 px-2">₹<span id="lblInrRecAmount"></span></span> for <span id="lblBNCtoSend"></span> BNC</span></p>
                    <p class="pt-3 pb-3">You cannot undo the transfer once you click on Yes</p>

                    <a href="{{ route('home') }}" class="btn btn-light waves-effect waves-light btn-cancel-checkout">No</a>
                    <button type="button" class="btn btn-success waves-effect waves-light btn-cancel-checkout" id="btnSendBNC">Yes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection


@section('my-script')
    <!-- Jquery Validation -->
    <script src="{{ asset('wallet/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Form validate init -->
    <script src="{{ asset('wallet/js/plugins-init/jquery.validate-init.js') }}"></script>
    <script src="{{ asset('wallet/js/send.min.js') }}"></script>
@endsection