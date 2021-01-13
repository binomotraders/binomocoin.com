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
                                <h4 class="fs-20 text-black">User Details</h4>
                                
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
@endsection


{{-- @section('my-script')

@endsection --}}