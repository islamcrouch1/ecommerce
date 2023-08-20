<?php




// check if the order is returned

use App\Models\Branch;
use App\Models\Cost;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\RunningOrder;
use App\Models\Stock;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


if (!function_exists('checkIfReturned')) {
    function checkIfReturned()
    {
        return request()->has('return') ? true : false;
    }
}



// check quantities and status
if (!function_exists('checkProductsForOrder')) {
    function checkProductsForOrder($products, $combinations, $qty, $warehouse_id)
    {

        $check = true;
        $count = 0;

        foreach ($combinations as $index => $combination_id) {

            if ($products == null) {
                $combination = ProductCombination::findOrFail($combination_id);
                $product = $combination->product;
            } else {
                $product = Product::findOrFail($products[$index]);
            }

            if ($product->product_type == 'simple' || $product->product_type == 'variable') {

                $av_qty = productQuantity($product->id, $combinations[$index], $warehouse_id);

                if ($qty[$index] > $av_qty || $qty[$index] <= 0) {
                    $count += 1;
                }
            }

            if ($product->status != 'active' && $products != null) {
                $count += 1;
            }
        }

        if ($count > 0) {
            $check = false;
        }

        return $check;
    }
}


// update combination cost
if (!function_exists('updateCost')) {
    function updateCost($combination, $new_cost, $qty, $type, $branch_id)
    {

        $cost = $combination->costs->where('branch_id', $branch_id)->first();
        $branch = Branch::findOrFail($branch_id);
        $warehouses = $branch->warehouses;

        if ($cost == null) {
            $cost = Cost::create([
                'product_id' => $combination->product_id,
                'product_combination_id' => $combination->id,
                'branch_id' => $branch_id,
            ]);
        }

        $old_qty = productQuantity($combination->product_id, $combination->id, null, $warehouses);

        if ($type == 'add') {
            $all_qty = $old_qty + $qty;
            $old_cost = $cost->cost * $old_qty;
            $all_cost = $old_cost + ($new_cost * $qty);
        } else {
            $all_qty = $old_qty - $qty;
            $old_cost = $cost->cost * $old_qty;
            $all_cost = $old_cost - ($new_cost * $qty);
        }

        if ($all_qty == 0) {
            $new_cost = 0;
        } else {
            $new_cost = $all_cost / $all_qty;
        }

        $cost->update([
            'cost' => $new_cost,
        ]);

        return $cost->cost;
    }
}


if (!function_exists('getAmountForOrder')) {
    function getAmountForOrder($returned, $amount, $order_from, $account_type, $type)
    {
        $data = 0;

        $account_type = getAccountTypeForOrder($order_from, $account_type);


        if ($account_type == 'dr') {
            if ($type == 'cr') {
                if ($returned == true) {
                    $data = $amount;
                } else {
                    $data = 0;
                }
            } elseif ($type == 'dr') {
                if ($returned == true) {
                    $data = 0;
                } else {
                    $data = $amount;
                }
            }
        } elseif ($account_type == 'cr') {
            if ($type == 'dr') {
                if ($returned == true) {
                    $data = $amount;
                } else {
                    $data = 0;
                }
            } elseif ($type == 'cr') {
                if ($returned == true) {
                    $data = 0;
                } else {
                    $data = $amount;
                }
            }
        }

        return $data;
    }
}

if (!function_exists('getAccountTypeForOrder')) {
    function getAccountTypeForOrder($order_from, $account_type)
    {
        $data = '';

        if ($order_from == 'addpurchase') {
            switch ($account_type) {
                case "discount":
                    $data = 'cr';
                    break;
                case "vat":
                    $data = 'dr';
                    break;
                case "wht":
                    $data = 'cr';
                    break;
                case "user":
                    $data = 'cr';
                    break;
                case "shipping":
                    $data = 'dr';
                    break;
                default:
                    $data = '';
                    break;
            }
        } elseif ($order_from == 'addsale') {
            switch ($account_type) {
                case "discount":
                    $data = 'dr';
                    break;
                case "vat":
                    $data = 'cr';
                    break;
                case "wht":
                    $data = 'dr';
                    break;
                case "user":
                    $data = 'dr';
                    break;
                case "shipping":
                    $data = 'cr';
                    break;
                default:
                    $data = '';
                    break;
            }
        }

        return $data;
    }
}


