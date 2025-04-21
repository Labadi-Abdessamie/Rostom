<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shippingAddress()
{
    return $this->belongsTo(Address::class, 'shippingAddress_id');
}
public function billingAddress()
{
    return $this->belongsTo(Address::class, 'billingAddress_id');
}
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
