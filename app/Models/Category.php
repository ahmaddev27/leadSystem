<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'slug',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function commissionStructures(): HasMany
    {
        return $this->hasMany(CommissionStructure::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(CategoryQuestion::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function leadTypes(): BelongsToMany
    {
        return $this->belongsToMany(LeadType::class, 'commission_structures')
            ->withPivot('commission_percentage')
            ->withTimestamps();
    }

    public function getImae()
    {
        return $this->image ? url('storage/'.$this->image) : null;
    }


}
