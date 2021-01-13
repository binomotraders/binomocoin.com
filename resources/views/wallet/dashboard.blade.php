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
                    <div class="text-center">
                        <p class="mb-2 text-success fs-18"> • Buy 100 coins get 6 coin Free</p>
                        <p class="text-success fs-18"> • Buy 50 coins get 3 coin Free</p>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header d-block d-sm-flex border-0 pb-0">
                                    <div>
                                        <h4 class="fs-20 text-black">My Wallet</h4>
                                        <p class="mb-0 fs-13">Your current wallet value</p>
                                    </div>
                                    <div class="card-action card-tabs mt-3 mt-sm-0">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active px-3 wspace-no" data-toggle="tab" href="#totalBncWallet" role="tab">
                                                    Your Total BNC
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link px-3 wspace-no" data-toggle="tab" href="#portfolioWallet" role="tab">
                                                    Portfolio Worth
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body border-bottom tab-content">
                                    <div class="tab-pane active show fade" id="totalBncWallet" role="tabpanel">
                                        <h3 class="fs-28 font-w600 text-black ml-auto">
                                            <img src="{{ asset('wallet/images/bnc.png') }}" width="28" alt=""> 
                                            <span>{{ $data['usertotalBNC'] }} BNC</span>
                                        </h3>
                                    </div>
                                    <div class="tab-pane" id="portfolioWallet" role="tabpanel">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('wallet/images/india.svg') }}" width="28" alt=""> 
                                            <h3 class="fs-28 font-w600 text-black mb-0 pl-2">
                                                {{ $data['usertotalAmount'] }} INR
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3 text-right">
                                        <a href="javascript:void()" class="mb-0 text-dark" id="showWalletAddress"><u>Show Wallet Address >></u></a>
                                        <p class="mb-0 fs-12 text-info display-none" id="walletAddress">{{ Auth::user()->uuid }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div>
                                        <h4 class="fs-20 text-black">Binomo Coin [BNC]</h4>
                                        <p class="mb-0 fs-13">Current market value of BNC</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center pt-3">
                                        <img src="{{ asset('wallet/images/bnc.png') }}" width="20" alt=""> 
                                        <h3 class="fs-18 font-w400 text-black mb-0 pl-1">
                                            1 BNC
                                        </h3>
                                        <span class="px-3 fs-16 text-black">=</span>
                                        <img src="{{ asset('wallet/images/united-states.svg') }}" width="20" alt=""> 
                                        <h3 class="fs-18 font-w400 text-black mb-0 pl-1">
                                            {{ round($data['bnc_value']/73.49, 2) }} USD
                                        </h3>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('wallet/images/bnc.png') }}" width="20" alt=""> 
                                        <h3 class="fs-18 font-w400 text-black mb-0 pl-1">
                                            1 BNC
                                        </h3>
                                        <span class="px-3 fs-16 text-black">=</span>
                                        <img src="{{ asset('wallet/images/india.svg') }}" width="20" alt=""> 
                                        <h3 class="fs-18 font-w400 text-black mb-0 pl-1">
                                            {{ $data['bnc_value'] }} INR
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-footer border-0 pt-0">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm d-block rounded-0 mt-3 mt-md-0 fs-20" data-toggle="modal" data-target="#buyBNCModalFirst" data-backdrop="static" data-keyboard="false">
                                                BUY NOW
                                            </a>
                                        </div>
                                    </div>
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
                                            {{-- <th>Rank</th> --}}
                                            <th>Coin</th>
                                            <th>Price</th>
                                            <th>Change (24hr)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($marketdata) > 0)
                                            @foreach ($marketdata as $item)
                                                @php
                                                    $price_change_pct = $item->{'1d'}->price_change_pct;
                                                    $change_pct = $price_change_pct * 100;                                                
                                                @endphp
                                                <tr>
                                                    {{-- <td class="width">
                                                        <span class="text-dark d-inline-block">#{{ $item->rank }}</span>
                                                    </td> --}}
                                                    <td>
                                                        <div class="font-w600 d-flex align-items-center">
                                                            <img src="{{ $item->logo_url }}" width="25" alt="logo" />
                                                            <span class="pl-3">{{ $item->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="font-w600">₹{{ number_format($item->price,2) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($price_change_pct > 0)
                                                            <span class="font-w500 text-success text-right">{{ $change_pct }}%</span>
                                                        @else
                                                            <span class="font-w500 text-danger text-right">{{ $change_pct }}%</span>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach   
                                        @else
                                            <tr class="text-center">
                                                <td colspan="2">No results found</td>
                                            </tr>
                                        @endif

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