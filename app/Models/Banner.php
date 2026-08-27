<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'page',
        'position',
        'status',
        'type',
    ];

    /**
     * Resolve the banner link to a usable URL.
     *
     * `link` may hold a named route (e.g. "frontend.products"), a raw URL
     * entered through the admin form, "#", or be empty. Views must never call
     * route() directly on it: route() on a non-route value throws and returns
     * a 500. This accessor returns a safe href for every case.
     */
    public function getLinkUrlAttribute(): string
    {
        $link = $this->link;

        if (empty($link) || $link === '#') {
            return route('frontend.products');
        }

        return Route::has($link) ? route($link) : $link;
    }
}
