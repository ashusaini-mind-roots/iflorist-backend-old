<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /*public function User()
    {
        return $this->hasOne('App\User');
    }*/
}
