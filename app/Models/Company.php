<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
