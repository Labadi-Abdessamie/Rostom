<?php

namespace App\Http\Controllers;

use App\Mail\contactMail;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        //! Products Selection

        $sliderProducts = Cache::remember('sliderProducts', 21600, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->with('category')->with('productImages')->latest()->limit(6)->get();
        });

        $monthlyProducts = Cache::remember('monthlyProducts', 21600, function () {
            $currentMonth = Carbon::now()->month;
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->whereMonth('created_at', $currentMonth)->with('category')->limit(18)->get();
        });

        $secondSliderProducts = Cache::remember('secondSliderProducts', 21600, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->latest()
                ->whereNotIn('id', cache()->get('sliderProducts')->pluck('id'))
                ->limit(5)
                ->with('productImages')
                ->get();
        });

        $regularProducts = Cache::remember('regularProducts', 21600, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->inRandomOrder()->with('category')->limit(8)->with('productImages')->get();
        });


        $randomProducts = Cache::remember('randomProducts', 21600, function () {
            return Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })->inRandomOrder()->limit(12)->get();
        });


        $timeoutAt = Carbon::now()->addSeconds(0.5);
        $categoryProducts = collect();
        do {
            $categoryToDisplay = Cache::remember('categoryToDisplay', 21600, function () {
                return Category::where('status', 'active')->inRandomOrder()->first();
            }) ?? null;

            if ($categoryToDisplay && $categoryToDisplay->products()->exists()) {
                $categoryProducts = Cache::remember('categoryProducts', 21600, function () use ($categoryToDisplay) {
                    return $categoryToDisplay->products()->whereHas('magasin', function ($query) {
                        $query->where('status', 'active');
                    })->inRandomOrder()->limit(6)->with('category')->with('productImages')->get();
                });
            }
            if (Carbon::now()->greaterThan($timeoutAt)) {
                $categoryProducts = collect();
                break;
            }
        } while ($categoryProducts->isEmpty());

        //! Banners Selection
        $banners = Cache::remember('banners', 43200, function () {
            $collection = Banner::where('status', 'active')->limit(3)->get();
            if ($collection->count() > 0) {
                return $collection;
            } else {
                $collect = collect();
                $defaultbanner = new Banner();
                $defaultbanner->title = 'New Arrivale';
                $defaultbanner->description = 'men\'s fashion';
                $defaultbanner->image = 'defaultbanner.jpg';
                $defaultbanner->link = 'frontend.products';
                $collect->add($defaultbanner);
                return $collect;
            }
        });


        return view('frontend.index', compact(
            'sliderProducts',
            'secondSliderProducts',
            'monthlyProducts',
            'regularProducts',
            'randomProducts',
            'categoryProducts',
            'banners'
        ));
    }

    public function dashboard()
    {
        switch (Auth::user()->role) {
            case "client":
                return redirect()->route('client.dashboard');
                break;
            case "vendor":
                return redirect()->route('vendor.dashboard');
                break;
            case "admin":
                return redirect()->route('admin.dashboard');
                break;
            default:
                Auth::guard('web')->logout();
                return redirect('/');
                break;
        }
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
    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:10',
            'subject' => 'required|string|max:50',
            'message' => 'required|string|max:1024'
        ]);
        if (Website::first()) {
            if (Website::first()->contact_email != null) {
                Mail::to(Website::first()->contact_email)->queue(new contactMail($validated));
                return redirect()->back()->with('message', 'Message sent successfully.')->with('alert-type', 'suceess');
            }
        } else {
            return redirect()->back()->with('message', 'Can\'t send message.')->with('alert-type', 'error');
        }
    }
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'nullable|string'
        ]);
        if ($validated['query']) {
            $query = $validated['query'];
            return redirect()->route('frontend.products', ['name' => $query]);
        }
        return redirect()->route('frontend.products');
    }
    public function searchVendor(Request $request)
    {
        $validated = $request->validate([
            'query' => 'nullable|string'
        ]);
        if ($validated['query']) {
            $query = $validated['query'];
            return redirect()->route('frontend.vendor', ['name' => $query]);
        }
        return redirect()->route('frontend.vendor');
    }
}
