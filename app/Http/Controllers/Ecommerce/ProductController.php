<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\FavItem;
use App\Models\InstallmentCompany;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Review;
use App\Models\ShippingRate;
use App\Models\State;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;
use Carbon\Carbon;


class ProductController extends Controller
{
    public function product(Product $product, $slug)
    {

        $cat = $product->category->id;
        $warehouses = getWebsiteWarehouses();
        $country = getCountry();

        $products = Product::whereHas('stocks', function ($query) use ($warehouses) {
            $query->whereIn('warehouse_id', $warehouses);
        })
            ->orWhereIn('product_type', ['digital', 'service'])
            ->orWhereNotNull('vendor_id')

            ->whenCategory($cat)
            ->where('status', "active")
            ->where('country_id', $country->id)

            ->inRandomOrder()
            ->limit(6)
            ->get();




        // $products = Product::whereHas('stocks', function ($query) use ($warehouses) {
        //     $query->whereIn('warehouse_id', $warehouses)
        //         ->where('qty', '!=', '0');
        // })->orWhereNotNull('vendor_id')

        //     ->whereHas('categories', function ($query) use ($cat) {
        //         $cat ? $query->where('category_id', 'like', $cat) : $query;
        //     })

        //     ->orWhere('product_type', 'digital')
        //     ->orWhere('product_type', 'service')
        //     ->where('status', "active")
        //     ->where('country_id', setting('country_id'))
        //     ->inRandomOrder()->limit(6)->get();

        addViewRecord();

        $countries = Country::all();


        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.product', compact('product', 'categories', 'products', 'countries'));
    }


    public function search(Request $request)
    {

        $search = $request->search;

        $products = Product::where('status', "active")
            ->where('country_id', setting('country_id'))
            ->whenSearch($search)
            ->get();


        foreach ($products as $product) {
            $product->url = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
            $product->image = getProductImage($product);
        }

        $data = [];
        $data['status'] = 1;
        $data['elements'] = $products;

        addViewRecord();


        return $data;
    }

