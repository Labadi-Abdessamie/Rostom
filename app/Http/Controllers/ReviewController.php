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
        if ($request->hasFile('image')) {
            $files = $request->file('image');

            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $path = $file->store('reviews', 'public');
                    $basename = basename($path);

                    ReviewImage::create([
                        'path' => $basename,
                        'review_id' => $review->id
                    ]);
                }
            }
        }



        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);
        $review = Review::where('id', $id)->where('user_id', Auth::id())->first();

        if ($review) {
            $product = Product::findorFail($review->product_id);
            $product->rate_average = ($product->rate_average - $review->rate + $request->rate) / $product->rate_count;
            $product->save();

            $review->update([
                'rate' => $request->input('rate'),
                'content' => $request->input('content'),
            ]);
            return redirect()->back()->with('success', 'Review updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Review not found or unauthorized.');
        }
    }
    public function destroy($id)
    {
        if (Auth::user()->role == "admin") {
            $review = Review::where('id', $id)->first();
        } else {
            $review = Review::where('id', $id)->where('user_id', Auth::id())->first();
        }
        if ($review) {
            $product = Product::findorFail($review->product_id);
            if ($product->rate_count - 1 == 0) {
                $product->rate_average = 0;
            } else {
                $product->rate_average = ($product->rate_average - $review->rate) / ($product->rate_count - 1);
            }
            $product->rate_count--;
            $product->save();
            $review->delete();
            return redirect()->back()->with('success', 'Review deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Review not found or unauthorized.');
        }
    }
}
