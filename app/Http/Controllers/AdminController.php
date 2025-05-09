<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClients = User::where('role', 'client')->where('status', 'active')->count();
        $totalVendors = User::where('role', 'vendor')->where('status', 'active')->count();
        $totalMagasins = Magasin::count();
        $totalActiveMagasins = Magasin::where('status', 'active')->count();
        $totalAdmins =   User::where('role', 'admin')->count();
        $totalProducts = Product::count();
        $avgRating = Review::avg('rate');
        $totalReviews = Review::count();
        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $topMagasinsRating = Magasin::orderBy('rate', 'desc')->take(5)->get();
        $bestSellingProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
        return view('admin.index', compact('totalClients', 'totalVendors', 'totalProducts', 'latestOrders', 'totalActiveMagasins', 'totalMagasins', 'totalAdmins', 'avgRating', 'totalReviews', 'topMagasinsRating', 'bestSellingProducts'));
    }

    public function customers($type = null)
    {
        if (is_null($type)) {
            $title = "Clients";
            $users = User::where('role', 'client')->get();
        } elseif ($type === "blocked") {
            $title = "Blocked Clients";
            $users = User::where('role', 'client')->where('status', 'blocked')->get();
        } elseif ($type === "inactive") {
            $title = "Inactive Clients";
            $users = User::where('role', 'client')->where('status', 'inactive')->get();
        } else {
            return redirect()->route('admin.customers');
        }
        return view('admin.pages.customers', compact('users', 'title'));
    }

    public function vendors($type = null)
    {
        $perPage = 10;
        if (is_null($type)) {
            $title = "Vendors";
            $vendors = User::where('role', 'vendor')->paginate($perPage);
        } elseif ($type === "blocked") {
            $title = "Blocked Vendors";
            $vendors = User::where('status', 'blocked')->paginate($perPage);
        } else {
            return redirect()->route('admin.vendors');
        }
        return view('admin.pages.vendors', compact('vendors', 'title'));
    }

    public function admins()
    {
        $admins = User::where('role', 'admin')->paginate(10);

        $totalAdmins = User::where('role', 'admin')->count();
        return view('admin.pages.admins', compact('admins', 'totalAdmins'));
    }

    //! PROFILE
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.pages.profile', compact('admin'));
    }

    //! Products
    public function products()
    {
        $products = Product::with('magasin')->paginate(10);
        $totalProducts = Product::count();
        return view('admin.pages.products', compact('products', 'totalProducts'));
    }

    //! REVIEWS
    public function reviews()
    {
        $reviews = Review::with('user', 'product')->paginate(10);
        return view('admin.pages.reviews', compact('reviews'));
    }

    //! ORDERS
    public function orders()
    {
        $orders = Order::with(['user', 'shippingAddress', 'billingAddress'])->get();

        return view('admin.pages.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pages.orderDetails', compact('order'));
    }
}
