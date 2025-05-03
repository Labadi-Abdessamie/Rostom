<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model

{
    protected $fillable = [
        'supplierName',
        'totalAmount',
        'doneDate',
        'type',
        'paymentStatus',
        'magasin_id',
    ];
    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class,'purchaseOrder_id');
    }
}
