<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\State;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
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
            'create_account' => 'nullable|string|max:255',
            'coupon' => 'nullable|string',
        ]);


        if (isset($request->create_account) && $request->create_account == 'create_account') {

            $request->merge(['country' => $request->country_id]);
            $request->merge(['email' => ($request->phone . '@domain.com')]);
            $request->merge(['check' => 'on']);

            $user_cr = new UserController();

            $user_cr->store($request);
        }


        $warehouses = getWebsiteWarehouses();
        $branch_id = setting('website_branch');

        // accounts check & tax check
        if (settingAccount('customers_account', $branch_id) == null || settingAccount('vat_sales_account', $branch_id) == null || settingAccount('revenue_account', $branch_id) == null || settingAccount('vendors_tax_account', $branch_id) == null || setting('vat') == null || setting('vendors_tax') == null || setting('website_branch') == null) {
            alertError('An error occurred while processing the request, please try again later', 'حدث خطا اثناء عمل الطلب يرجى المحاولة لاحقا');
            return redirect()->back();
        }

        $cart_items = getCartItems();


        $count = 0;
        $count_product = 0;

        // check quantity available
        foreach ($cart_items as $item) {

            $max = $item->product->product_max_order;
            $min = $item->product->product_min_order;

            if ($item->product->product_type == 'simple' || $item->product->product_type == 'variable') {

                if ($item->product->vendor_id == null) {
                    $av_qty = productQuantityWebsite($item->product->id, $item->combination->id, null, $warehouses);
                } else {
                    $warehouse_vendor = Warehouse::where('vendor_id', $item->product->vendor_id)->first();
                    $av_qty = productQuantity($item->product->id, null, $warehouse_vendor->id);
                }


                if ($item->qty > $av_qty || $item->qty <= 0 || $item->qty < $min || $item->qty > $max) {
                    $count = $count + 1;
                }
            } else {
                if ($item->qty <= 0 || $item->qty < $min || $item->qty > $max) {
                    $count = $count + 1;
                }
            }

            if ($item->product->status != 'active') {
                $count_product = $count_product + 1;
            }
        }


        if ($count > 0) {
            alertError('Some products do not have enough quantity in stock or the ordered quantity does not match the appropriate order limit', 'بعض المنتجات ليس بها كمية كافية في المخزون او الكمية المطلوبة غير متطابقة مع الحد المناسب للطلب');
            return redirect()->back();
        }

        if ($count_product > 0) {
            alertError('Some products not available please remove it from your cart', 'بعض المنتجات غير متاحة للطلب في الوقت الحالي يرجى حذفها من سلة المشتريات');
            return redirect()->back();
        }

        // check if cart empty
        if ($cart_items->count() <= 0) {
            alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            return redirect()->back();
        }



        $check_coupon = 0;

        if (isset($request->coupon)) {
            $coupon = Coupon::where('code', $request->coupon)->first();
            if (!isset($coupon)) {
                $check_coupon = 1;
            } else {
                if (!Auth::check()) {
                    $check_coupon = 1;
                } else {
                    $orders = Order::where('customer_id', Auth::id())->where('coupon_code', $coupon->code)->get();
                    if ($orders->count() >= $coupon->frequency) {
                        $check_coupon = 1;
                    } else {
                        $date = Carbon::now();
                        if ($date > $coupon->ended_at) {
                            $check_coupon = 1;
                        }
                    }
                }
            }
        }



        if ($request->payment_method == 'cash') {
            $order = $this->attach_order($request, 'cash_on_delivery', $check_coupon);
            alertSuccess('Order added successfully', 'تم عمل الطلب بنجاح');
            return redirect()->route('ecommerce.order.success', ['order' => $order]);
        }

        if ($request->payment_method == 'paymob') {
            $order = $this->attach_order($request, 'paymob', $check_coupon);
            return redirect()->route('ecommerce.payment', ['orderId' => $order->id]);
        }


        if ($request->payment_method == 'upayment') {
            $order = $this->attach_order($request, 'upayment', $check_coupon);
            return redirect()->route('ecommerce.payment', ['orderId' => $order->id]);
        }
    }

    private function attach_order($request, $payment_method, $check_coupon)
    {

        $shipping_amount = 0;
        $cart_items = getCartItems();

        // 2 for bickup from branch
        if ($request->shipping_option == '2') {
            $shipping_method_id = 2;
            $shipping_amount = 0;
            $branch_id = $request->branch_id;
        } else {
            $shipping_method_id = setting('shipping_method');
            $shipping_amount = $this->calculateShipping($request);
            $branch_id = null;
        }

        if ($check_coupon == 0) {
            $coupon = Coupon::where('code', $request->coupon)->first();
        } else {
            $coupon = null;
        }




        $warehouses = getWebsiteWarehouses();
        $branch_id = setting('website_branch');

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

            // 'total_price' => getCartSubtotal($cart_items) + $shipping_amount,
            // 'subtotal_price' => getCartSubtotal($cart_items),
            'shipping_amount' => $shipping_amount,
            'shipping_method_id' => $shipping_method_id,

            // 'total_price_affiliate' => null,
            // 'total_commission' => null,
            // 'total_profit' => null,

            'status' => 'pending',
            'payment_method' => $payment_method,

            'transaction_id' => null,
            // 'total_tax' => null,
            'is_seen' => '0',


        ]);





        $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
        $vendors_tax = Tax::findOrFail(setting('vendors_tax'));
        $vat = Tax::findOrFail(setting('vat'));

        // to sum all products prices from all vendors to subtract it from total order price to create entries for revemue
        $total_order_vendors_products = 0;
        $total_vendors_tax_ammount = 0;
        $total_order_price = 0;

        // to send notification to admins to check stock limits
        $stocks_limit_products = [];

        // check user auth to send notifications
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = null;
        }


        foreach ($cart_items as $item) {

            // get cost for products or services
            if ($item->product->product_type == 'variable' || $item->product->product_type == 'simple') {

                $combination = ProductCombination::findOrFail($item->product_combination_id);



                if ($item->product->vendor_id == null) {
                    $cost = $combination->costs->where('branch_id', $branch_id)->first()->cost;
                    $warehouse = getWarehousForOrder(setting('website_branch'), $request->city_id, $combination, $item->qty);
                    if ($warehouse) {
                        $warehouse_id = $warehouse->id;
                    } else {
                        continue;
                    }
                } else {

                    $warehouse = Warehouse::where('vendor_id', $item->product->vendor_id)->first();
                    if ($warehouse) {
                        $warehouse_id = $warehouse->id;
                    } else {
                        continue;
                    }
                    $cost = 0;
                }
            } else {
                $cost = $item->product->cost;
                $warehouse_id = null;
            }

            if (setting('website_vat')) {
                $vat_product = calcTax((productPrice($item->product, $item->product_combination_id) * $item->qty), 'vat');
            } else {
                $vat_product = 0;
            }

            // attach order products
            $order->products()->attach(
                $item->product->id,
                [
                    'warehouse_id' => $warehouse_id,
                    'product_combination_id' => $item->product_combination_id,
                    'product_price' => productPrice($item->product, $item->product_combination_id, 'vat'),
                    'product_tax' => $vat_product,
                    // 'product_discount' => null,
                    'qty' => $item->qty,
                    'total' => (productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty),
                    'product_type' => $item->product->product_type,

                    'cost' => $cost,

                    // 'affiliate_price' => null,
                    // 'total_affiliate_price' => null,
                    // 'commission_per_item' => null,
                    // 'profit_per_item' => null,
                    // 'total_commission' => null,
                    // 'total_profit' => null,

                    'extra_shipping_amount' => $this->calculateShippingForItem($item),
                    'shipping_method_id' => $item->product->shipping_method_id,

                ]
            );


            $total_order_price += (productPrice($item->product, $item->product_combination_id) * $item->qty);

            // update order after each order product attach
            $order->update([
                'total_price' => $total_order_price + $shipping_amount,
                'subtotal_price' => $total_order_price,
            ]);


            $product = $item->product;


            // create cost entries and if the product belong to vendor we don't create the entry - vendor just can sell simple or variable products
            if ($item->product->product_type == 'variable' || $item->product->product_type == 'simple') {

                if ($item->product->vendor_id == null) {

                    $warehouse = getWarehousForOrder(setting('website_branch'), $request->city_id, $combination, $item->qty);
                    $warehouse_id = $warehouse->id;

                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                    $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                    Entry::create([
                        'account_id' => $product_account->id,
                        'type' => 'sales',
                        'dr_amount' => 0,
                        'cr_amount' => ($cost * $item->qty),
                        'description' => 'sales order# ' . $order->id,
                        'branch_id' => $branch_id,
                        'reference_id' => $order->id,
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);

                    Entry::create([
                        'account_id' => $cs_product_account->id,
                        'type' => 'sales',
                        'dr_amount' => ($cost * $item->qty),
                        'cr_amount' => 0,
                        'description' => 'sales order# ' . $order->id,
                        'branch_id' => $branch_id,
                        'reference_id' => $order->id,
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);
                }

                if ($item->product->vendor_id != null) {


                    $commission_rate = $item->product->category->vendor_profit;
                    $vendor_product_price = productPrice($item->product, $item->product_combination_id);
                    $vendor_total_price = ($vendor_product_price * $item->qty);
                    $vendor_commission = ($vendor_total_price * $commission_rate) / 100;
                    $vendor_commission_per_product = ($vendor_product_price * $commission_rate) / 100;
                    $vendor_profit = $vendor_total_price - $vendor_commission;

                    $total_order_vendors_products += $vendor_total_price;

                    $vendors_tax_ammount = ($vendor_commission * $vendors_tax->tax_rate) / 100;
                    $total_vendors_tax_ammount += $vendors_tax_ammount;

                    $warehouse = Warehouse::where('vendor_id', $item->product->vendor_id)->first();
                    $warehouse_id = $warehouse->id;

                    $vendor_order = $item->product->vendor->vendor_orders()->create([
                        'total_price' => $vendor_total_price,
                        'total_commission' => $vendor_commission,
                        'total_tax' => $vendors_tax_ammount,
                        'order_id' => $order->id,
                        'country_id' => $request->country_id,
                        'user_id' => $item->product->vendor_id,
                        'user_name' => $item->product->vendor->name,
                    ]);


                    $vendor_order->products()->attach(
                        $item->product->id,
                        [
                            'warehouse_id' => $warehouse->id,
                            'product_combination_id' => $item->product_combination_id,
                            'qty' => $item->qty,
                            'product_price' => $vendor_product_price,
                            'commission' => $vendor_commission_per_product,
                            'product_type' => $item->product->product_type,
                        ]
                    );

                    $title_ar = 'يوجد طلب جديد';
                    $body_ar = 'تم اضافة طلب جديد';
                    $title_en = 'There is a new order';
                    $body_en  = 'A new order has been added';
                    $url = route('vendor.orders.index');

                    // send notification to the vendor
                    $vendor = $item->product->vendor;
                    addNoty($vendor, $user, $url, $title_en, $title_ar, $body_en, $body_ar);

                    changeOutStandingBalance($item->product->vendor, $vendor_profit, $vendor_order->id, $vendor_order->status, 'add');


                    // add entry for commission tax account

                    $supplier_account = getItemAccount($item->product->vendor_id, null, 'suppliers_account', $branch_id);

                    Entry::create([
                        'account_id' => $supplier_account->id,
                        'type' => 'purchase',
                        'dr_amount' => 0,
                        'cr_amount' => $vendor_profit,
                        'description' => 'sales order# ' . $order->id,
                        'branch_id' => $branch_id,
                        'reference_id' => $order->id,
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);

                    if ($vendor_commission > 0) {

                        $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);

                        Entry::create([
                            'account_id' => $revenue_account->id,
                            'type' => 'sales',
                            'dr_amount' => 0,
                            'cr_amount' =>  $vendor_commission - $vendors_tax_ammount,
                            'description' => 'sales order# ' . $order->id,
                            'branch_id' => $branch_id,
                            'reference_id' => $order->id,
                            'created_by' => Auth::check() ? Auth::id() : null,
                        ]);


                        Entry::create([
                            'account_id' => $vendors_tax_account->id,
                            'type' => 'sales',
                            'dr_amount' => 0,
                            'cr_amount' =>  $vendors_tax_ammount,
                            'description' => 'sales order# ' . $order->id,
                            'branch_id' => $branch_id,
                            'reference_id' => $order->id,
                            'created_by' => Auth::check() ? Auth::id() : null,
                        ]);
                    }
                }


                Stock::create([
                    'product_combination_id' => $item->product_combination_id,
                    'product_id' => $item->product->id,
                    'warehouse_id' => $warehouse_id,
                    'qty' => $item->qty,
                    'stock_status' => 'OUT',
                    'stock_type' => 'Order',
                    'reference_id' => $order->id,
                    'reference_price' => productPrice($item->product, $item->product_combination_id, 'vat'),
                    'created_by' => Auth::check() ? Auth::id() : null,
                ]);

                // add noty for stock limit

                if (productQuantity($item->product->id, $item->combination->id, setting('warehouse_id')) <= $item->combination->limit && $item->product->vendor_id == null) {
                    array_push($stocks_limit_products, $item->product);
                }
            }



            if ($item->product->vendor_id == null) {
                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                } else {
                    $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                }


                Entry::create([
                    'account_id' => $revenue_account->id,
                    'type' => 'sales',
                    'dr_amount' =>   0,
                    'cr_amount' => (productPrice($item->product, $item->product_combination_id) * $item->qty),
                    'description' => 'sales order# ' . $order->id,
                    'branch_id' => $branch_id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
            }

            $item->delete();
        }


        if (Auth::check()) {
            $customer_account = getItemAccount(Auth::id(), null, 'customers_account', $branch_id);
        } else {
            $customer_account = getItemAccount(null, null, 'customers_account', $branch_id);
        }


        if ($total_order_vendors_products > $total_order_price) {
            $subtotal = ($total_order_vendors_products - $total_order_price);
        } else {
            $subtotal = ($total_order_price - $total_order_vendors_products);
        }


        if ($total_order_price > 0 && setting('website_vat')) {

            if ($coupon != null) {
                $discount = calcDiscount($coupon, $subtotal);
            } else {
                $discount = 0;
            }

            $vat_amount = calcTax($subtotal - $discount, 'vat');
        } elseif ($total_order_price) {
            $vat_amount = 0;
            $discount = calcDiscount($coupon, $subtotal);
        } else {
            $vat_amount = 0;
            $discount = 0;
        }

        // last update for order to add total price and total tax
        $order->update([
            'total_price' => $total_order_price + $shipping_amount + $vat_amount - $discount,
            'subtotal_price' => $total_order_price - $discount,
            'total_tax' => $vat_amount,
        ]);

        if ($discount > 0) {
            $order->update([
                'coupon_code' => $coupon->code,
                'coupon_amount' => $coupon->amount,
                'discount_amount' => $discount,
            ]);
        }

        $vat = Tax::findOrFail(setting('vat'));
        $order->taxes()->attach($vat->id, ['amount' => $vat_amount]);

        if ($total_vendors_tax_ammount > 0) {
            $order->taxes()->attach($vendors_tax->id, ['amount' => $total_vendors_tax_ammount]);
        }


        Entry::create([
            'account_id' => $customer_account->id,
            'type' => 'sales',
            'dr_amount' => $total_order_price + $shipping_amount + $vat_amount - $discount,
            'cr_amount' =>  0,
            'description' => 'sales order# ' . $order->id,
            'branch_id' => $branch_id,
            'reference_id' => $order->id,
            'created_by' => Auth::check() ? Auth::id() : null,
        ]);

        if ($vat_amount > 0) {
            $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $branch_id));

            Entry::create([
                'account_id' => $vat_account->id,
                'type' => 'sales',
                'dr_amount' => 0,
                'cr_amount' =>  $vat_amount,
                'description' => 'sales order# ' . $order->id,
                'branch_id' => $branch_id,
                'reference_id' => $order->id,
                'created_by' => Auth::check() ? Auth::id() : null,
            ]);
        }


        if ($shipping_amount > 0) {

            $revenue_account_shipping = getItemAccount(null, null, 'revenue_account_shipping', $branch_id);
            Entry::create([
                'account_id' => $revenue_account_shipping->id,
                'type' => 'sales',
                'dr_amount' =>   0,
                'cr_amount' => $shipping_amount,
                'description' => 'sales order# ' . $order->id,
                'branch_id' => $branch_id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);
        }






        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
        })->get();


        // send noti to admins about new order and stock limit
        foreach ($users as $admin) {
            $title_ar = 'يوجد طلب جديد';
            $body_ar = 'تم اضافة طلب جديد';
            $title_en = 'There is a new order';
            $body_en  = 'A new order has been added';
            $url = route('orders.index');


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
