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
                                <h4 class="fs-20 text-black">Purchase History</h4>
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-hover fs-14">
                                <table class="table display mb-4 dataTablesCard " id="example5">
                                    <thead>
                                        <tr>
                                            <th>Datetime</th>
                                            <th>Coin</th>
                                            <th>Amount</th>
                                            <th>From</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data) > 0)
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ date('d M Y - H:i:s', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->purchased_coin }}</td>
                                                    
                                                    @if ($item->total_price > 0)
                                                        <td>₹{{ $item->total_price }}</td>
                                                    @else
                                                        <td>FREE</td>
                                                    @endif
                                                    
                                                    @if ($item->type == "BNC")
                                                        <td>Binomo</td>
                                                    @elseif ($item->type == "FREE")
                                                        <td>Offer</td>
                                                    @else
                                                        <td>Friend</td>
                                                    @endif
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
@endsection


{{-- @section('my-script')

@endsection --}}