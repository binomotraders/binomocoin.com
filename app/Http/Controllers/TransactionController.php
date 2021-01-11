<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\PurchaseHistory;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Fetch purchase history
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function purchaseHistory(){        
        $data = PurchaseHistory::viewPurchaseHistory(Auth::user()->id);
        return view('wallet.purchase-history')->with(['data' => $data]);
    }

    /**
     * Fetch transfer history
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function transferHistory(){        
        $data = TransferHistory::viewTransferHistory(Auth::user()->id);
        return view('wallet.transfer-history')->with(['data' => $data]);
    }
}
