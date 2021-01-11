<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferHistory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'transfer_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transferred_by','transferred_to','transferred_coin','price_per_coin','total_price'
    ];

    public static function addTransferHistory($data) {
        self::create($data);
    }

    /* Update the TransferHistory based on Id
    */
    public static function updateTransferHistory($id, $data )
    {
        self::where('id', $id)->update( $data );
    }

    public static function viewTransferHistory($id) {
        $data = TransferHistory::select('transferred_by','transferred_to','transferred_coin','price_per_coin','total_price','created_at');
        
        if ($id != "NA") {
            $data = $data->where('transferred_by', $id);
        }

        $data = $data->orderBy('created_at', 'DESC')->get();
        
        return $data;
    }
}
