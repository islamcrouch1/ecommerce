<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Product;
use App\Models\ShippingRate;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rates = ShippingRate::where('country_id', $user->country->id)->get();
        foreach ($user->cart->products as $product) {
            if ($product->pivot->product_type == 0) {
                $stock = $product->stocks->find($product->pivot->stock_id);
            } else {
                // check for affiliate stock -- need to update
                $stock = $product->stocks->find($product->pivot->stock_id);
            }
            if ($product->pivot->product_price != $product->price || $stock == NULL) {
                $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
                alertError('Some prices of the products in your cart have been updated, please check the order again', 'تم تحديث بعض أسعار المنتجات الموجودة بسلة مشترياتك يرجى مراجعة الطلب مرة أخرى');
                return redirect()->route('cart');
            }
        }
        return view('affiliate.cart.index', compact('user', 'rates'));
    }


    public function store(Request $request)
    {

        $product = Product::find($request->product_id);
        $stock = $request->stock_id;
        $product_type = $request->product_type;

        if ($product_type == '0') {
            $av_stock = Stock::find($stock);
            $quantity = $av_stock->quantity;
        }


        // else {
        //     $av_stock = Astock::find($stock);
        //     $stock = $av_stock->stock;
        // }

        $max = $product->max_price;
        $min = $product->price;


        if ($request->quantity > $quantity || $request->quantity <= 0) {
            return 2;
        }


        if ($request->selected_price < $min || $request->selected_price > $max) {
            return 3;
        }

        if ($request->product_price != $product->price) {
            return 4;
        }


        $cart = Auth()->user()->cart;
        $selected_price = ceil($request->selected_price);


        $cart_product = $cart->products()->where('stock_id', $request->stock_id);

        if ($cart_product->count() > 0) {

            $product_quantity = $cart_product->first()->pivot->quantity;
            DB::table('cart_product')->where('stock_id', $cart_product->first()->pivot->stock_id)->update([
                'quantity' => ($request->quantity + $product_quantity),
            ]);


            return 0;
        }

        $cart->products()->attach($product->id, ['stock_id' => $request->stock_id, 'quantity' => $request->quantity, 'price' => $selected_price, 'product_price' => $product->price, 'product_type' => $product_type, 'size_ar' => $av_stock->size->size_ar, 'size_en' => $av_stock->size->size_en, 'color_en' => $av_stock->color->color_en, 'color_ar' => $av_stock->color->color_ar]);

        return 1;
    } //end of products


    public function destroy($product, $stock)
    {
        $product = Product::find($product);
        $user = Auth::user();
        $cart = $user->cart;
        $cart->products()->wherePivot('stock_id', $stock)->detach();
        return redirect()->route('cart');
    }


    public function changeQuantity(Request $request)
    {
        $cart = Auth()->user()->cart;
        $cart_product = $cart->products()->where('stock_id', $request->stock_id);
        DB::table('cart_product')->where('stock_id', $cart_product->first()->pivot->stock_id)->update([
            'quantity' => $request->quantity,
        ]);
    }
}
