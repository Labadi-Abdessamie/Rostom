<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'quantity',
        'order_id',
        'product_id',
        'variant_combination',
        'base_price',
        'extra_price',
    ];

    protected $casts = [
        'variant_combination' => 'array',
        'base_price' => 'float',
        'extra_price' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getLineTotalAttribute()
    {
        return ($this->base_price + $this->extra_price) * $this->quantity;
    }
}
