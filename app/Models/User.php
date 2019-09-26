<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

/**
 * Class User
 * @package App
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 * @property string email_verified_at
 * @property int role_id
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /*public function Role()
    {
        return $this->belongsTo('Role');
    }*/

    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function Store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function if_active($user_id)
    {
        $user = DB::table('users')
            ->where('users.id', $user_id)
            ->first();

        if (!$user)
            return false;

        if ($user->activated_account == '1')
            return true;
        else
            return false;
    }

    public function if_code_expired($user_id)
    {
        $user = DB::table('users')
            ->where('users.id', $user_id)
            ->first();

        if (!$user)
            return false;

        $activation_core_expired_date = Carbon::createFromFormat('Y-m-d H:i:s', $user->activation_code_expired_date);
        $datetime = $date = Carbon::now();

        $dif = $activation_core_expired_date->diffInHours($datetime);

        if ($dif > config('app.time_activation_code_expired_date')) {
            return true;
        }

        return false;
    }

}
