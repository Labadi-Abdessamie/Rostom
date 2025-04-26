<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorInterfaceController extends Controller
{
    public function dashboard()
    {
        $vendor = Auth::user();
        //$products = Product::where('vendor_id', $vendor->id)->paginate(10);

        return view('vendor.index'/*, compact('vendor', 'products')*/);
    }
    public function profile()
    {
        $vendor = Auth::user();
        return view('vendor.pages.profile', compact('vendor'));
    }
    public function products()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.products');
    }

    public function orders()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.orders');
    }

    public function purchaseOrders()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.purchase_orders');
    }
    public function reviews()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.reviews');
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

    public function createProduct()
    {
        return view('vendor.products.create');
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
