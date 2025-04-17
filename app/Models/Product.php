<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
    public function bagItem()
    {
        return $this->hasMany(BagItem::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function variant()
    {
        return $this->hasMany(Variant::class);
    }
}
