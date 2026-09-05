<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'label',
        'icon',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function getValue(string $key, string $default = ''): string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function visibleStats(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Refresh the value of every predefined "auto" stat by counting real DB rows.
     * The matching row must already exist (created via seeder or admin form).
     * Returns the number of rows updated.
     */
    public static function refreshLiveStats(): int
    {
        // Map each predefined key to a model class + scope.
        // Adjust the model names / scopes to match your actual schema.
        $counters = [
            'total_vendors'   => fn () => \App\Models\Magasin::where('status', 'active')->count(),
            'total_products'  => fn () => \App\Models\Product::count(),
            'total_members'   => fn () => \App\Models\TeamMember::where('status', true)->count(),
            'total_orders'    => fn () => \App\Models\Order::count() ?? 0,
            'total_reviews'   => fn () => \App\Models\Review::count() ?? 0,
            'total_customers' => fn () => \App\Models\User::where('role', 'client')->count(),
        ];

        $updated = 0;
        foreach ($counters as $key => $callback) {
            $row = static::where('key', $key)->first();
            if (!$row) continue;

            try {
                $count = (int) $callback();
                $formatted = self::formatCount($count);
                if ($row->value !== $formatted) {
                    $row->value = $formatted;
                    $row->save();
                }
                $updated++;
            } catch (\Throwable $e) {
                // Model/table not present yet — keep existing stored value
                continue;
            }
        }

        return $updated;
    }

    public static function formatCount(int $n): string
    {
        if ($n >= 1_000_000) return rtrim(rtrim(number_format($n / 1_000_000, 1), '0'), '.') . 'M+';
        if ($n >= 1_000)     return rtrim(rtrim(number_format($n / 1_000, 1), '0'), '.') . 'K+';
        return (string) $n;
    }
}
