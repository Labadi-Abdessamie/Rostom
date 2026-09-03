<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Website;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $DefaultInformations = [
            'url' => 'youtube.com',
            'name' => 'TiarShop',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'description' => 'Platform E-commerce Multi-vendors',
            'owner' => 'TiarShop',
            'language' => 'en',
            'contact_email' => 'support@tiarshop.com',
            'contact_phone' => '798841989',
            'social_media_links' => '{
                "facebook" : "facebook.com",
                "instagram" : "instagram.com"
                }
            ',
            'customers_number' => 0,
            'vendors_number' => 0,
            'products_number' => 0,
            'ordersDone_number' => 0,
            'rules_and_privacy' => 'rules.pdf'
        ];
        try {
            DB::connection()->getPdo();

            if (Schema::hasTable('categories')) {
                View::share('categories', Cache::remember('categories', 43200, function () {
                    return Category::WhereNull('parentId')->where('status', 'active')->with([
                        'childrens' => function ($query) {
                            $query->where('status', 'active')
                                ->with([
                                    'childrens' => function ($query) {
                                        $query->where('status', 'active');
                                    }
                                ]);
                        }
                    ])->get();
                }));
            } else {
                View::share('categories', null);
            }
            if (Schema::hasTable('websites')) {
                View::share('website', Cache::remember('website', 43200, function () use ($DefaultInformations) {
                    return Website::first() ?? (object) $DefaultInformations;
                }));
            } else {
                View::share('website', (object) $DefaultInformations);
            }
        } catch (\Exception $e) {
            View::share('categories', null);
            View::share('website', (object) $DefaultInformations);
        }
        Paginator::useBootstrap();
    }
}