    public function products(Request $request)
    {


        // dd($request->all());

        if (!$request->has('pagination')) {
            $request->merge(['pagination' => 24]);
        }

        if (!$request->has('category')) {
            $cats = [];
        } elseif ($request->category == null) {
            $cats = [];
        } else {


            $category = Category::findOrFail($request->category);
            $cats = flatten($category->childrenRecursive()->get()->pluck('id')->toArray());

            if (!empty($cats)) {
                $cats = $cats[0];
            } else {
                $cats = [];
            }
            array_push($cats, $category->id);
        }

        if (!$request->has('brands')) {
            $request->merge(['brands' => []]);
        }

        if (!$request->has('variations')) {
            $request->merge(['variations' => []]);
        }


        if (!$request->has('sorting')) {
            $request->merge(['sorting' => []]);
        }

        if (!$request->has('price')) {
            $request->merge(['price' => '']);
        }


        if (!$request->has('range')) {
            $min_price = 0;
            $max_price = 999999;
        } else {
            $rang = explode(';', $request->range);
            $min_price = $rang[0];
            $max_price = $rang[1];
        }

        // dd($min_price, $max_price);

        $country = getCountry();
        $warehouses = getWebsiteWarehouses();




        $products = Product::where('status', "active")
            ->where('country_id', $country->id)
            ->where('sale_price', '>', $min_price)
            ->where('sale_price',  '<', $max_price)


            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })



            // ->WhenCategory(request()->category)
            ->WhenCategories($cats)
            ->WhenVariations(request()->variations)
            ->WhenBrand(request()->brands)
            ->whenSearch(request()->search)
            ->whenSorting(request()->sorting)
            ->whenPrice(request()->price)
            ->latest()
            ->paginate(request()->pagination);


        $color_text = ['color', 'colors', 'Color', 'Colors', 'الوان', 'لون', 'الالوان', 'الألوان'];

        $color_attribute = Attribute::whereIn('name_en', $color_text)->first();

        $attributes = Attribute::where('activate_filter', '1')->get();

        addViewRecord();


        return view('ecommerce.products', compact('color_attribute', 'products', 'attributes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'variations' => "nullable|string",
            'product_id' => "required|string",
            'qty' => "required|string",
            'from' => "nullable|string",
            'to' => "nullable|string",
            'can_rent' => "nullable|string",
        ]);


        addViewRecord();


        $warehouses = getWebsiteWarehouses();

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
            if ($request->variations == null) {
                $variations = [];
            } else {
                $variations = explode(",", $request->variations);
            }
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


            if ($product->vendor_id == null) {
                $av_qty = productQuantityWebsite($product->id, $com->id, null, $warehouses);
            } else {

                $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
                $av_qty = productQuantity($product->id, $com->id, $warehouse->id);
            }


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
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
                $data['product_image'] = getProductImage($product);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, $com->id, 'vat');
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $com->id]);
                return $data;
            }


            addToCart($request->product_id, $request->qty, $user_id, $com->id, $session_id);




            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
            $data['product_image'] = getProductImage($product);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, $com->id, 'vat');
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $com->id]);
            return $data;
        } elseif ($product->product_type == 'simple') {



            if ($product->vendor_id == null) {
                $av_qty = productQuantityWebsite($product->id, null, null, $warehouses);
            } else {
                $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
                $av_qty = productQuantity($product->id, null, $warehouse->id);
            }

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
                    'qty' => $request->can_rent != null ?  $request->qty : ($request->qty + $product_qty),
                    'start_date' => $request->from,
                    'days' => $request->to != null ? $request->to : 1,
                    'end_date' => $request->can_rent != null ?  (Carbon::parse($request->from)->addHours($request->to * 12)->toDateTimeString()) : null,
                ]);

                $data['status'] = 1;
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
                $data['product_image'] = getProductImage($product);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, null, 'vat');
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $product->combinations[0]->id]);
                return $data;
            }

            foreach ($product->combinations as $com) {

                addToCart($request->product_id, $request->qty, $user_id, $com->id, $session_id, $request->from, $request->to);
            }



            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
            $data['product_image'] = getProductImage($product);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, null, 'vat');
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => $com->id]);
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
                $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
                $data['product_image'] = getProductImage($product);
                $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
                $data['product_price'] = productPrice($product, null, 'vat');
                $data['qty'] = $request->qty;
                $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
                return $data;
            }

            addToCart($request->product_id, $request->qty, $user_id, null, $session_id);

            $data['status'] = 1;
            $data['product_url'] = route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
            $data['product_image'] = getProductImage($product);
            $data['product_name'] = app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en;
            $data['product_price'] = productPrice($product, null, 'vat');
            $data['qty'] = $request->qty;
            $data['destroy'] = route('ecommerce.cart.destroy', ['product' => $product->id, 'combination' => null]);
            return $data;
        }
    }

    public function calcRentData(Request $request)
    {

        $request->validate([
            'product_id' => "required|string",
            'qty' => "required|string",
            'from' => "nullable|string",
            'to' => "nullable|numeric",
        ]);


        $start = Carbon::parse($request->from);
        $days = $request->to;

        $product = Product::findOrFail($request->product_id);


        if ($days <= 0) {
            $days = 1;
        }

        $data = [];

        // Check if date 1 is before date 2
        // if ($start->isAfter($end)) {
        //     $data['status'] = 1;
        //     $data['start'] = $request->from;
        //     $data['end'] = $request->from;
        //     return $data;
        // }

        // for ($i=0; $i < $days ; $i++) {
        //     # code...
        // }

        // $diffInDays = $start->diffInDays($end);

        $diffInDays = $days;

        $data['end'] = $start->addHours($days * 12)->toDateTimeString();
        $data['days'] = $diffInDays;
        $data['vat'] = ((productPrice($product, null, 'vat') - productPrice($product)) * $diffInDays * $request->qty) . getDefaultCurrency()->symbol;
        $data['total'] = (productPrice($product, null, 'vat') * $diffInDays * $request->qty) . getDefaultCurrency()->symbol;

        return $data;
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

        if ($item != null) {
            $item->delete();
        }

        return redirect()->back()->withInput();
    }


    public function cart(Request $request)
    {



        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        }
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();

        addViewRecord();


        return view('ecommerce.cart', compact('cart_items', 'categories'));
    }


    public function wishlist(Request $request)
    {
        addViewRecord();

        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.fav', compact('categories'));
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

            if (setting('snapchat_pixel_id') && setting('snapchat_token')) {
                snapchatEvent('ADD_TO_WISHLIST');
            }

            if (setting('facebook_id') && setting('facebook_token')) {
                facebookEvent('AddToWishlist');
            }

            if (setting('tiktok_id') && setting('tiktok_token')) {
                tiktokEvent('AddToWishlist', $product->id, 1);
            }

            if (url()->previous() == route('ecommerce.wishlist') || url()->previous() == route('ecommerce.account')) {
                return redirect()->back()->withInput();
            }

            return 1;
        } else {
            $fav = FavItem::where('product_id', $product->id)
                ->where('user_id', $user_id)
                ->where('session_id', $session_id)
                ->first();
            $fav->delete();

            if (url()->previous() == route('ecommerce.wishlist') || url()->previous() == route('ecommerce.account')) {
                return redirect()->back()->withInput();
            }

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

        $data = [];

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


        $data['product_price'] = round(productPrice($product, $request->combination, 'vat'), 2) * $cart_item->days;
        $data['qty'] = $qty;


        $cart_item->update([
            'qty' => $qty
        ]);


        $cart_items = getCartItems();
        $data['total'] = getCartSubtotal($cart_items);

        $discount = calcDiscount($cart_items);
        $data['total'] = round($data['total'] - $discount, 3);
        $data['discount'] = round($discount, 3);


        return $data;
    }


    public function checkout(Request $request)
    {

        if (setting('snapchat_pixel_id') && setting('snapchat_token')) {
            snapchatEvent('START_CHECKOUT');
        }

        if (setting('facebook_id') && setting('facebook_token')) {
            facebookEvent('InitiateCheckout');
        }



        if (Auth::check()) {
            $cart_items = CartItem::where('user_id', Auth::id())->get();
        } else {
            $cart_items = CartItem::where('session_id', $request->session()->token())->get();
        }

        if (setting('tiktok_id') && setting('tiktok_token')) {
            tiktokEvent('InitiateCheckout', null, null, null, null, $cart_items);
        }

        $countries = Country::all();

        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        addViewRecord();

        return view('ecommerce.checkout', compact('cart_items', 'categories', 'countries'));
    }

    public function shipping(Request $request)
    {

        $request->validate([
            'country_id' => "required|string",
            'state_id' => "required|string",
            'city_id' => "required|string",
            'coupon' => "nullable|string",
        ]);

        $data = [];
        $data['discount'] = 0;

        $data['country_id'] = $request->country_id;
        $data['state_id'] = $request->state_id;
        $data['city_id'] = $request->city_id;



        $country = Country::findOrFail($request->country_id);
        $state = State::findOrFail($request->state_id);
        $city = City::findOrFail($request->city_id);

        $cart_items = getCartItems();



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
        $data['shipping_amount'] = round($shipping_amount, 2);


        $data['currency'] = getCurrency();
        // $data['total'] = round(getCartSubtotal($cart_items), 2);
        $data['total'] = round(getCartSubtotalWithOutTax($cart_items), 2);

        $data['locale'] = app()->getLocale();




        if (isset($request->coupon)) {


            $coupon = Coupon::where('code', $request->coupon)->first();

            if (!isset($coupon)) {
                $data['coupon_status'] = 0;
                return $data;
            }

            if (Auth::check()) {
                $orders = Order::where('customer_id', Auth::id())->where('coupon_code', $coupon->code)->get();
            } else {
                $orders = Order::where('session_id', request()->session()->token())->where('coupon_code', $coupon->code)->get();
            }

            if ($orders->count() >= $coupon->user_frequency) {
                $data['coupon_status'] = 13;
                return $data;
            }


            $orders = Order::where('coupon_code', $coupon->code)->get();

            if ($orders->count() >= $coupon->all_frequency) {
                $data['coupon_status'] = 13;
                return $data;
            }


            $date = Carbon::now();

            if ($date > $coupon->ended_at) {
                $data['coupon_status'] = 14;
                return $data;
            }


            if ($coupon->free_shipping == true) {
                $data['coupon_status'] = 1;
                $data['shipping_amount'] = 0;
                return $data;
            }

            $discount = calcDiscount($cart_items, $coupon, $data['total']);
            $data['coupon_status'] = 1;
            // $data['total'] = round($data['total'] - $discount, 2);
            $data['discount'] = round($discount, 2);
        } else {
            $discount = round(calcDiscount($cart_items), 2);
            // $data['total'] = round($data['total'], 2) - $discount;
            $data['discount'] = $discount;
        }


        $data['total'] = round($data['total'] + (calcTax(($data['total'] - $discount), 'vat')) - $discount, 2);



        return $data;
    }


    public function storeReview(Request $request, $product)
    {

        $request->validate([
            'rating' => "required|numeric",
            'phone' => "required|numeric",
            'review' => "required|string|max:255",
        ]);


        if (Auth::check()) {
            $user = Auth::id();
            $session = null;
        } else {
            $user = null;
            $session = $request->session()->token();
        }

        $product = Product::findOrFail($product);


        if (Review::where('product_id', $product->id)->where('user_id', $user)->where('session_id', $session)->get()->count() == 0) {
            $review = Review::create([
                'user_id' => $user,
                'product_id' => $product->id,
                'rating' => $request->rating,
                'review' => $request->review,
                'phone' => $request->phone,
                'session_id' => $session,
            ]);
            alertSuccess('Your review added successfully', 'تم اضافة تقييمك بنجاح');
        } else {
            alertError('Sorry, you already reviewd this product', 'ناسف , لقد قمت بتقييم هذا المنتج سابقا');
        }

        return redirect()->route('ecommerce.product', ['product' => $product->id, 'slug' => createSlug(getName($product))]);
    }


    public function storeOrderReview(Request $request, $order)
    {



        $request->validate([
            'rating' => "required|array",
            'review' => "required|string|max:255",
        ]);


        if (Auth::check()) {
            $user = Auth::user();
            $session = null;
        } else {
            $user = null;
            $session = $request->session()->token();
        }


        foreach ($request->rating as $index => $rating) {

            $product = Product::findOrFail($index);

            if (Review::where('product_id', $product->id)->where('user_id', $user->id)->where('session_id', $session)->get()->count() == 0) {
                $review = Review::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => $rating,
                    'review' => $request->review,
                    'phone' => $user->phone,
                    'session_id' => $session,
                ]);
                alertSuccess('Your review added successfully', 'تم اضافة تقييمك بنجاح');
            } else {
                alertError('Sorry, you already reviewd this product', 'ناسف , لقد قمت بتقييم هذا المنتج سابقا');
            }
        }

        return redirect()->route('ecommerce.account');
    }

    public function download($order = null)
    {
        addViewRecord();
        if (Auth::check()) {
            if (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('superadministrator')) {
                return Storage::download(request()->product_file);
            } elseif ($order != null && $order->customer_id == Auth::id()) {
                return Storage::download(request()->product_file);
            } else {
                alertError('Requested file does not exist on our server!', 'الملف المطلوب غير موجود على السيرفر');
                return redirect()->route('ecommerce.home');
            }
        } elseif ($order != null && $order->session_id == request()->session()->token()) {
            return Storage::download(request()->product_file);
        } else {
            alertError('Requested file does not exist on our server!', 'الملف المطلوب غير موجود على السيرفر');
            return redirect()->route('ecommerce.home');
        }
    }

    public function companyMonths(Request $request)
    {

        $request->validate([
            'company_id' => "required|string",
        ]);


        $data = [];

        $company = InstallmentCompany::findOrFail($request->company_id);

        if (is_array(unserialize($company->months))) {
            $months  = unserialize($company->months);
        } else {
            $months  = [];
        }

        $data['status'] = 1;

        $data['locale'] = app()->getLocale();

        $data['months'] = $months;

        return $data;
    }



    public function getProductPrice(Request $request)
    {




        $request->validate([
            'product_id' => "required|string",
            'variations' => "nullable|array",
        ]);





        $product = Product::findOrFail($request->product_id);
        $attributes_count = $product->attributes->count();



        if (isset($request->variations)) {
            $variations = $request->variations;
            $selected_attributes_count = count($variations);
        } else {
            $variations = [];
            $selected_attributes_count = count($variations);
        }

        $data = [];



        if ($product->product_type == 'variable') {
            if ($selected_attributes_count < $attributes_count) {

                $data['price'] = productPrice($product, null, 'vat');
            } elseif ($selected_attributes_count = $attributes_count) {
                $combinations = ProductCombination::where('product_id', $product->id)->get();


                foreach ($combinations as $combination) {
                    $count = $combination->variations->whereIn('variation_id', $variations);
                    $count =  count($count);
                    if ($count == $selected_attributes_count) {

                        $product = $combination->product;
                        $data['combination'] =  $combination->id;
                        $data['price'] = productPrice($product, $combination->id, 'vat');
                    }
                }
            } else {
                $data['price'] = productPrice($product, null, 'vat');
            }
        } else {
            $data['price'] = productPrice($product, null, 'vat');
        }


        return $data;
    }




    public function getInstallmentData(Request $request)
    {


        $request->validate([
            'company_id' => "required|string",
            'price' => "required|numeric",
        ]);


        $data = [];

        $company = InstallmentCompany::findOrFail($request->company_id);


        $data['status'] = 1;


        if ($company->type == 'amount') {
            $data['admin_expenses'] = $company->admin_expenses;
        } else {
            $data['admin_expenses'] = ($request->price * $company->admin_expenses) / 100;
        }


        if (isset($request->months)) {
            $price = $request->price - $request->advanced_amount;

            $percentage = $request->amount * $request->months;
            $installment = ($percentage * $price) / 100;

            $total = $installment + $price;
            $month = $total / $request->months;

            $data['installment_month'] = round($month, 2);
        } else {
            $data['installment_month'] = 0;
        }



        return $data;
    }
}
