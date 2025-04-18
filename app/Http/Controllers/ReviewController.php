<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'min:1', 'max:5'],
            'content' => ['required', 'min:2', 'max:255'],
            //'image' => []
        ]);

        $review = Review::create([
            'rate' => $request->rating,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $product = Product::findorFail($request->product_id);
        $product->rate_average = ($product->rate_average + $request->rating) / ($product->rate_count + 1);
        $product->rate_count++;
        $product->save();

        //! save the picture
        /*
        ReviewImage::create([
            'path' =>'',
            'review_id' => $review->id
        ]);
        */
        return redirect()->back();
    }
    public function destroy() {}
}
