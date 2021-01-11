<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\BNCLive;
use App\Models\TransferHistory;
use App\Models\UserWallet;
use App\Models\PurchaseHistory;
use App\User;

class TransferController extends Controller
{
    /**
     * Display Transfer page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewTransferHome(){                
        return view('wallet.transfer');
    }

    /**
     * Transfer BNC
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function transferBnc(Request $request){                
        $data = $request->all();
        $validatedData = $request->validate([
            'noBNCToSend' => 'required|numeric',
            'walletAddress' => 'required'
        ]);

        try {
            $transferToAddress = User::checkExist(['uuid' => $data['walletAddress']]);
            $userWalletCheckExist = UserWallet::checkExist(['users_id' => Auth::user()->id]);
            if (!$transferToAddress) {
                return redirect()->back()->with('error','Wallet address not found.');
            } else if(!$userWalletCheckExist) {
                return redirect()->back()->with("error","You don't have sufficient BNc to transfer.");
            } else {
                if ($userWalletCheckExist->total_coins >= $data['noBNCToSend']) {
                    $this->addToUserWallet($transferToAddress->id, $data);
                    $this->subfromUserWallet($data);
                    $this->addToPurchaseHistory($transferToAddress->id, $data);
                    $this->transferBncToWallet($transferToAddress->id, $data);

                    return redirect()->back()->with("success","Successfully transfer.");
                } else {
                    return redirect()->back()->with("error","You don't have sufficient BNc to transfer.");
                }
            }            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Internal Server Error! Try again after some time.');
        }

        
    }

    /**
     * Save transfer data into table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function transferBncToWallet($toID, $data){                
        $dataSave = [
            'transferred_by' => Auth::user()->id,
            'transferred_to' => $toID,
            'transferred_coin' => $data['noBNCToSend'],
            'price_per_coin' => $data['price_per_coin'],
            'total_price' => $data['total_price']
        ];
        TransferHistory::addTransferHistory($dataSave);
        return;
    }

    /**
     * Update user wallet
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToUserWallet($toID, $trndfObj){
        $userWalletCheckExist = UserWallet::checkExist(['users_id' => $toID]);
        if ($userWalletCheckExist) {
            $data = [
                'total_coins' => $userWalletCheckExist->total_coins + $trndfObj['noBNCToSend']
            ];
            UserWallet::updateUserWallet($userWalletCheckExist->id, $data);
        } else {
            $data = [
                'users_id' => $toID,
                'total_coins' => $trndfObj['noBNCToSend']
            ];
            UserWallet::addUserWallet($data);
        }
        return;
    }

    /**
     * Update user wallet self
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function subfromUserWallet($trndfObj){
        $userWalletCheckExist = UserWallet::checkExist(['users_id' => Auth::user()->id]);
        if ($userWalletCheckExist) {
            $data = [
                'total_coins' => $userWalletCheckExist->total_coins - $trndfObj['noBNCToSend']
            ];
            UserWallet::updateUserWallet($userWalletCheckExist->id, $data);
        } else {
            $data = [
                'users_id' => Auth::user()->id,
                'total_coins' => 0
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
    public function addToPurchaseHistory($toID, $trndfObj){
        $data = [
            'users_id' => $toID,
            'type' => 'USER',
            'purchased_by' => Auth::user()->id,
            'purchased_coin' => $trndfObj['noBNCToSend'],
            'price_per_coin' => $trndfObj['price_per_coin'],
            'total_price' => $trndfObj['total_price']
        ];
        PurchaseHistory::addPurchaseHistory($data);
        return;
    }

    /**
     * Fetch BNC value
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBncValue($id = null){                
        try {
            $data = BNCLive::viewBNCLive();
            $payAmount = $data->inr_value * $id;
            $payAmount = round($payAmount, 2);

            $bncTransferObj = [
                'transfered_coin' => $id,
                'price_per_coin' => $data->inr_value,
                'total_price' => $payAmount,
            ];

            return response()->json(['status'=>'success', 'payAmount'=>$payAmount, 'bncTransferObj'=>$bncTransferObj], 200);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Internal Server Error! Try again after some time.');
        }
    }
}
