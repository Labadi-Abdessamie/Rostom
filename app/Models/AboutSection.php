<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'text',
        'icon',
        'color',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function section(string $type, $default = null)
    {
        return static::where('type', $type)
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->first() ?? $default;
    }

    public static function ofType(string $type)
    {
        return static::where('type', $type)
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }
}
