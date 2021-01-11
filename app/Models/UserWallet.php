<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user_wallets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id','total_coins'
    ];

    public static function addUserWallet($data) {
        self::create($data);
    }

    /* Update the UserWallet based on Id
    */
    public static function updateUserWallet($id, $data)
    {
        self::where('id', $id)->update($data);
    }

    public static function checkExist($condition){
        return UserWallet::where($condition)->first();
    }
}
