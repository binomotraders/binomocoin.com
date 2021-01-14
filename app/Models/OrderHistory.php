<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'order_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_receiveds_id','purchased_coin','price_per_coin','total_price'
    ];

    public static function addOrderHistory($data) {
        self::create($data);
    }

    /* Update the OrderHistory based on Id
    */
    public static function updateOrderHistory($id, $data )
    {
        self::where('id', $id)->update( $data );
    }

    public static function getOrderHistoryFirst($condition){
        return OrderHistory::where($condition)->first();
    }
}
