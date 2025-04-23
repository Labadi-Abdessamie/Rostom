<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        $totalClients = User::where('role', 'client')->count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalactiveVendors = User::where('role', 'vendor')->where('status', 'active')->count();
        $totalactiveClients = User::where('role', 'client')->where('status', 'active')->count();
        $totalAdmins=   User::where('role', 'admin')->count();
        $totalProducts = Product::count();
        $avgRating = Review::avg('rate');
        $totalReviews = Review::count();
        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $topMagasinsRating = Magasin::orderBy('rate', 'desc')->take(5)->get();
        $bestSellingProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
        return view('admin.index', compact('totalClients', 'totalVendors', 'totalProducts', 'products','latestOrders','totalactiveVendors','totalactiveClients','totalAdmins','avgRating','totalReviews','topMagasinsRating','bestSellingProducts'));
    }

    public function customers($type = null)
    {
        if (is_null($type)) {
            $title = "Clients";
            $users = User::where('role', 'client')->get();
        } elseif ($type === "blocked") {
            $title = "Blocked Clients";
            $users = User::where('role', 'client')->where('status', 'blocked')->get();
        }
        elseif($type ==="inactive"){
            $title = "Inactive Clients";
            $users = User::where('role', 'client')->where('status', 'inactive')->get();

        }
        else {
            return redirect()->route('admin.customers');
        }

        return view('admin.pages.customers', compact('users', 'title'));
    }

    public function magasins($filtre = null)
    {
        if (is_null($filtre)) {
            $Magasins = Magasin::get();
        } else if ($filtre === "demands") {
            $Magasins = Magasin::get();
        } else {
            return redirect()->route('admin.magasins');
        }
        return view('admin.pages.magasins', compact('Magasins'));
    }

    public function vendors($type = null)
    {
        if (is_null($type)) {
            $title = "Vendors";
            $vendors = User::all();
        } elseif ($type === "blocked") {
            $title = "Blocked Vendors";
            $vendors = User::where('status', 'blocked')->get();
        } else {
            return redirect()->route('admin.vendors');
        }

        return view('admin.pages.vendors', compact('vendors', 'title'));
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.pages.products', compact('products'));
    }

    public function banners()
    {
        return view('admin.pages.banners', /*compact('')*/);
    }
    public function banner() {}

    public function addBanner()
    {
        return view('admin.pages.add-banner');
    }

    public function admins()
    {
        return view('admin.pages.admins');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,{$id}',
            'status' => 'required|in:active,inactive,blocked',
            'role' => 'required|in:client,vendor,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'status', 'role'])); // cleaner

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    public function orders()
    {
        $orders = Order::all();
        return view('admin.pages.orders', compact('orders'));
    }
    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pages.orderDetails', compact('order'));
    }
}