if (!function_exists('getTypeForOrder')) {
    function getTypeForOrder($order_from, $returned)
    {
        $data = '';

        if ($order_from == 'addpurchase') {
            if ($returned == true) {
                $data = 'purchase_return';
            } else {
                $data = 'purchase';
            }
        } elseif ($order_from == 'addsale') {
            if ($returned == true) {
                $data = 'sales_return';
            } else {
                $data = 'sales';
            }
        }

        return $data;
    }
}


if (!function_exists('getLastOrderSerial')) {
    function getLastOrderSerial($order_type)
    {

        $lastOrder = Order::where('order_type', $order_type)->orderBy('created_at', 'desc')->first();

        if (!$lastOrder) {
            $number = 0;
        } else {
            $number = $lastOrder->serial;
        }

        return $number + 1;
    }
}


if (!function_exists('getOrderSerial')) {
    function getOrderSerial($order)
    {

        if ($order->order_type == 'RFQ' || $order->order_type == 'PO') {
            $serial = setting('serial_prefix_PO') . $order->serial;
        } else {
            $serial = setting('serial_prefix_SO') . $order->serial;
        }

        return $serial;
    }
}




if (!function_exists('getAccountNameForOrder')) {
    function getAccountNameForOrder($order_from, $type)
    {
        $data = '';

        if ($order_from == 'addpurchase') {
            switch ($type) {
                case "discount":
                    $data = 'earned_discount_account';
                    break;
                case "vat":
                    $data = 'vat_purchase_account';
                    break;
                case "wht":
                    $data = 'wct_account';
                    break;
                case "user":
                    $data = 'suppliers_account';
                    break;
                case "shipping":
                    $data = 'expenses_account_shipping';
                    break;
                default:
                    $data = '';
                    break;
            }
        } elseif ($order_from == 'addsale') {
            switch ($type) {
                case "discount":
                    $data = 'allowed_discount_account';
                    break;
                case "vat":
                    $data = 'vat_sales_account';
                    break;
                case "wht":
                    $data = 'wst_account';
                    break;
                case "user":
                    $data = 'customers_account';
                    break;
                case "shipping":
                    $data = 'revenue_account_shipping';
                    break;
                default:
                    $data = '';
                    break;
            }
        }

        return $data;
    }
}



// check order tax exist and calculate tax
if (!function_exists('calcTaxIfExist')) {
    function calcTaxIfExist($amount, $type, $taxes = [], $totalOrderAmount = 0)
    {
        $tax_amount = 0;
        if (is_array($taxes) && in_array($type, $taxes)) {
            $tax_amount = calcTax($amount, $type);
        } else {
            if (($type == 'wht_products' || $type == 'wht_services')  && ($totalOrderAmount > setting('wht_invoice_amount')) && (is_array($taxes) && in_array('wht', $taxes))) {
                $tax_amount = calcTax($amount, $type);
            } else {
                $tax_amount = 0;
            }
        }
        return $tax_amount;
    }
}

// calculate tax
if (!function_exists('calcTax')) {
    function calcTax($price, $type)
    {
        $tax_amount = 0;
        $rate = 0;
        if (setting($type)) {
            $tax = Tax::find(setting($type));
        }
        if ($tax) {
            $rate = $tax->tax_rate;
            $tax_amount = ($price * $rate) / 100;
        }
        return $tax_amount;
    }
}


