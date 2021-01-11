<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BNCHistory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'b_n_c_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inr_value'
    ];

    public static function addBNCHistory($data) {
        $result = self::create($data);
        return $result->id;
    }

    /* Update the BNCHistory based on Id
    */
    public static function updateBNCHistory($id, $data )
    {
        self::where('id', $id)->update( $data );
    }
}
