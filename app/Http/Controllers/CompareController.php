<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        //$compare = session()->get('compare', []);
        //$products = Product::whereIn('id', $compareIds)->get();

        return view('frontend.pages.compare', compact('cart'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $compare = session()->get('compare', []);

        if (!in_array($productId, $compare)) {
            if (count($compare) >= 3) {
                return response()->json(['status' => 'error', 'message' => 'You can only compare 3 products.']);
            }
            $compare[] = $productId;
            session()->put('compare', $compare);
        }

        return response()->json(['status' => 'success']);
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $compare = session()->get('compare', []);
        $compare = array_diff($compare, [$productId]);
        session()->put('compare', $compare);

        return response()->json(['status' => 'success']);
    }
}
