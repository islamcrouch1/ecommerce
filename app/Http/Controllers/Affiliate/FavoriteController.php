<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $id = $user->id;
        $products = Product::whereHas('stocks', function ($query) {
            $query->where('quantity', '!=', '0');
        })
            ->whereHas('fav', function ($query) use ($id) {
                $query->where('user_id', 'like', $id);
            })
            ->where('status', "active")
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(20);
        // $favs = Favorite::where('user_id', $user->id)->paginate(20);
        return view('affiliate.products.favorite', compact('user', 'products'));
    }


    public function add($product)
    {

        $user = Auth::user();
        $product = Product::findOrFail($product);

        if (Favorite::where('product_id', $product->id)->where('user_id', $user->id)->get()->count() == 0) {
            $fav = Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return 1;
        } else {
            $fav = Favorite::where('product_id', $product->id)->where('user_id', $user->id)->first();
            $fav->delete();
            return 2;
        }
    }
}
