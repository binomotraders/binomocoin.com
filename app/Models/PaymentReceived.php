<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'payment_receiveds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id','razorpay_payment_id','razorpay_order_id','razorpay_signature','status'
    ];

    public static function addPaymentReceived($data) {
        self::create($data);
    }

    /* Update the PaymentReceived based on Id
    */
    public static function updatePaymentReceived($id, $data )
    {
        self::where('id', $id)->update( $data );
    }

    public static function checkExist($condition){
        return PaymentReceived::where($condition)->first();
    }

    public static function updatePaymentStatus($order_id, $data){
        self::where('razorpay_order_id', $order_id)->update($data);
    }

    public static function getPaymentReceivedById($order_id){
        return PaymentReceived::where('razorpay_order_id', $order_id)->first();
    }
}
