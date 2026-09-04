<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_type_id',
        'value',
        'extra_price',
        'quantity',
        'image',
        'is_visible',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantType()
    {
        return $this->belongsTo(VariantType::class);
    }
}