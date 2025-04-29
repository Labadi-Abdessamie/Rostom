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
    public function index(Request $request)
    {
        $categoryId = $request->query('category', null);
        $sort = $request->query('sort', null);
        $perPage = $request->query('number', 12);

        $category = null;

        $query = Product::whereHas('magasin', function ($q) {
            $q->where('status', 'active');
        })->whereHas('category', function ($q) {
            $q->where('status', 'active');
        })->with('productImages');

        if ($categoryId) {
            $category = Category::find($categoryId);
            if (!$category || $category->status !== 'active') {
                return redirect()->route('frontend.products')
                    ->with('message', 'This category is not active');
            }
            $query->where('category_id', $categoryId);
        }

        switch ($sort) {
            case 'rating':
                $query->orderByDesc('rate_average');
                break;
            case 'latest':
                $query->orderByDesc('created_at');
                break;
            case 'low_high':
                $query->orderBy('price');
                break;
            case 'high_low':
                $query->orderByDesc('price');
                break;
            default:
                $query->latest();
                break;
        }
        $products = $query->paginate($perPage)->appends($request->query());

        return view('frontend.pages.product_view', compact('products', 'category'));


        //! Precedent code works without filters
        /*
        $categoryId = $request->query('category');

        $category = null;
        if (is_null($categoryId)) {
            $products = Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->where('actual_quantity', '>', '0')->latest()->paginate(12);
        } else {
            $category = Category::find($categoryId);
            if (!$category || $category->status !== 'active') {
                return redirect()->route('frontend.products')
                    ->with('message', 'This category is not active');
            }
            $products = Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->where('actual_quantity', '>', '0')->where('category_id', $categoryId)->latest()->paginate(12);
        }

        return view('frontend.pages.product_view', compact('products', 'category'));
        */
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
        $product = Product::whereHas('magasin', function ($query) {
            $query->where('status', 'active');
        })->whereHas('category', function ($q) {
            $q->where('status', 'active');
        })->with('magasin')->with('productImages')->findorFail($id);

        $reviews = Review::where('product_id', $id)->whereHas('user', function ($query) {
            $query->where('status', '!=', 'blocked');
        })->with(['user:id,name,profilePicture', 'images:id,review_id,path'])->latest()->paginate(3);

        return view('frontend.pages.product_details', compact('product', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
