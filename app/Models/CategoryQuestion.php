<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryQuestion extends Model
{
    protected $fillable = [
        'product_category_id',
        'question',
        'field_type',
        'options',
        'placeholder',
        'icon',
        'is_required',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
