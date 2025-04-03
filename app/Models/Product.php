<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'main_image',
        'category_id',
        'tags',
        'is_active'

    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function getImage()
    {
        return $this->main_image ? url('storage/'.$this->main_image) : null;
    }

    public function images() :HasMany
    {

        return $this->hasMany(ProductImages::class);
    }

//    public function campaigns()
//    {
//        return $this->hasMany(Campaign::class);
//    }
}
