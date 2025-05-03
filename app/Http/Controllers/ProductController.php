<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Magasin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Existing index code - no changes needed
        $categoryId = $request->query('category', null);
        $sort = $request->query('sort', null);
        $perPage = $request->query('number', 12);

        $queryFilter = $request->query('name', null);
        if ($queryFilter) {
            $products = Product::where('name', 'like', '%' . $queryFilter . '%')->paginate(12);
        } else {
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
        }

        return view('frontend.pages.product_view', compact('products', 'queryFilter'));


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
        $magasin = Auth::user()->magasin;
        $magasinCategoryId = $magasin->category_id;

        $subcategories = Category::where('parentId', $magasinCategoryId)
            ->where('status', 'active')
            ->get();

        $categoryChildrenMap = [];
        foreach ($subcategories as $subcategory) {
            $children = Category::where('parentId', $subcategory->id)
                ->where('status', 'active')
                ->get(['id', 'name']);

            if ($children->count() > 0) {
                $childrenArray = $children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name
                    ];
                })->toArray();

                $categoryChildrenMap[$subcategory->id] = $childrenArray;
            }
        }

        return view('vendor.pages.add_product', [
            'subcategories' => $subcategories,
            'categoryChildrenMap' => $categoryChildrenMap,
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
            'actual_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'principalImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'sub_subcategory_id' => 'nullable|exists:categories,id',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->actual_quantity = $request->actual_quantity ?? 0;
        $product->price = $request->price;
        $product->magasin_id = Auth::user()->magasin->id;

        $product->category_id = $request->filled('sub_subcategory_id')
            ? $request->sub_subcategory_id
            : $request->category_id;

        $product->rate_average = 0;
        $product->rate_count = 0;

        $product->save();

        if ($request->hasFile('principalImage')) {
            $imagePath = $request->file('principalImage')->store('products_images/' . $product->id, 'public');
            $product->principalImage = basename($imagePath);
            $product->save();
        }


        return redirect()->route('vendor.products')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Existing show code - no changes needed
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
        $product = Product::findOrFail($id);

        $vendor = Auth::user();
        $magasin = $vendor->magasin;

        $mainCategoryId = $magasin->category_id;

        $subcategories = Category::where('parentId', $mainCategoryId)
            ->where('status', 'active')
            ->get();

        $categoryChildrenMap = [];
        foreach ($subcategories as $subcategory) {
            $children = Category::where('parentId', $subcategory->id)
                ->where('status', 'active')
                ->get(['id', 'name']);

            if ($children->count() > 0) {
                $childrenArray = $children->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name
                    ];
                })->toArray();

                $categoryChildrenMap[$subcategory->id] = $childrenArray;
            }
        }

        $productCategory = $product->category;
        $currentSubcategoryId = null;
        $currentSubSubcategoryId = null;

        if ($productCategory && $productCategory->parentId) {
            $parentCategory = Category::find($productCategory->parentId);

            if ($parentCategory && $parentCategory->parentId) {
                $currentSubcategoryId = $parentCategory->id;
                $currentSubSubcategoryId = $productCategory->id;
            } else {
                $currentSubcategoryId = $productCategory->id;
            }
        }

        return view('vendor.pages.edit_product', compact(
            'product',
            'subcategories',
            'categoryChildrenMap',
            'currentSubcategoryId',
            'currentSubSubcategoryId'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
            'actual_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'principalImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'sub_subcategory_id' => 'nullable|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->actual_quantity = $request->actual_quantity;
        $product->price = $request->price;

        if ($request->hasFile('principalImage')) {
            if ($product->principalImage && Storage::disk('public')->exists($product->principalImage)) {
                Storage::disk('public')->delete($product->principalImage);
            }

            $imagePath = $request->file('principalImage')->store('products', 'public');
            $product->principalImage = $imagePath;
        }

        $product->category_id = $request->filled('sub_subcategory_id')
            ? $request->sub_subcategory_id
            : $request->category_id;

        $product->save();

        return redirect()->route('vendor.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);


        if ($product->principalImage && Storage::disk('public')->exists($product->principalImage)) {
            Storage::disk('public')->delete($product->principalImage);
        }

        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
