<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid', 'user_role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function checkExist($condition){
        return User::where($condition)->first();
    }

    public static function allUsersDetails() {
        $data = User::where('users.user_role', '=', 'USER')
            ->join('user_wallets', 'users.id', '=', 'user_wallets.users_id')
            ->select('users.id as UserID', 'users.name', 'users.email', 'user_wallets.total_coins')->get();
        return $data;
    }
}
