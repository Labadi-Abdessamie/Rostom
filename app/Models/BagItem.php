<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'bag_id',
        'product_id'
    ];
    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
