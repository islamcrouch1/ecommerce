<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function store(Request $request, Product $product)
    {

        $request->validate([
            'store_price' => "required|numeric",
            'product_price' => "required|numeric",
        ]);

        $user = Auth::user();

        if (StoreProduct::where('user_id', $user->id)->where('product_id', $product->id)->get()->count() == 0) {

            if ($request['product_price'] != $product->price) {
                alertError('The price of the product has changed, please check the new price and try to place the order again.', 'تم تغيير سعر المنتج، يرجى مراجعة السعر الجديد ومحاولة عمل الطلب مرة أخرى.');
            } else {

                $store_product = StoreProduct::create([
                    'store_price' => $request['store_price'],
                    'product_price' => $request['product_price'],
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                ]);

                alertSuccess('The product has been added to your sale page', 'تم إضافة المنتج في صفحة البيع الخاصة بك');
            }
        } else {

            alertError('This product is already on your sale page', 'هذا المنتج موجود بالفعل في صفحة البيع الخاصة بك');
        }

        return redirect()->route('mystore.show');
    }


    public function show()
    {

        $user = Auth::user();

        $products = StoreProduct::where('user_id', $user->id)->get();

        foreach ($products as $product) {

            if ($product->product_price != $product->product->price) {
                $product->delete();
                alertError('Some products have been removed from your page due to a change in their prices by the administration', 'تم حذف بعض المنتجات من صفحتك بسبب تغيير اسعارها من قبل الادارة');
            }
        }

        $products = StoreProduct::where('user_id', $user->id)
            ->latest()
            ->paginate(50);

        return view('affiliate.products.mystore')->with('products', $products);
    }


    public function destroy(StoreProduct $product)
    {
        $product->delete();
        alertSuccess('The product has been removed from your sale page', 'تم حذف المنتج من صفحة البيع الخاصة بك');
        return redirect()->route('mystore.show');
    }
}
