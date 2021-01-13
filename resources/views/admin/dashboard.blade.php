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
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-info">Total Users</h4>
                                    <h3>{{ count($users) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-warning">Todys Collection</h4>
                                    <h3>{{ $todaysCollection }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-danger">Total Collection</h4>
                                    <h3>{{ $totalCollection }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-primary">Todays Coins sold</h4>
                                    <h3>{{ $todaysCoinSold }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="widget-stat card">
                                <div class="card-body p-4">
                                    <h4 class="card-title text-success">Total Coins sold</h4>
                                    <h3>{{ $totalCoinSold }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <div>
                                <h4 class="fs-20 text-black">Top Cryptocurrencies by Market Cap | <small><a href="{{ route('home') }}" class="text-info">Refresh</a></small></h4>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-hover fs-14">
                                <table class="table display mb-4 dataTablesCard " id="example5">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Coin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->total_coins }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="buyBNCModalFirst">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Binomo Coin [BNC]</h5>
                    <a href="{{ route('home') }}" class="close"><span>&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <form method="POST" class="validateFrom" id="formPreviewBuy">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1"><strong>{{ __('Enter the number of BNC to buy') }}</strong></label>
                            <input id="noBNCToBuy" type="text" class="form-control fs-18" name="noBNCToBuy" value="{{ old('noBNCToBuy') }}" placeholder="0" required autocomplete="noBNCToBuy" autofocus>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" id="btnPrvBuy">PREVIEW BUY</button>
                        </div>
                        <p class="pt-3 text-dark">At a time you can buy a Minimum of 1 BNC and a Maximum of 100 BNC</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buyBNCModalSecond">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buy Binomo Coin [BNC]</h5>
                    <a href="{{ route('home') }}" class="close"><span>&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <form method="POST" class="validateFrom" id="formConfirmBuy">
                        @csrf
                        <div class="form-group d-flex align-items-center">                                
                            <span>You will pay <span class="fs-18 font-w400 text-black mb-0 px-2">₹<span id="lblInrPayAmount"></span></span> for <span id="lblBNCtoBuy"></span> BNC</span>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" id="btnConfirmBuy">BUY</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentUpdateStatusModal" tabindex="-1" role="dialog" aria-labelledby="paymentUpdateStatusModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <h3 class="text-dark">Payment Successful!</h3>
                    <p class="pt-2 pb-3 text-dark">Transaction Number: <strong><span id="paymentTransactionID"></span></strong></p>
                    <p>Take a copy of transaction number for your reference.</p>

                    <a href="{{ route('home') }}" class="btn btn-success waves-effect waves-light btn-cancel-checkout">Go to Dashboard</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="waitingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <h3 class="text-dark">Loading...!</h3>
                    <p>Please wait...</p>

                    <a href="{{ route('home') }}" class="btn light btn-dark btn-sm waves-effect waves-light btn-cancel-checkout mt-3">Cancel Payment</a>
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

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{ asset('wallet/js/dashboard.min.js') }}"></script>
@endsection