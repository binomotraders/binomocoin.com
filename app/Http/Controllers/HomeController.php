<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\BNCLive;
use App\Models\BNCHistory;
use App\Models\UserWallet;
use App\Models\PaymentReceived;
use App\Models\PurchaseHistory;
use Razorpay\Api\Api;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            if (Auth::user()->user_role == "USER") {
                $client = new \GuzzleHttp\Client();
                $url = "https://api.nomics.com/v1/currencies/ticker?key=c95b5de59923429ddb2bfa2c598d91e9&interval=1d&convert=INR&per-page=10";
                $response = $client->get($url, ['Content-Type' => 'application/json']); 
                
                $userWalletDet = UserWallet::checkExist(['users_id' => Auth::user()->id]);
                $liveBNCValue = BNCLive::viewBNCLive();

                $usertotalAmount = 0;
                $usertotalBNC = 0;
                if ($userWalletDet) {
                    $usertotalAmount = $liveBNCValue->inr_value * $userWalletDet->total_coins;
                    $usertotalAmount = round($usertotalAmount, 2);

                    $usertotalBNC = $userWalletDet->total_coins;
                }            

                $data = [
                    "usertotalBNC" => $usertotalBNC,
                    "usertotalAmount" => $usertotalAmount,
                    "bnc_value" => $liveBNCValue->inr_value,
                ];
                
                if ($response->getStatusCode() == 200) {
                    $results = json_decode($response->getBody());
                    return view('wallet.dashboard')->with(['marketdata' => $results, 'data' => $data]);
                } else {
                    return view('wallet.dashboard')->with(['marketdata' => [], 'data' => $data]);
                }
            } else {
                $users = User::allUsersDetails();

                $date = Carbon::now()->toDateString();
                $todaysCollection = PurchaseHistory::amountCollected($date);
                $totalCollection = PurchaseHistory::amountCollected("NA");
                
                $todaysCoinSold = PurchaseHistory::CoinSold($date);
                $totalCoinSold = PurchaseHistory::CoinSold("NA");
                
                return view('admin.dashboard')->with([
                    'users'=>$users,
                    'todaysCollection' => $todaysCollection,
                    'totalCollection' => $totalCollection,
                    'todaysCoinSold' => $todaysCoinSold,
                    'totalCoinSold' => $totalCoinSold,
                ]);
            }
            
            
        } catch (\Throwable $th) {
            return abort(404);
        }
       
    }

    /**
     * Fetch current BNC value (JSON re & res)
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBncValuePreview($id = null)
    {
        try {
            $data = BNCLive::viewBNCLive();
            $payAmount = $data->inr_value * $id;
            $payAmount = round($payAmount, 2);
            
            $order = $this->createOrder($payAmount);
                
            $orderOj = [
                'key' => config('services.razorpay.keyid'),
                'amount' => $order->amount,
                'currency' => $order->currency,
                'order_id' => $order->id,
                'name' => Auth::user()->name,
                'receipt' => $order->receipt,
                'email' => Auth::user()->email,
                'purchased_coin' => $id,
                'price_per_coin' => $data->inr_value,
                'total_price' => $payAmount,
            ];

            // Insert order id into payment_received table
            $saveOrderObj = [
                'users_id' => Auth::user()->id,
                'razorpay_payment_id' => '',
                'razorpay_order_id' => $order->id,
                'razorpay_signature' => '',
                'status' => 0
            ];
            PaymentReceived::addPaymentReceived($saveOrderObj);

            return response()->json(['status'=>'success', 'payAmount'=>$payAmount, 'order'=>$orderOj], 200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>'failure', 'message'=>['error'=>['Internal server error while fetching BNC value.']]], 400);
        }
       
    }

    /**
     * Create Order ID Razorpay
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createOrder($payAmount)
    {
        try {
            $receiptID = "BNC-" . date("dmYHis");
            $api = new Api(config('services.razorpay.keyid'), config('services.razorpay.keysecret'));

            $order = $api->order->create(array(
                    'receipt' => $receiptID,
                    'amount' => $payAmount * 100,
                    'currency' => config('services.razorpay.currency.india'),
                    'payment_capture' => 1
                )
            );

            return $order;
        } catch (\Throwable $th) {
            return false;
        }       
    }

    /**
     * Update payment status after successful payment
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentStatus(Request $request) {
        $data = $request->all();
        try {
            $orderUpdateObj = [
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature' => $data['razorpay_signature'],
                'status' => 1
            ];
            PaymentReceived::updatePaymentStatus($data['razorpay_order_id'], $orderUpdateObj);
            $paymentReceivedObj = PaymentReceived::getPaymentReceivedById($data['razorpay_order_id']);

            $this->verifyPayment($data);               
            $this->addToUserWallet($data['order_obj']);
            $this->addToPurchaseHistory($paymentReceivedObj->id, $data['order_obj']);
            $this->updateBNCValue($data['order_obj']['total_price']);

            return response()->json(['status'=>'success', 'paymentReceipt'=>$data['razorpay_payment_id']], 200);
        } catch (\Throwable $th) {
            return response()->json(['status'=>'failure', 'paymentReceipt'=>$data['razorpay_payment_id'], 'error'=>$th], 400);
        }
    }
    
    /**
     * Verify payment signature
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function verifyPayment($data){
        $api = new Api(config('services.razorpay.keyid'), config('services.razorpay.keysecret'));

        $attributes  = array('razorpay_signature'  => $data['razorpay_signature'],  'razorpay_payment_id'  => $data['razorpay_payment_id'] ,  'razorpay_order_id' => $data['razorpay_order_id']);
        $api->utility->verifyPaymentSignature($attributes);

        return;
    }

    /**
     * Update user wallet
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToUserWallet($order_obj){
        $userWalletCheckExist = UserWallet::checkExist(['users_id' => Auth::user()->id]);

        // add offer coin
        if ($order_obj['purchased_coin'] >= 100) {
            $offerCoin = 6;
        } else if ($order_obj['purchased_coin'] >= 50) {
            $offerCoin = 3;
        } else {
            $offerCoin = 0;
        }

        if ($userWalletCheckExist) {
            $data = [
                'total_coins' => $userWalletCheckExist->total_coins + $order_obj['purchased_coin'] + $offerCoin
            ];
            UserWallet::updateUserWallet($userWalletCheckExist->id, $data);
        } else {
            $data = [
                'users_id' => Auth::user()->id,
                'total_coins' => $order_obj['purchased_coin'] + $offerCoin
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
    public function addToPurchaseHistory($paymentReceivedId, $order_obj){
        $data = [
            'users_id' => Auth::user()->id,
            'payment_receiveds_id' => $paymentReceivedId,
            'type' => 'BNC',
            'purchased_by' => '0',
            'purchased_coin' => $order_obj['purchased_coin'],
            'price_per_coin' => $order_obj['price_per_coin'],
            'total_price' => $order_obj['total_price']
        ];
        PurchaseHistory::addPurchaseHistory($data);

        // add offer coin
        if ($order_obj['purchased_coin'] >= 50) {
            $this->addOfferToPurchaseHistory($paymentReceivedId, $order_obj);
        }

        return;
    }

    /**
     * offer add to purchase table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addOfferToPurchaseHistory($paymentReceivedId, $order_obj){
        if ($order_obj['purchased_coin'] >= 100) {
            $offerCoin = 6;
        } else if ($order_obj['purchased_coin'] >= 50) {
            $offerCoin = 3;
        } else {
            $offerCoin = 0;
        }

        if ($offerCoin > 0) {
            $data = [
                'users_id' => Auth::user()->id,
                'payment_receiveds_id' => $paymentReceivedId,
                'type' => 'FREE',
                'purchased_by' => '0',
                'purchased_coin' => $offerCoin,
                'price_per_coin' => $order_obj['price_per_coin'],
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

    /**
     * Display Withdraw page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewWithdrawHome(){ 
        $userWalletCheckExist = UserWallet::checkExist(['users_id' => Auth::user()->id]);       
        return view('wallet.withdraw')->with(['data' => $userWalletCheckExist]);
    }

    /**
     * Display change password page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showChangePasswordForm(){
        return view('wallet.change-password');
    }

    /**
     * Change password
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword(Request $request){
 
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:5|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully !");
 
    }

    /**
     * Display profile page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewProfile(){
        return view('wallet.profile');
    }
      
}
