<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LeadType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'commission_structures')
            ->withPivot('commission_percentage')
            ->withTimestamps();
    }
}
