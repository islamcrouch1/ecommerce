<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Order;
use App\Models\ShippingRate;
use App\Models\Stock;
use App\Models\StoreProduct;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($user, Request $request)
    {

        if (!$request->has('pagination')) {
            $request->merge(['pagination' => 24]);
        }

        $user = User::findOrFail($user);
        if ($user == null) {
            return redirect()->route('home.front', app()->getLocale());
        }

        $products = StoreProduct::where('user_id', $user->id)
            ->whereHas('product', function ($query) use ($request) {
                $query->where('name_ar', 'like', "%$request->search%")
                    ->orWhere('name_en', 'like', "%$request->search%")
                    ->orWhere('description_ar', 'like', "%$request->search%")
                    ->orWhere('description_en', 'like', "%$request->search%")
                    ->orWhere('sku', 'like', "%$request->search%");
            })
            ->latest()
            ->paginate(request()->pagination);



        // $products = Aproduct::latest()
        // ->join('products', 'products.id', '=', 'aproducts.product_id')
        // ->paginate(request()->pagination);

        return view('store.index')->with('products', $products)->with('user', $user);
    }

    public function product($user, $product, Request $request)
    {

        if ($request->has('search')) {
            return redirect()->route('store.show', ['user' => $user, 'search' => $request->search]);
        }

        $user = User::findOrFail($user);

        if ($user == null) {
            return redirect()->route('home.front', app()->getLocale());
        }


        $product = StoreProduct::findOrFail($product);


        if ($product == null || $product->user_id != $user->id) {

            return redirect()->route('store.show', ['user' => $user->id]);
        }

        return view('store.product')->with('product', $product)->with('user', $user);
    }

    public function store($user, $product, Request $request)
    {


        $user = User::findOrFail($user);

        if ($user == null) {
            return redirect()->route('front.index');
        }


        $aproduct = StoreProduct::findOrFail($product);


        if ($aproduct == null || $aproduct->user_id != $user->id) {

            return redirect()->route('store.show', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'shipping' => 'required|string',
            'phone1' => 'required|string',
            'notes' => 'nullable|string',
            'house' => 'nullable|string',
            'phone2' => 'nullable|string',
            'special_mark' => 'nullable|string',
            'quantity_order' => 'required|string',
            'stock_id' => 'required|string',
        ]);



        if ($aproduct->product_type == 0) {

            if ($request->quantity_order > intval(Stock::find($request->stock_id)->quantity) || $request->quantity_order <= 0) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('error', 'الكمية المطلوبة غير متوفرة في المخزون');
                } else {

                    session()->flash('error', 'The required quantity is not in stock');
                }


                return redirect()->route('store.product', ['user' => $user->id, 'product' => $aproduct->id]);
            }
        } else {
            // if product from vendor stock not from sonoo stock
        }


        if ($aproduct->product_price != $aproduct->product->price) {


            if (app()->getLocale() == 'ar') {

                session()->flash('error', 'هناك تحديث على سعر المنتج المطلوب يرجى المحاولة في عمل الطلب لاحقا');
            } else {

                session()->flash('error', 'There is an update on the price of the requested product, please try to make the order later');
            }


            return redirect()->route('store.product', ['user' => $user->id, 'product' => $aproduct->id]);
        }


        $order = $this->attach_order($request, $user, $aproduct);


        if (app()->getLocale() == 'ar') {

            session()->flash('success', 'تم عمل الطلب بنجاح');
        } else {

            session()->flash('success', 'Order added successfully');
        }


        $shipping = ShippingRate::findOrFail($request->shipping)->cost;


        return redirect()->route('store.success', ['user' => $user->id, 'product' => $aproduct->id, 'order' => $order->id, 'quantity' => $request->quantity_order, 'shipping' => $shipping]);
    }

    private function attach_order($request, $user, $aproduct)
    {

        $shipping = ShippingRate::findOrFail($request->shipping)->cost;

        $order = $user->orders()->create([
            'total_price' => 0,
            'total_commission' => 0,
            'total_profit' => 0,
            'address' => $request->address,
            'house' => $request->house,
            'special_mark' => $request->special_mark,
            'client_name' => $request->name,
            'client_phone' => $request->phone1,
            'phone2' => $request->phone2,
            'notes' => $request->notes,
            'country_id' => $user->country->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'shipping_rate_id' => $request->shipping,
            'shipping' => $shipping,
        ]);


        if ($aproduct->product_type == '0') {
            $av_stock = Stock::find($request->stock_id);
        }


        $order->products()->attach(
            $aproduct->product->id,
            [
                'stock_id' => $request->stock_id,
                'quantity' => $request->quantity_order,
                'selling_price' => $aproduct->store_price,
                'vendor_price' => $aproduct->product->vendor_price,
                'commission_per_item' => $aproduct->store_price - $aproduct->product_price,
                'profit_per_item' => $aproduct->product_price - $aproduct->product->vendor_price,
                'total_selling_price' => ($aproduct->store_price * $request->quantity_order),
                'total_commission' => ($aproduct->store_price - $aproduct->product_price) * $request->quantity_order,
                'product_type' => $aproduct->product_type,
                'size_ar' => $av_stock->size->size_ar,
                'size_en' => $av_stock->size->size_en,
                'color_en' => $av_stock->color->color_en,
                'color_ar' => $av_stock->color->color_ar
            ]
        );



        $vendor_order = $aproduct->product->vendor->vendor_orders()->create([
            'total_price' => ($aproduct->product->vendor_price * $request->quantity_order),
            'order_id' => $order->id,
            'country_id' => $user->country->id,
            'user_id' => $aproduct->product->vendor->id,
            'user_name' => $aproduct->product->vendor->name,
        ]);


        $vendor_order->products()->attach(
            $aproduct->product->id,
            [
                'stock_id' => $request->stock_id,
                'quantity' => $request->quantity_order,
                'vendor_price' => $aproduct->product->vendor_price,
                'total_vendor_price' => ($aproduct->product->vendor_price * $request->quantity_order),
                'product_type' => $aproduct->product_type,
                'size_ar' => $av_stock->size->size_ar,
                'size_en' => $av_stock->size->size_en,
                'color_en' => $av_stock->color->color_en,
                'color_ar' => $av_stock->color->color_ar
            ]
        );


        changeOutStandingBalance($aproduct->product->vendor, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'add');


        $total_price = 0;
        $total_commission = 0;
        $total_profit = 0;
        $stocks_limit = [];



        $total_price = ($aproduct->store_price * $request->quantity_order);
        $total_commission = ($aproduct->store_price - $aproduct->product_price) * $request->quantity_order;
        $total_profit = ($aproduct->product_price - $aproduct->product->vendor_price) * $request->quantity_order;

        $product_stock = $aproduct->product->stocks->find($request->stock_id);

        if ($aproduct->product_type == '0') {

            $product_stock->update([
                'quantity' => $product_stock->quantity - $request->quantity_order
            ]);
        } else {

            // $product->astocks->find($product->pivot->stock_id)->update([
            //     'stock' => $product->astocks->find($product->pivot->stock_id)->stock - $product->pivot->stock
            // ]);
        }

        if ($product_stock->quantity < $product_stock->limit) {
            array_push($stocks_limit, $product_stock->id);
        }

        $order->update([
            'total_price' => $total_price,
            'total_commission' => $total_commission,
            'total_profit' => $total_profit,
        ]);

        changeOutStandingBalance($user, $order->total_commission, $order->id, $order->status, 'add');

        // $mystock_price = 0;



        // foreach ($user->cart->products as $product) {
        //     if ($product->pivot->product_type != '0') {
        //         $mystock_price += ($product->min_price * $product->pivot->stock);
        //     }
        // }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();

        foreach ($users as $admin) {
            $title_ar = 'يوجد طلب جديد';
            $body_ar = 'تم اضافة طلب جديد من  : ' . $user->name;
            $title_en = 'There is a new order';
            $body_en  = 'A new order has been added from : ' . $user->name;
            $url = route('orders.index');
            addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);

            foreach ($stocks_limit as $stock) {
                $stock = Stock::find($stock);
                $title_ar = 'تنبيه بنقص المخزون';
                $body_ar = 'تجاوز هذا المنتج الحد المسموح في المخزون :#' . $stock->product->id;
                $title_en = 'stock limit alert';
                $body_en  = 'this product over the stock limit :#' . $stock->product->id;
                $url = route('stock.management.index', ['search' => $aproduct->product->id]);
                addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }


        return $order;
    } //end of attach order

    public function success(Request $request)
    {
        $user = User::find($request->user);
        $product = StoreProduct::find($request->product);
        $order = Order::find($request->order);
        return view('store.success')->with('product', $product)->with('user', $user)->with('order', $order)->with('quantity', $request->quantity)->with('shipping', $request->shipping);
    }
}
