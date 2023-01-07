<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\State;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{


    public function orderSuccess(Request $request)
    {

        if (!isset($request->order) || $request->order == null) {
            return redirect()->route('ecommerce.home');
        }

        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        $order  = Order::findOrFail($request->order);


        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } elseif (!Auth::check() && $order->session_id != $request->session()->token()) {
            return redirect()->route('ecommerce.home');
        }

        return view('ecommerce.order-success', compact('order', 'categories'));
    }




    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'country_id' => 'required|string|max:255',
            'state_id' => 'required|string|max:255',
            'city_id' => 'required|string|max:255',
            'password' => "nullable|string|min:8|confirmed",
            'branch_id' => 'nullable|string|max:255',
            'shipping_option' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
        ]);

        $cart_items = getCartItems();

        $count = 0;

        // check quantity available
        foreach ($cart_items as $item) {

            $max = $item->product->product_max_order;
            $min = $item->product->product_min_order;

            if ($item->product->product_type == 'simple') {
                $av_qty = productQuantity($item->product->id, null, setting('warehouse_id'));
                if ($item->qty > $av_qty || $item->qty <= 0 || $item->qty < $min || $item->qty > $max) {
                    $count = $count + 1;
                }
            } elseif ($item->product->product_type == 'variable') {
                $av_qty = productQuantity($item->product->id, $item->combination->id, setting('warehouse_id'));
                if ($item->qty > $av_qty || $item->qty <= 0 || $item->qty < $min || $item->qty > $max) {
                    $count = $count + 1;
                }
            } else {
                if ($item->qty <= 0 || $item->qty < $min || $item->qty > $max) {
                    $count = $count + 1;
                }
            }
        }

        if ($count > 0) {
            alertError('Some products do not have enough quantity in stock or the ordered quantity does not match the appropriate order limit', 'بعض المنتجات ليس بها كمية كافية في المخزون او الكمية المطلوبة غير متطابقة مع الحد المناسب للطلب');
            return redirect()->back();
        }

        // check if cart empty
        if ($cart_items->count() <= 0) {
            alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            return redirect()->back();
        }


        if ($request->payment_method == 'cash') {
            $order = $this->attach_order($request, 'cash_on_delivery');
            alertSuccess('Order added successfully', 'تم عمل الطلب بنجاح');
            return redirect()->route('ecommerce.order.success', ['order' => $order]);
        }

        if ($request->payment_method == 'card') {
            $order = $this->attach_order($request, 'card');
            return redirect()->route('ecommerce.payment', ['orderId' => $order->id]);
        }
    }

    private function attach_order($request, $payment_method)
    {

        $shipping_amount = 0;
        $cart_items = getCartItems();

        if ($request->shipping_option == '2') {
            $shipping_method_id = 2;
            $shipping_amount = 0;
            $branch_id = $request->branch_id;
        } else {
            $shipping_method_id = setting('shipping_method');
            $shipping_amount = $this->calculateShipping($request);
            $branch_id = null;
        }


        $order = Order::create([

            'affiliate_id' => null,
            'customer_id' => Auth::check() ? Auth::id() : null,
            'session_id' => Auth::check() ? null : $request->session()->token(),
            'warehouse_id' => setting('warehouse_id'),
            'order_from' => 'web',
            'full_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'notes' => $request->notes,
            'house' => null,
            'special_mark' => null,

            'branch_id' => $branch_id,

            'total_price' => getCartSubtotal($cart_items) + $shipping_amount,
            'subtotal_price' => getCartSubtotal($cart_items),
            'shipping_amount' => $shipping_amount,
            'shipping_method_id' => $shipping_method_id,

            'total_price_affiliate' => null,
            'total_commission' => null,
            'total_profit' => null,

            'status' => 'pending',
            'payment_method' => $payment_method,

            'transaction_id' => null,
            'total_tax' => null,
            'is_seen' => '0',

            'coupon_code' => null,
            'coupon_amount' => null,

        ]);






        foreach ($cart_items as $item) {

            $order->products()->attach(
                $item->product->id,
                [
                    'warehouse_id' => setting('warehouse_id'),
                    'product_combination_id' => $item->product_combination_id,
                    'product_price' => productPrice($item->product, $item->product_combination_id),
                    'product_tax' => null,
                    'product_discount' => null,
                    'qty' => $item->qty,
                    'total' => (productPrice($item->product, $item->product_combination_id) * $item->qty),
                    'product_type' => $item->product->product_type,

                    'affiliate_price' => null,
                    'total_affiliate_price' => null,
                    'commission_per_item' => null,
                    'profit_per_item' => null,
                    'total_commission' => null,
                    'total_profit' => null,

                    'extra_shipping_amount' => $this->calculateShippingForItem($item),
                    'shipping_method_id' => $item->product->shipping_method_id,

                ]
            );

            if ($item->product->vendor->hasRole('vendor')) {



                $vendor_order = $item->product->vendor->vendor_orders()->create([
                    'total_price' => (productPrice($item->product, $item->product_combination_id) * $item->qty),
                    'order_id' => $order->id,
                    'country_id' => $request->country_id,
                    'user_id' => $item->product->vendor->id,
                    'user_name' => $item->product->vendor->name,
                ]);
                $vendor_order->products()->attach(
                    $item->product->id,
                    [
                        'warehouse_id' => setting('warehouse_id'),
                        'product_combination_id' => $item->product_combination_id,
                        'qty' => $item->qty,
                        'vendor_price' => productPrice($item->product, $item->product_combination_id),
                        'total_vendor_price' => (productPrice($item->product, $item->product_combination_id) * $item->qty),
                        'product_type' => $item->product->product_type,
                    ]
                );
                // changeOutStandingBalance($product->vendor, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'add');
            }
        }

        foreach ($cart_items as $item) {



            // add stock update

            if ($item->product->product_type == 'variable' || $item->product->product_type == 'simple') {

                Stock::create([
                    'product_combination_id' => $item->product_combination_id,
                    'product_id' => $item->product->id,
                    'warehouse_id' => setting('warehouse_id'),
                    'qty' => $item->qty,
                    'stock_status' => 'OUT',
                    'stock_type' => 'Order',
                    'reference_id' => $order->id,
                    'reference_price' => productPrice($item->product, $item->product_combination_id),
                    'created_by' => Auth::check() ? Auth::id() : null,
                ]);
            }

            $item->delete();


            // add noty for stock limit
            if ($item->product->product_type == 'variable') {
                if (productQuantity($item->product->id, $item->combination->id, setting('warehouse_id')) <= $item->combination->limit) {
                    array_push($stocks_limit_products, $item->product);
                }
            } elseif ($item->product->product_type == 'simple') {
                if (productQuantity($item->product->id, null, setting('warehouse_id')) <= $item->product->limit) {
                    array_push($stocks_limit, $item->product);
                }
            }
        }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '==', 'superadministrator')
                ->where('name', '==', 'administrator');
        })->get();

        // send noti to admins about new order and stock limit
        foreach ($users as $admin) {
            $title_ar = 'يوجد طلب جديد';
            $body_ar = 'تم اضافة طلب جديد';
            $title_en = 'There is a new order';
            $body_en  = 'A new order has been added';
            $url = route('orders.index');

            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = null;
            }

            // update user noty for not registered users
            addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);

            foreach ($stocks_limit_products as $product) {
                $title_ar = 'تنبيه بنقص المخزون';
                $body_ar = 'تجاوز هذا المنتج الحد المسموح في المخزون :#' . $product->name_ar;
                $title_en = 'stock limit alert';
                $body_en  = 'this product over the stock limit :#' . $product->name_en;
                $url = route('stock.management.index', ['search' => $product->id]);
                addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }

        return $order;
    }

    private function calculateShipping($request)
    {

        $country = Country::findOrFail($request->country_id);
        $state = State::findOrFail($request->state_id);
        $city = City::findOrFail($request->city_id);

        $cart_items = getCartItems();

        $shipping_method_id = setting('shipping_method');

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
            return 0;
        }

        return $shipping_amount;
    }

    private function calculateShippingForItem($item)
    {

        $shipping_amount = 0;

        $shipping_method_id_item = $item->product->shipping_method_id;

        $shipping_amount_item = 0;

        if ($shipping_method_id_item == '3' || $item->product->product_type == 'digital' || $item->product->product_type == 'service') {
            $shipping_amount_item = 0;
        } elseif ($shipping_method_id_item == '1') {
            $shipping_amount_item = shippingWithWeight($item->product);
        } else {
            $shipping_amount_item = 0;
        }

        if ($item->product->shipping_amount != null) {
            $shipping_amount += ($shipping_amount_item + $item->product->shipping_amount);
        }

        return $shipping_amount;
    }

    public function getStates(Request $request)
    {

        $request->validate([
            'country_id' => "required|string",
        ]);


        $data = [];

        $country = Country::findOrFail($request->country_id);

        $states  = $country->states;

        $data['status'] = 1;

        $data['locale'] = app()->getLocale();

        $data['states'] = $states;

        return $data;
    }



    public function getCities(Request $request)
    {

        $request->validate([
            'state_id' => "required|string",
        ]);


        $data = [];

        $state = State::findOrFail($request->state_id);

        $cities  = $state->cities;

        $data['status'] = 1;

        $data['locale'] = app()->getLocale();

        $data['cities'] = $cities;

        return $data;
    }
}
