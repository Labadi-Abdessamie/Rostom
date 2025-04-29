<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;

class Magasin extends Model

{
    protected $fillable = [
        'name',
        'phoneNumber',
        'email',
        'magasinPicture',
        'vitrineVideo',
        'bio',
        'location',
        'magasinOpen',
        'rate',
        'rate_count',
        'status',
        'balance',
        'facebookLink',
        'instagramLink',
        'tiktokLink',
        'whatsupLink',
        'category_id',
        'user_id',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
{
    return $this->hasManyThrough(OrderItem::class, Product::class);
}
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
    public function reviews(): HasManyThrough
{
    return $this->hasManyThrough(
        Review::class,
        Product::class,
        'magasin_id',
        'product_id',
        'id', 
        'id'
    );
}
}
