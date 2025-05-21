<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $fillable = [
        'path',
        'review_id'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
