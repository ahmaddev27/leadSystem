<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionStructure extends Model
{
    protected $fillable = [
        'product_category_id',
        'lead_type_id',
        'commission_percentage',
    ];

    protected $casts = [
        'commission_percentage' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function leadType()
    {
        return $this->belongsTo(LeadType::class);
    }
}
