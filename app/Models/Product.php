<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'actual_quantity',
        'price',
        'principalImage',
        'sizeVar',
        'colorVar',
        'rate_average',
        'rate_count',
        'category_id',
        'is_listed',
        'magasin_id',
    ];


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
    public function variantTypes()
    {
        return $this->belongsToMany(VariantType::class);
    }
    public function combinations()
    {
        return $this->hasMany(VariantCombination::class);
    }
}
