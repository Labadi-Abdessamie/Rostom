<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        //! Products Selection

        $sliderProducts = Cache::remember('sliderProducts', 43200, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->latest()->limit(6)->get();
        });

        $monthlyProducts = Cache::remember('monthlyProducts', 43200, function () {
            $currentMonth = Carbon::now()->month;
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->whereMonth('created_at', $currentMonth)->limit(18)->get();
        });

        $secondSliderProducts = Cache::remember('secondSliderProducts', 43200, function () {

            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->latest()
                ->whereNotIn('id', cache()->get('sliderProducts')->pluck('id'))
                ->limit(5)
                ->get();
        });

        $regularProducts = Cache::remember('regularProducts', 43200, function () {

            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->inRandomOrder()->limit(8)->get();
        });


        $randomProducts = Cache::remember('randomProducts', 43200, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->inRandomOrder()->limit(12)->get();
        });

        $timeoutAt = Carbon::now()->addSeconds(3);
        do {

            $categoryToDisplay = Cache::remember('categoryToDisplay', 43200, function () {
                return Category::where('status', 'active')->inRandomOrder()->first();
            });

            if ($categoryToDisplay->products) {
                $categoryProducts = Cache::remember('categoryProducts', 43200, function () {
                    return cache()->get('categoryToDisplay')->products()->whereHas('magasin', function ($query) {
                        $query->where('status', 'active');
                    })->inRandomOrder()->limit(6)->get();
                });
            }
            if (Carbon::now()->greaterThan($timeoutAt)) {
                $categoryProducts = null;
                break;
            }
        } while (count($categoryProducts) == 0);

        //! Banners Selection



        $cart = session()->get('cart', []);

        return view('frontend.index', compact(
            'sliderProducts',
            'secondSliderProducts',
            'monthlyProducts',
            'regularProducts',
            'randomProducts',
            'categoryProducts',
            'cart'
        ));
    }
}
