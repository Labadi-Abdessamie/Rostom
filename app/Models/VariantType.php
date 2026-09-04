<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantType extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'type',
        'options',
        'required',
        'position',
        'is_visible',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'position' => 'integer',
        'is_visible' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
