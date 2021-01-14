<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\PurchaseHistory;
use App\Models\TransferHistory;
use App\Models\PaymentReceived;
use App\Models\OrderHistory;
use App\Models\UserWallet;
use App\Models\BNCLive;
use App\Models\BNCHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

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

    /**
     * Display payment check page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewCheckPayment() {
        return view('admin.check-payment');
    }

    /**
     * Validate payment ID
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function validatePaymentID(Request $request) {
        $validator = Validator::make($request->all(), [
            'paymentID' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("error","Payment ID is empty");
        }

        try {
            $paymentDetails = $this->getPaymentDetails($request->paymentID);
            
            if ($paymentDetails->status != "captured") {
                return redirect()->back()->with("error","Payment ID is not captured");
            } else {
                $paymentID = $paymentDetails->id;
                $orderID = $paymentDetails->order_id;
                
                $checkOrderID = PaymentReceived::checkExist(['razorpay_order_id' => $orderID]);
                
                if (!$checkOrderID) {
                    return redirect()->back()->with("error","The id provided does not exist");
                } else {
                    if ($checkOrderID->status != 0) {
                        return redirect()->back()->with("error","Coin has been already added to user wallet for the given Payment Id.");
                    } else {
                        $OrderHistory = OrderHistory::getOrderHistoryFirst(['payment_receiveds_id' => $checkOrderID->id]);

                        $orderUpdateObj = [
                            'razorpay_payment_id' => $paymentID,
                            'status' => 1
                        ];
                        PaymentReceived::updatePaymentStatus($checkOrderID->razorpay_order_id, $orderUpdateObj);
                        
                        $this->addToUserWallet($checkOrderID, $OrderHistory);
                        $this->addToPurchaseHistory($checkOrderID, $OrderHistory);
                        $this->updateBNCValue($OrderHistory->total_price);
                        
                        return redirect()->back()->with("success","Coin added successfully!");
                    }
                }
                
            }            
        } catch (\Throwable $th) {
            return redirect()->back()->with("error","The id provided does not exist");
        }
 
        
    }

    /**
     * Update user wallet
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToUserWallet($order_obj, $OrderHistory){
        $userWalletCheckExist = UserWallet::checkExist(['users_id' => $order_obj->users_id]);

        // add offer coin
        if ($OrderHistory->purchased_coin >= 100) {
            $offerCoin = 6;
        } else if ($OrderHistory->purchased_coin >= 50) {
            $offerCoin = 3;
        } else {
            $offerCoin = 0;
        }

        if ($userWalletCheckExist) {
            $data = [
                'total_coins' => $userWalletCheckExist->total_coins + $OrderHistory->purchased_coin + $offerCoin,
                'updated_at' => $OrderHistory->updated_at
            ];
            UserWallet::updateUserWallet($userWalletCheckExist->id, $data);
        } else {
            $data = [
                'users_id' => $order_obj->users_id,
                'total_coins' => $OrderHistory->purchased_coin + $offerCoin,
                'created_at' => $OrderHistory->created_at,
                'updated_at' => $OrderHistory->updated_at
            ];
            UserWallet::addUserWallet($data);
        }
        return;
    }

    /**
     * Add payment details to purchase history table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToPurchaseHistory($order_obj, $OrderHistory){
        $data = [
            'users_id' => $order_obj->users_id,
            'payment_receiveds_id' => $order_obj->id,
            'type' => 'BNC',
            'purchased_by' => '0',
            'purchased_coin' => $OrderHistory->purchased_coin,
            'price_per_coin' => $OrderHistory->price_per_coin,
            'total_price' => $OrderHistory->total_price,
            'created_at' => $OrderHistory->created_at,
            'updated_at' => $OrderHistory->updated_at
        ];
        PurchaseHistory::addPurchaseHistory($data);

        // add offer coin
        if ($OrderHistory->purchased_coin >= 50) {
            $this->addOfferToPurchaseHistory($order_obj, $OrderHistory);
        }

        return;
    }

    /**
     * offer add to purchase table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addOfferToPurchaseHistory($order_obj, $OrderHistory){
        if ($OrderHistory->purchased_coin >= 100) {
            $offerCoin = 6;
        } else if ($OrderHistory->purchased_coin >= 50) {
            $offerCoin = 3;
        } else {
            $offerCoin = 0;
        }

        if ($offerCoin > 0) {
            $data = [
                'users_id' => $order_obj->users_id,
                'payment_receiveds_id' => $order_obj->id,
                'type' => 'FREE',
                'purchased_by' => '0',
                'purchased_coin' => $offerCoin,
                'price_per_coin' => $OrderHistory->price_per_coin,
                'total_price' => 0
            ];
            PurchaseHistory::addPurchaseHistory($data);
        } 
        return;
    }

    /**
     * Update BNC value
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateBNCValue($totalAmount){
        //generate incremental value for BNC price
        if ($totalAmount >= 1000 && $totalAmount < 50000) {
            $rndNum = rand(1,3);
        } else if ($totalAmount >= 50000 && $totalAmount < 100000) {
            $rndNum = rand(3,5);
        } else {
            $rndNum = rand(5,7);
        }
        $incrAmt = '0.00'.$rndNum;
        $incrAmt = (float)$incrAmt;
        $incrAmt = ($totalAmount * $incrAmt)/100;
        $bncLiveData = BNCLive::viewBNCLive();        
        $totalAmount = $bncLiveData->inr_value + $incrAmt;
        $totalAmount = round($totalAmount, 2);

        //add to BNC history table
        $data = [
            'inr_value' => $totalAmount
        ];
        $bncHistoryID = BNCHistory::addBNCHistory($data);

        //update BNC live value
        $data_bnclive = [
            'b_n_c_histories_id' => $bncHistoryID,
            'inr_value' => $totalAmount
        ];
        BNCLive::updateBNCLive(1, $data_bnclive);
        return;
    }
    
    public function getPaymentDetails($id){
        $api = new Api(config('services.razorpay.keyid'), config('services.razorpay.keysecret'));

        $payment = $api->payment->fetch($id);
        return $payment;
    }
}
