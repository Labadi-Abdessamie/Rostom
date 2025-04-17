<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClients = User::where('role', 'client')->count();
        $totalVendors = User::where('role', 'vendor')->count();
        $totalProducts = Product::count();

        return view('admin.dashboard', compact('totalClients', 'totalVendors', 'totalProducts'));
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function manageVendors()
    {
        $vendors = User::where('role', 'vendor')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function manageProducts()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