// calculate tax
if (!function_exists('calcTaxByID')) {
    function calcTaxByID($price, $tax_id)
    {
        $tax_amount = 0;
        $rate = 0;

        $data = [];

        $tax = Tax::find($tax_id);


        if ($tax) {

            $signal = $tax->type == 'plus' ? 1 : -1;

            $rate = $tax->tax_rate;
            $tax_amount = (($price * $rate) / 100) * $signal;

            $data['tax_amount'] = $tax_amount;
            $data['name'] = getName($tax);
        } else {
            $data['tax_amount'] = 0;
            $data['name'] = '';
        }


        return $data;
    }
}


// stock create
if (!function_exists('stockCreate')) {
    function stockCreate($combination, $warehouse_id, $qty,  $type, $stock_type, $order_id = null, $user_id = null, $price = 0)
    {

        $stock = Stock::create([
            'product_combination_id' => $combination->id,
            'product_id' => $combination->product_id,
            'warehouse_id' => $warehouse_id,
            'qty' => $qty,
            'stock_status' => $stock_type,
            'stock_type' => $type,
            'reference_id' => $order_id,
            'reference_price' => $price,
            'created_by' =>  Auth::id(),
        ]);

        $running_order = null;
        if ($order_id) {
            $running_order = RunningOrder::where('reference_id', $order_id)->where('product_combination_id', $combination->id)->first();
        }


        if ((!isset(request()->running_order) && request()->running_order != true) && $combination->product->vendor_id == null && $running_order == null) {
            RunningOrder::create([
                'product_combination_id' => $combination->id,
                'product_id' => $combination->product_id,
                'warehouse_id' => $warehouse_id,
                'requested_qty' => $qty,
                'stock_status' => $stock_type,
                'stock_type' => $type,
                'reference_id' => $order_id,
                'user_id' => $user_id,
                'stock_id' => $stock->id,
                'created_by' => Auth::id(),
            ]);
        } elseif ($running_order != null) {
            if ($running_order->approved_qty == 0 && $running_order->returned_qty == 0) {
                $running_order->update([
                    'approved_qty' => 0,
                    'returned_qty' => $qty,
                    'status' => 'completed',
                ]);
            }
        }
    }
}



