<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($category = 'category')
    {
        $cart = session()->get('cart', []);
        $products = Product::whereHas('magasin', function ($query) {
            $query->where('status', 'active');
        })->where('actual_quantity', '>', '0')->latest()->paginate(12);

        return view('frontend.pages.product_view', compact('products', 'category', 'cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $cart = session()->get('cart', []);
        $product = Product::whereHas('magasin', function ($query) {
            $query->where('status', 'active');
        })->with('magasin')->findorFail($id);

        $reviews = Review::where('product_id', $id)->whereHas('user', function ($query) {
            $query->where('status', '!=', 'blocked');
        })->with(['user:id,name,profilePicture', 'images:id,review_id,path'])->latest()->paginate(3);

        return view('frontend.pages.product_details', compact('product', 'reviews', 'cart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
