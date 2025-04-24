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
    public function deleteCustomer($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Client deleted successfully.');
    }

    public function magasins($filtre = null)
{
    if (is_null($filtre)) {
        $magasins = Magasin::with('user')->paginate(10);
    } else if ($filtre === "demands") {
        $magasins = Magasin::with('user')->where('status', 'inactive')->paginate(10); // Maybe me(Mus) changes it
    } else {
        return redirect()->route('admin.magasins');
    }

    return view('admin.pages.magasins', compact('magasins','filtre'));
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
    $magasin->update(['status' => 'rejected']);
    return redirect()->route('admin.magasins', ['filtre' => 'demands'])->with('success', 'Magasin rejected successfully.');
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
public function updateMagasin(Request $request, $id){
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
    public function deleteVendor($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->delete();
        return redirect()->back()->with('success', 'Vendor deleted successfully.');
    }
    public function showEditVendor($id)
    {
        $vendor = User::findOrFail($id);
        return view('admin.pages.edit_vendor', compact('vendor'));
    }
    public function updateVendor(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // Fix email validation
        'phoneNumber' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'status' => 'required|in:active,inactive,blocked',
    ]);

    // Find the vendor (User) by ID
    $vendor = User::findOrFail($id);

    // Update the vendor with the validated data
    $vendor->update($request->only(['name', 'email', 'phoneNumber', 'location', 'status']));

    // Redirect with a success message
    return redirect()->route('admin.vendors')->with('success', 'Vendor updated successfully.');
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
