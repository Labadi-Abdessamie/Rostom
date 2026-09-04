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
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'position' => 'integer',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
