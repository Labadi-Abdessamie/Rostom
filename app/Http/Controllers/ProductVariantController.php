<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVariantController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.variant_type_id' => 'nullable|integer',
            'variants.*.value' => 'nullable|string|max:50',
            'variants.*.quantity' => 'required|integer|min:0|max:999999',
            'variants.*.extra_price' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['variants'] as $variantData) {
            if (!empty($variantData['value']) || !empty($variantData['variant_type_id'])) {
                Variant::create([
                    'product_id' => $product->id,
                    'variant_type_id' => $variantData['variant_type_id'] ?? null,
                    'value' => $variantData['value'] ?? null,
                    'quantity' => $variantData['quantity'],
                    'extra_price' => $variantData['extra_price'] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Variants added successfully.');
    }

    public function update(Request $request, $id)
    {
        $variant = Variant::findOrFail($id);
        $product = $variant->product;
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'value' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0|max:999999',
            'extra_price' => 'nullable|numeric|min:0',
            'variant_type_id' => 'nullable|integer',
        ]);

        $variant->update($validated);
        return redirect()->back()->with('success', 'Variant updated successfully.');
    }

    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $product = $variant->product;
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if ($variant->orderItems()->count() > 0) {
            return redirect()->route('vendor.products')->with('error', 'Cannot delete variant with existing orders.');
        }
        $variant->delete();
        return redirect()->route('vendor.products')->with('success', 'Variant deleted successfully.');
    }

    public function getTotalStock($productId)
    {
        $product = Product::findOrFail($productId);
        $variantStock = $product->variant()->sum('quantity');
        return $product->actual_quantity + $variantStock;
    }
}