// calculate coupon discount with offers
if (!function_exists('calcDiscount')) {
    function calcDiscount($cart_items, $coupon = null, $price = null)
    {

        $discount = 0;

        if ($coupon) {

            $products = unserialize($coupon->products);
            $categories = unserialize($coupon->categories);

            if (is_array($products) || is_array($categories)) {

                foreach ($cart_items as $item) {

                    $product_discount = 0;
                    $product_price = productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty;

                    if ($products == null) {
                        $products = [];
                    }

                    if ($categories == null) {
                        $categories = [];
                    }

                    if (in_array($item->product->id, $products) || in_array($item->product->category_id, $categories)) {

                        if ($coupon->type == 'percentage') {

                            $product_discount = ($product_price * $coupon->amount) / 100;
                            $discount += $product_discount;
                        }
                        if ($coupon->type == 'amount') {
                            $product_discount = ($coupon->amount);
                        }
                    }
                }

                if ($coupon->type == 'percentage' && $price >= $coupon->min_value) {
                    if ($discount > $coupon->max_value) {
                        $discount =  $coupon->max_value;
                    }
                }

                if ($coupon->type == 'amount' && $price >= $coupon->min_value) {
                    if ($discount > (($price * $coupon->max_value) / 100)) {
                        $discount =  (($price * $coupon->max_value) / 100);
                    }
                }

                if ($price < $coupon->min_value) {
                    $discount = 0;
                }
            } else {

                if ($coupon->type == 'percentage' && $price >= $coupon->min_value) {
                    $discount = ($price * $coupon->amount) / 100;
                    if ($discount > $coupon->max_value) {
                        $discount =  $coupon->max_value;
                    }
                }

                if ($coupon->type == 'amount' && $price >= $coupon->min_value) {
                    $discount = ($coupon->amount);
                    if ($discount > (($price * $coupon->max_value) / 100)) {
                        $discount =  (($price * $coupon->max_value) / 100);
                    }
                }
            }
        } else {

            $check_qty = [];
            $check_product = [];

            foreach ($cart_items as $item) {

                $date = Carbon::now();
                $offer = getOffers('product_quantity_discount', $item->product, $date)->first();

                $product_discount = 0;
                // update it to save product price in the array becase the price may be change in variables
                $product_price = productPrice($item->product, $item->product_combination_id, 'vat');

                if (isset($offer) && $date <= $offer->ended_at) {

                    $amount = $offer->amount;
                    $qty = $offer->qty;

                    if (isset($check_qty[$item->product_id]['qty'])) {
                        $check_qty[$item->product_id]['qty'] += $item->qty;
                    } else {
                        $check_qty[$item->product_id]['qty'] = $item->qty;
                    }


                    // discount occure one for item we need to update the code to calculate the discount if the cart contain one item and this item has offer
                    if ($check_qty[$item->product_id]['qty'] >= $qty) {
                        $product_discount = (($product_price * $qty) * $amount) / 100;

                        // save discount to check it in another offers
                        $check_qty[$item->product_id]['discount'] = $product_discount;

                        $discount += $product_discount;
                        $check_qty[$item->product_id]['qty'] = $check_qty[$item->product_id]['qty'] - $qty;
                    }
                }
            }

            foreach ($cart_items as $item) {

                $date = Carbon::now();
                $bundle_offer = getOffers('bundles_offer', $item->product, $date)->first();

                $product_discount = 0;
                $product_price = productPrice($item->product, $item->product_combination_id, 'vat');


                if (isset($bundle_offer) && $date <= $bundle_offer->ended_at) {

                    $amount = $bundle_offer->amount;

                    if (!isset($check_product[$item->product_id]['check']) && !isset($check_qty[$item->product_id]['discount'])) {
                        $check_product[$item->product_id]['check'] = 1;
                        $check_product[$item->product_id]['discount'] = (($product_price) * $amount) / 100;
                    }


                    if (getOfferProducts($bundle_offer)->count() == count($check_product)) {
                        foreach ($check_product as $check) {
                            $discount += $check['discount'];
                        }
                        $check_product = [];
                    }
                }
            }
        }


        return $discount;
    }
}


// get offers
if (!function_exists('getOffers')) {
    function getOffers($type, $product = null, $date = null)
    {

        $country = getCountry();
        $offers = Offer::where('country_id', $country->id)->where('type', $type)->get();

        if (isset($product->id)) {


            foreach ($offers as $index => $offer) {
                $products = unserialize($offer->products);
                if (!is_array($products)) {
                    $products = [];
                }
                $categories = unserialize($offer->categories);
                if (!is_array($categories)) {
                    $categories = [];
                }

                if (!in_array($product->id, $products) && !in_array($product->category_id, $categories)) {
                    $offers->forget($index);
                }
            }
        }

        return $offers;
    }
}


// get offer products
if (!function_exists('getOfferProducts')) {
    function getOfferProducts($offer)
    {

        $country = getCountry();
        $warehouses = getWebsiteWarehouses();


        $products = unserialize($offer->products);

        if (!is_array($products)) {
            $products = [];
        }


        $categories = unserialize($offer->categories);

        if (!is_array($categories)) {
            $categories = [];
        }



        $products = Product::where(function ($query) use ($products, $categories) {
            $query->whereIn('id', $products)
                ->orWhereIn('category_id', $categories);
        })
            ->where('status', "active")
            ->where('country_id', $country->id)
            ->where(function ($query) use ($warehouses) {
                $query->whereHas('stocks', function ($query) use ($warehouses) {
                    $query->whereIn('warehouse_id', $warehouses);
                })->orWhereIn('product_type', ['digital', 'service'])
                    ->orWhereNotNull('vendor_id');
            })
            ->inRandomOrder()
            ->limit(30)
            ->get();

        return $products;
    }
}
