<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ProductCombinationDtl;
use App\Models\Slide;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {


        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        }

        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        $slides = Slide::orderBy('sort_order', 'asc')->get();

        // $products = Product::whereHas('stocks', function ($query) {
        //     $query->where('qty', '!=', '0');
        // })
        //     ->where('status', "active")
        //     ->whenSearch(request()->search)
        //     ->latest()
        //     ->paginate(20);


        $digital_products = Product::Where('product_type', 'digital')
            ->where('status', "active")
            ->where('country_id', setting('country_id'));


        $service_products = Product::Where('product_type', 'service')
            ->where('status', "active")
            ->where('country_id', setting('country_id'));

        $vendor_products = Product::WhereNotNull('vendor_id')
            ->where('status', "active")
            ->where('country_id', setting('country_id'));


        $warehouses = getWebsiteWarehouses();

        $products = Product::whereHas('stocks', function ($query) use ($warehouses) {
            $query->whereIn('warehouse_id', $warehouses);
        })
            ->where('country_id', setting('country_id'))
            ->where('status', "active")
            ->union($digital_products)
            ->union($service_products)
            ->union($vendor_products)
            ->latest()
            ->get();

        return view('ecommerce.home', compact('categories', 'slides', 'products', 'cart_items'));
    }



    public function about(Request $request)
    {
        return view('ecommerce.about');
    }

    public function contact(Request $request)
    {
        return view('ecommerce.contact');
    }

    public function terms(Request $request)
    {
        return view('ecommerce.terms');
    }


    public function getProductPrice(Request $request)
    {

        $request->validate([
            'variations' => "required|string",
            'product_id' => "required|string",
        ]);



        $product = Product::findOrFail($request->product_id);
        $attributes_count = $product->attributes->count();
        $variations = explode(",", $request->variations);
        $selected_attributes_count = count($variations);

        if ($selected_attributes_count < $attributes_count) {
            return 1;
        } elseif ($selected_attributes_count = $attributes_count) {
            $combinations = ProductCombination::where('product_id', $product->id)->get();

            foreach ($combinations as $combination) {
                $count = $combination->variations->whereIn('variation_id', $variations);
                $count =  count($count);
                if ($count == $selected_attributes_count) {

                    $product = $combination->product;
                    return getProductPrice($product, $combination);
                }
            }
        } else {
            return 2;
        }
    }
}
