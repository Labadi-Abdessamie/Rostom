<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
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


        View::share('categories', Cache::remember('categories', 21600, function () {
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
        Paginator::useBootstrap();
    }
}
