<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Magasin;

use App\Models\Order;





class VendorInterfaceController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $totalProducts = Product::where('magasin_id', $user->magasin->id)->count();
        $totalOrders = $user->orders()->count();
        $topProducts = Product::where('magasin_id', $user->magasin->id)->withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();
        $totalEarnings = $user->orders()->sum('totalAmount');
        $pendingOrders = $user->orders()->where('status', 'pending')->count();

        return view('vendor.index',compact('totalProducts','totalOrders','totalEarnings','pendingOrders','topProducts'));
    }
    public function profile()
    {
        $vendor = Auth::user();
        return view('vendor.pages.profile', compact('vendor'));
    }
    public function products()
{
    $user = Auth::user();

    
    $magasin = Magasin::where('user_id', $user->id)->first();

    if (!$magasin) {
        
        $products = collect(); 
    } else {
        
        $products = Product::where('magasin_id', $magasin->id)->get();
    }

    return view('vendor.pages.products', compact('products'));
}

public function orders()
{
    $vendor = Auth::user();

    $magasinId = $vendor->magasin->id;

    $orders = Order::whereHas('orderItems.product', function ($query) use ($magasinId) {
        $query->where('magasin_id', $magasinId);
    })->with(['orderItems.product' => function ($query) use ($magasinId) {
        $query->where('magasin_id', $magasinId);
    }])->get();

    $totalOrders = $orders->count();

    return view('vendor.pages.orders', compact('orders', 'totalOrders'));
}

    public function purchaseOrders()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.purchase_orders');
    }
    public function reviews()
    {
$vendor = Auth::user();
$magasin = Magasin::where('user_id', $vendor->id)->first();

$reviews = $magasin->reviews()->with(['user', 'product'])->get();
$totalReviews = $reviews->count();
$averageRating = $reviews->avg('rate');

return view('vendor.pages.reviews', compact('reviews', 'totalReviews', 'averageRating'));
    }
    public function contact()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.contact');
    }
    public function magasin()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.magasin_info');
    }

    public function addProduct()
    {
        return view('vendor.pages.add_product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imagePath
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Product added successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        $product->delete();

        return redirect()->route('vendor.dashboard')->with('success', 'Product deleted successfully!');
    }
}
