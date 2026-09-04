<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantCombination extends Model
{
    protected $fillable = [
        'product_id',
        'combination',
        'quantity',
        'extra_price',
        'sku',
    ];

    protected $casts = [
        'combination' => 'array',
        'quantity' => 'integer',
        'extra_price' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}