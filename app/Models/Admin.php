<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'is_super_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
