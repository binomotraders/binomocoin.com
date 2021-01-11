<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'purchase_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id','payment_receiveds_id','type','purchased_by','purchased_coin','price_per_coin','total_price'
    ];

    public static function addPurchaseHistory($data) {
        self::create($data);
    }

    /* Update the PurchaseHistory based on Id
    */
    public static function updatePurchaseHistory($id, $data )
    {
        self::where('id', $id)->update( $data );
    }

    public static function viewPurchaseHistory($id) {
        $data = PurchaseHistory::select('purchased_by','purchased_coin','price_per_coin','total_price','created_at');
        
        if ($id != "NA") {
            $data = $data->where('users_id', $id);
        }

        $data = $data->orderBy('created_at', 'DESC')->get();
        
        return $data;
    }
}
