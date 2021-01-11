<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BNCLive extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'b_n_c_lives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'b_n_c_histories_id','inr_value'
    ];

    public static function addBNCLive($data) {
        self::create($data);
    }

    /* Update the BNCLive based on Id
    */
    public static function updateBNCLive($id, $data )
    {
        self::where('id', $id)->update( $data );
    }

    public static function viewBNCLive() {
        $data = BNCLive::select('b_n_c_histories_id', 'inr_value', 'created_at')->first();           
        return $data;
    }
}
