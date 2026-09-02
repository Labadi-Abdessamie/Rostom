<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Magasin;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name          = $request->query('name', null);
        $categoryId    = $request->query('category', null);
        $sortBy        = $request->query('sort_by', 'default');
        $minRating     = (int) $request->query('min_rating', 0);
        $perPage       = (int) $request->query('per_page', 12);
        if (!in_array($perPage, [12, 15, 18, 21, 24, 48])) {
            $perPage = 12;
        }

        $query = Magasin::query()->where('status', 'active');

        if ($name) {
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                  ->orWhere('email', 'like', "%{$name}%")
                  ->orWhere('phoneNumber', 'like', "%{$name}%")
                  ->orWhere('location', 'like', "%{$name}%");
            });
        }

        if ($categoryId) {
            $query->whereHas('products.category', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId)
                  ->orWhere('categories.parentId', $categoryId);
            });
        }

        if ($minRating > 0) {
            $query->where('rate', '>=', $minRating);
        }

        switch ($sortBy) {
            case 'rating_high':
                $query->orderByDesc('rate');
                break;
            case 'rating_low':
                $query->orderBy('rate');
                break;
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            case 'name_desc':
                $query->orderByDesc('name');
                break;
            default:
                $query->inRandomOrder();
        }

        $vendors       = $query->paginate($perPage)->appends($request->query());
        $categories    = Category::where('status', 'active')->orderBy('name')->get();
        $totalVendors  = $vendors->total();

        return view('frontend.pages.vendor', compact(
            'vendors', 'name', 'categoryId', 'sortBy', 'minRating',
            'perPage', 'categories', 'totalVendors'
        ));
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
        $vendor = Magasin::findorFail($id);
        if ($vendor->status === 'active') {
            $products = $vendor->products()->with('productImages')->paginate(12);
            return view('frontend.pages.vendor_details', compact('vendor', 'products'));
        } elseif ($vendor->status === 'inactive') {
            return view('frontend.pages.vendor')->with('message', "This Magasin is inactive for now");
        } elseif ($vendor->status === 'blocked') {
            return view('frontend.pages.vendor')->with('message', "This Magasin is blocked for now");
        }
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

