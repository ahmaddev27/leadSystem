<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'features',
        'price',
        'main_image',

    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

//    public function campaigns()
//    {
//        return $this->hasMany(Campaign::class);
//    }
}
