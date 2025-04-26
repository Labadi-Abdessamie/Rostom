<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Magasin;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
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

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $type = $user->role;
        return view('admin.pages.edit_user', compact('user', 'type'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }
    public function deleteUser($id)
    {
        //! add here to change the pending orders to cancelled and the reviews to anynomus
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
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
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pages.orderDetails', compact('order'));
    }



    //! MAGASINS
    public function magasins($filtre = null)
    {
        if (is_null($filtre)) {
            $magasins = Magasin::with('user')->paginate(10);
        } else if ($filtre === "demands") {
            $magasins = Magasin::with('user')->where('status', 'firstOpening')->paginate(10); // Maybe me(Mus) changes it
        } else {
            return redirect()->route('admin.magasins');
        }
        return view('admin.pages.magasins', compact('magasins', 'filtre'));
    }
    public function approveMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Magasin approved successfully.');
    }
    public function rejectMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->delete();
        return redirect()->route('admin.magasins', ['filtre' => 'demands'])->with('success', 'Magasin rejected and deleted successfully.');
    }
    public function deleteMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->delete();
        return redirect()->back()->with('success', 'Magasin deleted successfully.');
    }
    public function showEditMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        return view('admin.pages.edit_magasin', compact('magasin'));
    }
    public function updateMagasin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,{$id}',
            'phoneNumber' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'magasinPicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rate' => 'nullable|numeric|min:0|max:5',
            'magasinOpen' => 'required|boolean',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $magasin = Magasin::findOrFail($id);
        $magasin->update($request->only(['name', 'email', 'phoneNumber', 'location', 'magasinOpen', 'rate', 'status']));

        if ($request->hasFile('magasinPicture')) {
            $path = $request->file('magasinPicture')->store('images/magasins');
            $magasin->update(['magasinPicture' => $path]);
        }

        return redirect()->route('admin.magasins')->with('success', 'Magasin updated successfully.');
    }
}
