<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\FavItem;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\ShippingRate;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class ProductController extends Controller
{
    public function product(Request $request, Product $product)
    {
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.product', compact('product', 'categories'));
    }


    public function products(Request $request)
    {




        if (!$request->has('pagination')) {
            $request->merge(['pagination' => 24]);
        }

        if (!$request->has('category')) {
            $request->merge(['category' => null]);
        }

        if (!$request->has('brand')) {
            $request->merge(['brand' => null]);
        }

        $cat = request()->category;

        $brand = request()->brand;

        $products = Product::whereHas('stocks', function ($query) {
            $query->where('warehouse_id', '=', setting('warehouse_id'))
                ->where('qty', '!=', '0');
        })

            ->whereHas('brands', function ($query) use ($brand) {
                $brand ? $query->where('brand_id', 'like', $brand) : $query;
            })

            ->whereHas('categories', function ($query) use ($cat) {
                $cat ? $query->where('category_id', 'like', $cat) : $query;
            })

            ->orWhere('product_type', 'digital')
            ->orWhere('product_type', 'service')
            ->where('status', "active")
            ->where('country_id', setting('country_id'))
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(request()->pagination);

        $top_collection = Product::whereHas('stocks', function ($query) {
            $query->where('warehouse_id', '=', setting('warehouse_id'))
                ->where('qty', '!=', '0');
        })
            ->orWhere('product_type', 'digital')
            ->orWhere('product_type', 'service')
            ->where('top_collection', '1')
            ->where('country_id', setting('country_id'))
            ->where('status', "active")
            ->latest()
            ->get();


        $best_selling = Product::whereHas('stocks', function ($query) {
                $query->where('warehouse_id', '=', setting('warehouse_id'))
                    ->where('qty', '!=', '0');
            })
            ->orWhere('product_type', 'digital')
            ->orWhere('product_type', 'service')
            ->where('country_id', setting('country_id'))
            ->where('status', "active")
            ->where('best_selling', '1')
            ->latest()
            ->get();


        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        $brands = Brand::where('country_id', setting('country_id'))->where('status', 'active')->get();

        return view('ecommerce.products', compact('categories', 'products', 'brands', 'best_selling', 'top_collection'));
    }




    public function store(Request $request)
    {

        $request->validate([
            'variations' => "nullable|string",
            'product_id' => "required|string",
            'qty' => "required|string",
        ]);


        $data = [];

        $product = Product::findOrFail($request->product_id);

        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
            $user_id = $user->id;
            $session_id = null;
        } else {
            $user = null;
            $user_id = null;
            $session_id = $request->session()->token();
        }



        if ($product->product_type == 'variable') {

            $attributes_count = $product->attributes->count();
            $variations = explode(",", $request->variations);
            $selected_attributes_count = count($variations);

            if ($selected_attributes_count < $attributes_count) {
                $data['status'] = 3;
                return $data;
            } elseif ($selected_attributes_count = $attributes_count) {
                $combinations = ProductCombination::where('product_id', $product->id)->get();

                foreach ($combinations as $combination) {
                    $count = $combination->variations->whereIn('variation_id', $variations);
                    $count =  count($count);
                    if ($count == $selected_attributes_count) {
                        $com = $combination;
                    }
                }
            } else {
                $data['status'] = 10;
                return $data;
            }


            $av_qty = productQuantity($product->id, $com->id, setting('warehouse_id'));

            if ($request->qty > $av_qty || $request->qty <= 0) {
                $data['status'] = 2;
                return $data;
            }


            $cart_item = CartItem::where('user_id', $user_id)
                ->where('session_id', $session_id)
                ->where('product_combination_id', $com->id)->first();


            if ($cart_item) {

                $product_qty = $cart_item->qty;
                $cart_item->update([
                    'qty' => $request->qty + $product_qty,
                ]);

                $data['status'] = 1;
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
                $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, $com->id);
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $com->id]);
                return $data;
            }


            CartItem::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'warehouse_id' => setting('warehouse_id'),
                'qty' => $request->qty,
                'product_combination_id' => $com->id,
                'session_id' => $session_id
            ]);

            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
            $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, $com->id);
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $com->id]);
            return $data;
        } elseif ($product->product_type == 'simple') {

            $av_qty = productQuantity($product->id, null, setting('warehouse_id'));



            if ($request->qty > $av_qty || $request->qty <= 0) {
                $data['status'] = 2;
                return $data;
            }


            $cart_item = CartItem::where('user_id', $user_id)
                ->where('session_id', $session_id)
                ->where('product_id', $product->id)->first();



            if ($cart_item) {

                $product_qty = $cart_item->qty;
                $cart_item->update([
                    'qty' => $request->qty + $product_qty,
                ]);

                $data['status'] = 1;
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
                $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, null);
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
                return $data;
            }

            CartItem::create([
                'product_id' => $request->product_id,
                'warehouse_id' => setting('warehouse_id'),
                'qty' => $request->qty,
                'user_id' => $user_id,
                'session_id' => $session_id
            ]);

            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
            $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, null);
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
            return $data;
        } else {


            $cart_item = CartItem::where('user_id', $user_id)
                ->where('session_id', $session_id)
                ->where('product_id', $product->id)->first();


            if ($cart_item) {

                $product_qty = $cart_item->qty;
                $cart_item->update([
                    'qty' => $request->qty + $product_qty,
                ]);

                $data['status'] = 1;
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
                $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, null);
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
                return $data;
            }

            CartItem::create([
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'user_id' => $user_id,
                'session_id' => $session_id
            ]);

            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id]);
            $data['product_image'] = asset($product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $product->images[0]->media->path);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, null);
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
            return $data;
        }
    }




    public function destroy($product)
    {
        $product = Product::findOrFail($product);

        $session_id = request()->session()->token();


        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
            $user_id = $user->id;
            $item = CartItem::where('product_id', $product->id)
                ->where('user_id', $user_id)
                ->where('product_combination_id', request()->combination)
                ->first();
        } else {
            $item = CartItem::where('product_id', $product->id)
                ->where('product_combination_id', request()->combination)
                ->where('session_id', $session_id)
                ->first();
        }

        $item->delete();
        return redirect()->back();
    }



    public function cart(Request $request)
    {

        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        }
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.cart', compact('cart_items', 'categories'));
    }



    public function fav()
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


    public function addFav(Request $request, $product)
    {

        $product = Product::findOrFail($product);

        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
            $user_id = $user->id;
            $session_id = null;
        } else {
            $user = null;
            $user_id = null;
            $session_id = $request->session()->token();
        }


        if (
            FavItem::where('product_id', $product->id)
            ->where('user_id', $user_id)
            ->where('session_id', $session_id)
            ->get()->count() == 0
        ) {


            $fav = FavItem::create([
                'user_id' => $user_id,
                'product_id' => $product->id,
                'session_id' => $session_id
            ]);
            return 1;
        } else {
            $fav = FavItem::where('product_id', $product->id)
                ->where('user_id', $user_id)
                ->where('session_id', $session_id)
                ->first();
            $fav->delete();
            return 2;
        }
    }



    public function changeQuantity(Request $request)
    {

        $product = Product::findOrFail($request->product);

        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
            $user_id = $user->id;
            $session_id = null;
        } else {
            $user = null;
            $user_id = null;
            $session_id = $request->session()->token();
        }


        $cart_item = CartItem::where('user_id', $user_id)
            ->where('session_id', $session_id)
            ->where('product_combination_id', $request->combination)
            ->where('product_id', $request->product)
            ->first();

        $qty = $request->quantity;
        $max = $cart_item->product->product_max_order;
        $min = $cart_item->product->product_min_order;

        if ($request->quantity < $min) {
            $qty = $min;
        }

        if ($request->quantity > $max) {
            $qty = $max;
        }

        $cart_item->update([
            'qty' => $qty
        ]);

        return $qty;
    }







    public function checkout(Request $request)
    {

        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        }

        $countries = Country::all();

        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.checkout', compact('cart_items', 'categories', 'countries'));
    }





    public function shipping(Request $request)
    {

        $request->validate([
            'country_id' => "required|string",
            'state_id' => "required|string",
            'city_id' => "required|string",
        ]);

        $data = [];

        $data['country_id'] = $request->country_id;
        $data['state_id'] = $request->state_id;
        $data['city_id'] = $request->city_id;

        $country = Country::findOrFail($request->country_id);
        $state = State::findOrFail($request->state_id);
        $city = City::findOrFail($request->city_id);

        $cart_items = getCartItems();

        $data['currency'] = getCurrency();
        $data['total'] = getCartSubtotal($cart_items);
        $data['locale'] = app()->getLocale();

        $shipping_method_id = setting('shipping_method');

        // check if local pickup is selected
        if ($shipping_method_id == '2') {
            $data['status'] = 2;
            return $data;
        }

        $free_shipping_count = 0;


        $shipping_amount = 0;

        if ($shipping_method_id == '6') {
            $shipping_amount = $city->shipping_amount;
        } elseif ($shipping_method_id == '5') {
            $shipping_amount = $state->shipping_amount;
        } elseif ($shipping_method_id == '4') {
            $shipping_amount = $country->shipping_amount;
        } elseif ($shipping_method_id == '3') {
            $shipping_amount = 0;
        } elseif ($shipping_method_id == '2') {
            $shipping_amount = 0;
        } elseif ($shipping_method_id == '1') {

            foreach ($cart_items as $item) {
                $shipping_amount += shippingWithWeight($item->product);
            }
        } else {
            $shipping_amount = 0;
        }



        foreach ($cart_items as $item) {

            $shipping_method_id_item = $item->product->shipping_method_id;

            $shipping_amount_item = 0;


            if ($shipping_method_id_item == '3' || $item->product->product_type == 'digital' || $item->product->product_type == 'service') {
                $shipping_amount_item = 0;
                $free_shipping_count += 1;
            } elseif ($shipping_method_id_item == '2') {

                // if product have special shipping method - local pickup
                $data['status'] = 2;
                $data['product_name'] = (app()->getLocale() == 'ar' ? $item->product->name_ar : $item->product->name_en);
                return $data;
            } elseif ($shipping_method_id_item == '1') {
                $shipping_amount_item = shippingWithWeight($item->product);
            } else {
                $shipping_amount_item = 0;
            }

            if ($item->product->shipping_amount != null) {
                $shipping_amount += ($shipping_amount_item + $item->product->shipping_amount);
            }
        }


        // check if all products is digital or service or free shipping
        if ($cart_items->count() == $free_shipping_count) {
            $data['status'] = 1;
            $data['shipping_amount'] = 0;
            return $data;
        }



        $data['status'] = 1;
        $data['shipping_amount'] = $shipping_amount;


        return $data;
    }
}
