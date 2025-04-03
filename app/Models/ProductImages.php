<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = [
        'image',
        'product_id',

    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImage()
    {
        return $this->image ? url('storage/'.$this->image) : null;
    }


}
