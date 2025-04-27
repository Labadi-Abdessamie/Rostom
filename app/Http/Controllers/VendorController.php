<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Magasin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Magasin::where('status', 'active')->inRandomOrder()->paginate(12);

        return view('frontend.pages.vendor', compact('vendors'));
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
