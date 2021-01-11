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
                                <h4 class="fs-20 text-black">Profile</h4>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <h4>{{ Auth::user()->name }}</h4>
                            <h5>{{ Auth::user()->email }}</h5>
                            <h6>Wallet Address: <span class="text-warning">{{ Auth::user()->uuid }}</span></h6>
                            <h6 class="mt-4">Registered Date: {{ Auth::user()->created_at }}</h6>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @section('my-script')

@endsection --}}