<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    /**
     * Store variants for a product
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Verify vendor owns this product
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.quantity' => 'required|integer|min:0|max:999999',
            'variants.*.extraPrice' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['variants'] as $variantData) {
            // Only create if color or size is provided
            if (!empty($variantData['color']) || !empty($variantData['size'])) {
                Variant::create([
                    'color' => $variantData['color'] ?? null,
                    'size' => $variantData['size'] ?? null,
                    'quantity' => $variantData['quantity'],
                    'extraPrice' => $variantData['extraPrice'] ?? 0,
                    'product_id' => $product->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Variants added successfully.');
    }

    /**
     * Update a specific variant
     */
    public function update(Request $request, $id)
    {
        $variant = Variant::findOrFail($id);
        $product = $variant->product;

        // Verify vendor owns this product
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'color' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0|max:999999',
            'extraPrice' => 'nullable|numeric|min:0',
        ]);

        $variant->update($validated);

        return redirect()->back()->with('success', 'Variant updated successfully.');
    }

    /**
     * Delete a variant
     */
    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $product = $variant->product;

        // Verify vendor owns this product
        if ($product->magasin_id !== Auth::user()->magasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Check if variant has associated order items
        if ($variant->orderItems()->count() > 0) {
            return redirect()->route('vendor.products')->with('error', 'Cannot delete variant with existing orders.');
        }

        $variant->delete();

        return redirect()->route('vendor.products')->with('success', 'Variant deleted successfully.');
    }

    /**
     * Get total stock for a product (base + all variants)
     */
    public function getTotalStock($productId)
    {
        $product = Product::findOrFail($productId);
        $variantStock = $product->variant()->sum('quantity');
        return $product->actual_quantity + $variantStock;
    }
}
