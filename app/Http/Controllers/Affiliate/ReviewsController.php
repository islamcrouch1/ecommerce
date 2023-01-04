<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function store($product, Request $request)
    {

        $request->validate([
            'rating' => "required|numeric",
            'review' => "required|string|max:255",
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($product);

        if (Review::where('product_id', $product->id)->where('user_id', $user->id)->get()->count() == 0) {
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            alertSuccess('Your review added successfully', 'تم اضافة تقييمك بنجاح');
        } else {
            alertError('Sorry, you already reviewd this product', 'ناسف , لقد قمت بتقييم هذا المنتج سابقا');
        }

        return redirect()->route('affiliate.products.product', ['product' => $product->id]);
    }
}
