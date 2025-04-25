<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            })->with('category')->latest()->limit(6)->get();
        });

        $monthlyProducts = Cache::remember('monthlyProducts', 43200, function () {
            $currentMonth = Carbon::now()->month;
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->whereMonth('created_at', $currentMonth)->with('category')->limit(18)->get();
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
            })->inRandomOrder()->with('category')->limit(8)->get();
        });


        $randomProducts = Cache::remember('randomProducts', 43200, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->inRandomOrder()->limit(12)->get();
        });


        $timeoutAt = Carbon::now()->addSeconds(3);
        $categoryProducts = collect();
        do {
            $categoryToDisplay = Cache::remember('categoryToDisplay', 43200, function () {
                return Category::where('status', 'active')->inRandomOrder()->first();
            }) ?? null;

            if ($categoryToDisplay->products()->exists()) {
                $categoryProducts = Cache::remember('categoryProducts', 43200, function () use ($categoryToDisplay) {
                    return $categoryToDisplay->products()->whereHas('magasin', function ($query) {
                        $query->where('status', 'active');
                    })->inRandomOrder()->with('category')->limit(6)->get();
                });
            }
            if (Carbon::now()->greaterThan($timeoutAt)) {
                $categoryProducts = collect();
                break;
            }
        } while ($categoryProducts->isEmpty());

        //! Banners Selection


        return view('frontend.index', compact(
            'sliderProducts',
            'secondSliderProducts',
            'monthlyProducts',
            'regularProducts',
            'randomProducts',
            'categoryProducts'
        ));
    }

    public function cart()
    {
        $user = Auth::user();
        if ($user) {
            return view('frontend.pages.cart_view');
        } else {
            return redirect()->route('login');
        }
    }
    public function compare()
    {
        return view('frontend.pages.compare');
    }
    public function wishlist()
    {
        return view('frontend.pages.wishlist');
    }
    public function checkOut()
    {
        $user = Auth::user();
        $shippingAddresses =  Address::where('user_id', $user->id)->where('type', 'shipping')->get();
        $billingAddresses =  Address::where('user_id', $user->id)->where('type', 'billing')->get();
        $principalAddress = Address::where('user_id', $user->id)->where('type', 'shipping')->where('principalAddress', true)->first();
        return view('frontend.pages.check_out', compact('shippingAddresses', 'billingAddresses', 'principalAddress'));
    }
    public function contact()
    {
        return view('frontend.pages.contact');
    }
}
