<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchaseOrder_id',
        'product_id',
        'variant_combination',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'variant_combination' => 'array',
    ];
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchaseOrder_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
