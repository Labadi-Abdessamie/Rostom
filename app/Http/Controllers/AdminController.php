<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        $totalClients = User::where('role', 'client')->count();
        $totalVendors = User::where('role', 'vendor')->count();
        $magasins = Magasin::all();
        $totalProducts = Product::count();
        $latestOrders = Order::with(['customer', 'vendor'])
            ->latest()
            ->take(10)
            ->get();


        return view('admin.admindashboard', compact('totalClients', 'totalVendors', 'totalProducts','magasins','products','latestOrders'));
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.adminusers', compact('users'));
    }

    public function manageVendors()
    {
        $vendors = User::where('role', 'vendor')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function manageProducts()
    {
        $products = Product::all();
        return view('admin.adminproducts', compact('products'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user')); // ✅ go to dedicated edit form
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
}
