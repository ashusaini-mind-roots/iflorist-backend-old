<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'contact_phone',
        'zip_code',
        'contact_email',
        'address',
    ];

    public function weeks()
    {
        return $this->belongsToMany('App\Models\Week');
    }
}
