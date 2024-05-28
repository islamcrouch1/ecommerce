<?php




// check if the order is returned

use App\Models\Account;
use App\Models\Branch;
use App\Models\Cost;
use App\Models\Invoice;
use App\Models\ManufacturingOrder;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\RunningOrder;
use App\Models\Serial;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
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


if (!function_exists('checkOrdersForReturn')) {
    function checkOrdersForReturn($order, $combinations, $qty, $warehouse_id)
    {

        $check = true;
        $count = 0;




        foreach ($combinations as $index => $combination_id) {

            $combination = ProductCombination::find($combination_id);
            $product = $combination->product;

            if ($product->product_type == 'simple' || $product->product_type == 'variable') {


                $ref_product =  $order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                $order_qty = $ref_product->pivot->qty;



                $returned_qty = 0;

                foreach ($order->orders->where('status', 'returned') as $returned_order) {
                    $ref_product =  $returned_order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                    $returned_qty += $ref_product->pivot->qty;
                }

                $order_qty = $order_qty - $returned_qty;

                if ($qty[$index] > $order_qty || $qty[$index] <= 0) {
                    $count += 1;
                }
            }
        }

        if ($count > 0) {
            $check = false;
        }

        return $check;
    }
}



if (!function_exists('checkQtyForInvoice')) {
    function checkQtyForInvoice($order, $request)
    {

        $error = null;

        foreach ($request->selected_combinations as $index => $combination_id) {

            $combination = ProductCombination::find($combination_id);
            $product = Product::findOrFAil($request->prods[$index]);

            if ($product->product_type == 'simple' || $product->product_type == 'variable') {


                $ref_product =  $order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                $order_qty = $ref_product->pivot->qty;

                $invoiced_qty = 0;

                foreach ($order->invoices->whereIn('status', ['invoice', 'bill']) as $invoice) {
                    $ref_product =  $invoice->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                    $invoiced_qty += $ref_product->pivot->qty;
                }

                $returned_qty = 0;

                foreach ($order->invoices->whereIn('status', ['credit_note', 'debit_note']) as $invoice) {
                    $ref_product =  $invoice->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
                    $returned_qty += $ref_product->pivot->qty;
                }

                $order_qty = $order_qty - ($invoiced_qty - $returned_qty);

                if ($request->status == 'invoice' || $request->status == 'bill') {
                    if ($request->qty[$index] > $order_qty || $request->qty[$index] <= 0) {
                        $error = __('Quantities required for invoicing are not available');
                    }
                } else {
                    if ($request->qty[$index] > $invoiced_qty || $request->qty[$index] <= 0) {
                        $error = __('Quantities required for returns are not available');
                    }
                }
            }
        }

        return $error;
    }
}


if (!function_exists('checkDiscountForInvoice')) {
    function checkDiscountForInvoice($order, $request)
    {

        $error = null;

        $order_discount = $order->discount_amount;

        $invoiced_discount = 0;

        foreach ($order->invoices->whereIn('status', ['invoice', 'bill']) as $invoice) {
            $invoiced_discount += $invoice->discount_amount;
        }

        $returned_discount = 0;

        foreach ($order->invoices->whereIn('status', ['credit_note', 'debit_note']) as $invoice) {
            $returned_discount += $invoice->discount_amount;
        }

        $order_discount = $order_discount - ($invoiced_discount - $returned_discount);

        if ($request->status == 'invoice' || $request->status == 'bill') {
            if ($request->discount > $order_discount) {
                $error = __('Discount required for invoicing are not available');
            }
        } else {
            if ($request->discount > $invoiced_discount) {
                $error = __('Discount required for returns are not available');
            }
        }

        return $error;
    }
}


if (!function_exists('checkShippingForInvoice')) {
    function checkShippingForInvoice($order, $request)
    {

        $error = null;

        $order_shipping = $order->shipping_amount;

        $invoiced_shipping = 0;

        foreach ($order->invoices->whereIn('status', ['invoice', 'bill']) as $invoice) {
            $invoiced_shipping += $invoice->shipping_amount;
        }

        $returned_shipping = 0;

        foreach ($order->invoices->whereIn('status', ['credit_note', 'debit_note']) as $invoice) {
            $returned_shipping += $invoice->shipping_amount;
        }

        $order_shipping = $order_shipping - ($invoiced_shipping - $returned_shipping);

        if ($request->status == 'invoice' || $request->status == 'bill') {
            if ($request->shipping > $order_shipping) {
                $error = __('Shipping required for invoicing are not available');
            }
        } else {
            if ($request->shipping > $invoiced_shipping) {
                $error = __('Shipping required for returns are not available');
            }
        }

        return $error;
    }
}

// update combination cost
if (!function_exists('updateCost')) {
    function updateCost($combination, $new_cost, $qty, $type, $branch_id, $unit_id = null)
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
        $qty = getQtyByUnit($qty, $unit_id);

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

        if ($order_from == 'purchases') {
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
        } elseif ($order_from == 'sales') {
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

        if ($order_from == 'purchases') {
            if ($returned == true) {
                $data = 'purchase_return';
            } else {
                $data = 'purchase';
            }
        } elseif ($order_from == 'sales') {
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
            $number = preg_replace("/[^0-9]/", "", $lastOrder->serial);
        }

        $number += 1;

        $prefix = getPrefix($order_type);


        return ($prefix . '/' . $number);
    }
}


if (!function_exists('getLastInvoiceSerial')) {
    function getLastInvoiceSerial($status)
    {

        $lastInvoice = Invoice::where('status', $status)->orderBy('created_at', 'desc')->first();

        if (!$lastInvoice) {
            $number = 0;
        } else {
            $number = preg_replace("/[^0-9]/", "", $lastInvoice->serial);
        }

        $number += 1;

        $prefix = getPrefix($status);


        return ($prefix . '/' . $number);
    }
}


if (!function_exists('getPrefix')) {
    function getPrefix($order_type)
    {
        $prefix = '';

        if ($order_type == 'RFQ') {
            $prefix = setting('serial_prefix_RFQ');
        }

        if ($order_type == 'PO') {
            $prefix = setting('serial_prefix_PO');
        }

        if ($order_type == 'SO') {
            $prefix = setting('serial_prefix_SO');
        }

        if ($order_type == 'Q') {
            $prefix = setting('serial_prefix_Q');
        }


        if ($order_type == 'invoice') {
            $prefix = setting('serial_prefix_inv');
        }

        if ($order_type == 'bill') {
            $prefix = setting('serial_prefix_bill');
        }


        if ($order_type == 'credit_note') {
            $prefix = setting('serial_prefix_credit_note');
        }

        if ($order_type == 'debit_note') {
            $prefix = setting('serial_prefix_debit_note');
        }

        if ($order_type == 'payment') {
            $prefix = setting('serial_prefix_payment');
        }

        if ($order_type == 'receipt') {
            $prefix = setting('serial_prefix_receipt');
        }

        return $prefix;
    }
}


if (!function_exists('getOrderSerial')) {
    function getOrderSerial($order)
    {

        if ($order->order_type == 'RFQ') {
            $serial = setting('serial_prefix_RFQ') . '-'  . $order->serial;
        }


        if ($order->order_type == 'PO') {
            $serial = setting('serial_prefix_PO') . '-'  . $order->serial;
        }


        if ($order->order_type == 'SO') {
            $serial = setting('serial_prefix_SO') . '-'  . $order->serial;
        }

        if ($order->order_type == 'Q') {
            $serial = setting('serial_prefix_Q') . '-'  . $order->serial;
        }


        return $serial;
    }
}




if (!function_exists('getAccountNameForOrder')) {
    function getAccountNameForOrder($order_from, $type)
    {
        $data = '';

        if ($order_from == 'purchases') {
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
                case "interim":
                    $data = 'stock_interim_received_account';
                    break;
                default:
                    $data = '';
                    break;
            }
        } elseif ($order_from == 'sales') {
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
                case "interim":
                    $data = 'stock_interim_delivered_account';
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
        if ($tax && setting('website_vat') != null) {
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
if (!function_exists('RunningOrderCreate')) {
    function RunningOrderCreate($combination, $warehouse_id, $qty, $unit_id,  $type, $stock_type, $order = null, $user_id = null, $price = 0)
    {



        $running_order = null;

        if ($order && $order->status == 'canceled') {

            $running_order = RunningOrder::where('reference_id', $order->id)->where('product_combination_id', $combination->id)->get();

            if ($running_order->count() == 1) {

                $running_order = $running_order->first();
                $remaining_qty = $running_order->requested_qty - $running_order->approved_qty - $running_order->returned_qty;

                if (($qty - $remaining_qty) <= 0) {
                    $running_order->update([
                        'returned_qty' => $running_order->returned_qty + $qty,
                        'status' => ($running_order->returned_qty + $qty + $running_order->approved_qty == $running_order->requested_qty) ? 'completed' : 'partial',
                    ]);
                } else {

                    $returned_qty = 0;
                    if ($running_order->status == 'completed') {
                        $returned_qty = $qty;
                    } else {
                        $returned_qty = $qty - $remaining_qty;
                    }

                    if ($qty != $returned_qty) {
                        $running_order->update([
                            'returned_qty' => $running_order->returned_qty + $remaining_qty,
                            'status' =>  'completed',
                        ]);
                    }

                    RunningOrder::create([
                        'product_combination_id' => $combination->id,
                        'product_id' => $combination->product_id,
                        'warehouse_id' => $warehouse_id,
                        'requested_qty' => $returned_qty,
                        'unit_id' => $unit_id,
                        'stock_status' => $stock_type,
                        'stock_type' => $type,
                        'reference_id' => $order->id,
                        'user_id' => $user_id,
                        'stock_id' => null,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        }

        if ((!isset(request()->running_order) && request()->running_order != true) && $combination->product->vendor_id == null && $running_order == null) {
            RunningOrder::create([
                'product_combination_id' => $combination->id,
                'product_id' => $combination->product_id,
                'warehouse_id' => $warehouse_id,
                'requested_qty' => $qty,
                'unit_id' => $unit_id,
                'stock_status' => $stock_type,
                'stock_type' => $type,
                'reference_id' => $order->id,
                'user_id' => $user_id,
                'stock_id' => null,
                'created_by' => Auth::id(),
            ]);
        }

        if ($order->order_from == 'sales' && $order->status != 'canceled') {

            $av_qty = productQuantity($combination->product_id, $combination->id, $warehouse_id);
            $qty = getQtyByUnit($qty, $unit_id);

            if ($qty > $av_qty) {
                // create manufacturing order in case manufacturing product

                if ($combination->product->can_manufactured == 'on') {
                    $manu_order = ManufacturingOrder::create([
                        'product_id' => $combination->product_id,
                        'product_combination_id' => $combination->id,
                        'qty' => $qty,
                        'unit_id' => $combination->product->unit_id,
                        'sales_id' => Auth::id(),
                        'order_id' => $order ? $order->id : null,
                    ]);
                }
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
                    $product_price = productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty * $item->days;


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
                            $discount += $product_discount;
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
                $product_price = productPrice($item->product, $item->product_combination_id, 'vat') * $item->days;

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
                $product_price = productPrice($item->product, $item->product_combination_id, 'vat') * $item->days;


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


if (!function_exists('createPurchasesEntries')) {
    function createPurchasesEntries($combination_id, $order_id, $returned, $qty, $unit_id, $serials = [])
    {

        $combination = ProductCombination::find($combination_id);
        $product = $combination->product;
        $order = Order::findOrFail($order_id);
        $ref_product =  $order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();
        $price = $ref_product->pivot->product_price;
        $warehouse_id = $order->warehouse_id;
        // get real quantity

        $check = true;

        if ($product->product_type == 'variable' || $product->product_type == 'simple') {

            $check = createStock($combination, $warehouse_id, $qty, $unit_id, 'purchases', $returned == true ? 'OUT' : 'IN', $order, $price);


            if ($check) {


                if ($returned == false) {

                    for ($i = 0; $i < $qty; $i++) {
                        Serial::create([
                            'product_combination_id' => $combination->id,
                            'product_id' => $product->id,
                            'warehouse_id' => $warehouse_id,
                            'unit_id' => $product->unit_id,
                            'serial' => isset($serials[$i]) ? $serials[$i] : null,
                        ]);
                    }
                }

                $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $order->branch_id);
                $stock_interim_received_account = Account::findOrFail(settingAccount(getAccountNameForOrder('purchases', 'interim'), $order->branch_id));
                createEntry($product_account, $returned == true ? 'purchase_return' : 'purchase', $returned == true ? 0 : ($price * $qty), $returned == true ? ($price * $qty) : 0, $order->branch_id, $order);
                createEntry($stock_interim_received_account, $returned == true ? 'purchase_return' : 'purchase', $returned == true ? ($price * $qty) : 0, $returned == true ? 0 : ($price * $qty), $order->branch_id, $order);
            }
        }

        return $check;
    }
}

if (!function_exists('createSalesEntries')) {
    function createSalesEntries($combination_id, $order_id, $returned, $qty, $unit_id)
    {




        $combination = ProductCombination::find($combination_id);
        $product = $combination->product;
        $order = Order::findOrFail($order_id);
        $ref_product =  $order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $combination->id)->first();

        $cost = getCostForOrder($order, $product, $combination);

        $price = $ref_product->pivot->product_price;
        $warehouse_id = $ref_product->pivot->warehouse_id;

        // get real quantity

        $check = true;

        if ($product->product_type == 'variable' || $product->product_type == 'simple') {

            $check = createStock($combination, $warehouse_id, $qty, $unit_id, 'sales', $returned == true ? 'IN' : 'OUT', $order, $price);

            if ($check) {

                if ($product->can_rent == null) {
                    $qty = getQtyByUnit($qty, $unit_id);
                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $order->branch_id);
                    createEntry($product_account, $returned == true ? 'sales_return' : 'sales', $returned == true ? ($cost * $qty) :  0, $returned == true ? 0 : ($cost * $qty), $order->branch_id, $order, null, getDefaultCurrency()->id);
                    $stock_interim_delivered_account = Account::findOrFail(settingAccount(getAccountNameForOrder('sales', 'interim'), $order->branch_id));
                    createEntry($stock_interim_delivered_account, $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $qty), $returned == true ? ($cost * $qty) : 0, $order->branch_id, $order, null, getDefaultCurrency()->id);
                }

                // $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $order->branch_id);
                // createEntry($cs_product_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $qty), $returned == true ? ($cost * $qty) : 0, $order->branch_id, $order);
            }
        }

        return $check;
    }
}


// stock create
if (!function_exists('createStock')) {
    function createStock($combination, $warehouse_id, $qty, $unit_id,  $type, $stock_type, $order = null, $price = 0)
    {

        $check = true;


        if ($stock_type == 'OUT') {

            $av_qty = productQuantity($combination->product_id, $combination->id, $warehouse_id);
            $qtyInDefaultUnit = getQtyByUnit($qty, $unit_id);

            if ($qtyInDefaultUnit > $av_qty) {
                $check = false;
            }

            if ($order) {
                $serial = Serial::where('product_combination_id', $combination->id)->where('warehouse_id', $warehouse_id)->where('status', '0')->first();

                if ($serial == null) {
                    $check = false;
                } else {
                    $serial->update([
                        'order_id' => $order->id,
                        'status' => '2',
                    ]);
                }
            }
        }


        if ($stock_type == 'IN' && $order != null) {
            $serial = Serial::where('order_id', $order->id)->first();
            if ($serial != null) {
                $serial->update([
                    'order_id' => null,
                    'status' => '0',
                ]);
            }
        }


        if ($check) {
            // create stock record
            $stock = Stock::create([
                'product_combination_id' => $combination->id,
                'product_id' => $combination->product_id,
                'warehouse_id' => $warehouse_id,
                'qty' => $qty,
                'unit_id' => $unit_id,
                'stock_status' => $stock_type,
                'stock_type' => $type,
                'reference_id' => $order->id,
                'reference_price' => $price,
                'created_by' =>  Auth::id(),
            ]);
        }

        return $check;
    }
}





if (!function_exists('checkWarehouse')) {
    function checkWarehouse($warehouse_id)
    {

        $branch_id = getUserBranchId(Auth::user());
        $branch = Branch::findOrFail($branch_id);

        $error = null;

        if ($branch->warehouses->where('id', $warehouse_id)->count() != 1) {
            $error = __('You do not have permission to use the specified warehouse');
        }

        return $error;
    }
}


if (!function_exists('checkAccountsErrors')) {
    function checkAccountsErrors($order_from, $branch_id)
    {
        $error = null;

        if (!checkOrderAccounts($order_from, $branch_id)) {
            $error = __('Please set the default accounts settings from the settings page');
        }

        return $error;
    }
}

if (!function_exists('checkProductsQtyAndPrice')) {
    function checkProductsQtyAndPrice($combinations, $qtys, $prices)
    {
        $error = null;

        foreach ($combinations as $index => $combination_id) {
            if ($qtys[$index] <= 0 || $prices[$index] <= 0) {
                $error = __('Please add quantity or price to complete the request');
            }
        }

        return $error;
    }
}


if (!function_exists('getInvoiceStatus')) {
    function getInvoiceStatus($invoice)
    {

        $invoice_status = '';

        $invoice_status = '<span class="badge badge-soft-success ">' . __($invoice->status) . '</span>';

        return $invoice_status;

        return null;
    }
}







if (!function_exists('createQuotation')) {
    function createQuotation($request, $order = null)
    {
        $user = User::findOrFail($request->user_id);
        $order_from = isset($request->order_from) ? $request->order_from : null;
        $branch_id = getUserBranchId(Auth::user());

        if ($order == null) {
            $order = Order::create([
                'customer_id' => $user->id,
                'warehouse_id' => $request->warehouse_id,
                'order_from' => $order_from,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'notes' => $request->notes,
                'branch_id' => $branch_id,
                'order_type' => $request->order_type,
                'status' => 'pending',
                'serial' => getLastOrderSerial($request->order_type),
                'expected_delivery' => $request->expected_delivery,
                'expiration_date' => $request->expiration_date,
                'currency_id' => $request->currency_id,
                'admin_id' => Auth::id(),
            ]);
        } else {
            $order->update([
                'customer_id' => $user->id,
                'warehouse_id' => $request->warehouse_id,
                'order_from' => $order_from,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'notes' => $request->notes,
                'branch_id' => $branch_id,
                'status' => ($request->order_type == 'SO' || $request->order_type == 'PO') ? 'completed' : 'pending',
                'expected_delivery' => $request->expected_delivery,
                'expiration_date' => $request->expiration_date,
                'currency_id' => $request->currency_id,
            ]);
        }

        $order->products()->detach();
        $order->taxes()->detach();

        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $taxes_data = [];



        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = Product::findOrFAil($request->prods[$index]);

                $product_price = ($request->qty[$index] * $request->price[$index] * $request->days[$index]);
                $subtotal += $product_price;

                $order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        // 'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                        // 'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                        'qty' => $request->qty[$index],
                        'unit_id' => $request->units[$index],
                        'total' => $request->price[$index] * $request->qty[$index] * $request->days[$index],
                        'product_type' => $product->product_type,
                        // 'cost' => $cost,

                        'start_date' => $request->start_date[$index],
                        'end_date' => getEndDate($request->start_date[$index], $request->days[$index]),
                        'days' => $request->days[$index],

                    ]
                );

                $order->update([
                    'total_price' => $subtotal,
                    'subtotal_price' => $subtotal,
                ]);
            } catch (Exception $e) {
            }
        }

        $total = $order->total_price - $request->discount;

        if ($request->taxes) {
            foreach ($request->taxes as $index => $tax) {
                $tax_data = calcTaxByID($order->total_price - $request->discount, $tax);
                $taxes_data[$index] = $tax_data;
                $total += $tax_data['tax_amount'];

                if ($tax_data['tax_amount'] > 0) {
                    $vat_amount += $tax_data['tax_amount'];
                } else {
                    $wht_amount += abs($tax_data['tax_amount']);
                }
                $order->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);
            }
        }

        $order->update([
            'total_price' => $total,
            'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
            'discount_amount' => $request->discount,
        ]);


        return $order;
    }
}

if (!function_exists('createOrder')) {
    function createOrder($request)
    {
        $user = User::findOrFail($request->user_id);
        $order_from = isset($request->order_from) ? $request->order_from : null;
        $branch_id = getUserBranchId(Auth::user());
        $returned = false;

        $order = Order::create([
            'customer_id' => $user->id,
            'warehouse_id' => $request->warehouse_id,
            'order_from' => $order_from,
            'full_name' => $user->name,
            'phone' => $user->phone,
            'country_id' => $user->country_id,
            'notes' => $request->notes,
            'branch_id' => $branch_id,
            'order_type' => $request->order_type,
            'status' => 'completed',
            'serial' => getLastOrderSerial($request->order_type),
            'expected_delivery' => $request->expected_delivery,
            'currency_id' => $request->currency_id,
            'admin_id' => Auth::id(),
        ]);


        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $stocks_limit_products = [];
        $taxes_data = [];


        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = Product::findOrFAil($request->prods[$index]);

                $product_price = ($request->qty[$index] * $request->price[$index]);
                $subtotal += $product_price;

                $order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        // 'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                        // 'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                        'qty' => $request->qty[$index],
                        'unit_id' => $request->units[$index],
                        'total' => $request->price[$index] * $request->qty[$index],
                        'product_type' => $product->product_type,
                        // 'cost' => $cost,
                    ]
                );

                $order->update([
                    'total_price' => $subtotal,
                    'subtotal_price' => $subtotal,
                ]);


                if ($request->order_type == 'SO' || $request->order_type == 'PO') {

                    // add stock update and antries
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                        if ($order_from == 'sales') {
                            RunningOrderCreate($combination, $request->warehouse_id, $request->qty[$index], $request->units[$index], 'sales', $returned == true ? 'IN' : 'OUT', $order, $user->id, $request->price[$index]);
                        }
                        if ($order_from == 'purchases') {
                            RunningOrderCreate($combination, $request->warehouse_id, $request->qty[$index], $request->units[$index], 'purchases', $returned == true ? 'OUT' : 'IN', $order, $user->id, $request->price[$index]);
                        }

                        if ($order_from == 'sales') {
                            // add noty for stock limit
                            if (productQuantity($product->id, $request->selected_combinations[$index], $request->warehouse_id) <= $combination->limit) {
                                array_push($stocks_limit_products, $product);
                            }
                        }
                    }
                }
            } catch (Exception $e) {
            }
        }

        $total = $order->total_price - $request->discount;

        if ($request->taxes) {
            foreach ($request->taxes as $index => $tax) {
                $tax_data = calcTaxByID($order->total_price - $request->discount, $tax);
                $taxes_data[$index] = $tax_data;
                $total += $tax_data['tax_amount'];

                if ($tax_data['tax_amount'] > 0) {
                    $vat_amount += $tax_data['tax_amount'];
                } else {
                    $wht_amount += abs($tax_data['tax_amount']);
                }
                $order->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);
            }
        }

        $order->update([
            'total_price' => $total,
            'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
            'discount_amount' => $request->discount,
        ]);


        return $order;
    }
}

if (!function_exists('createInvoice')) {
    function createInvoice($request, $returned, $branch_id, $order_from, $order = null)
    {

        $user = User::findOrFail($request->user_id);

        $invoice = Invoice::create([
            'customer_id' => $user->id,
            'warehouse_id' => $request->warehouse_id,
            'status' => $request->status,
            'branch_id' => $branch_id,
            'serial' => getLastInvoiceSerial($request->status),
            'due_date' => $request->due_date,
            'currency_id' => $request->currency_id,
            'admin_id' => Auth::id(),
            'order_id' => $order != null ? $order->id : null
        ]);




        if (!isset($request->discount) || $request->discount <= 0) {
            $discount = 0;
            $discountForItem = 0;
        } else {
            $discount = $request->discount;
            $discountForItem = $discount / count($request->qty);
        }

        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $taxes_data = [];



        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = Product::findOrFAil($request->prods[$index]);


                $product_price = ($request->qty[$index] * $request->price[$index]) - $discountForItem;
                $subtotal += $product_price;



                $invoice->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        'qty' => $request->qty[$index],
                        'unit_id' => $request->units[$index],
                        'total' => $request->price[$index] * $request->qty[$index],
                    ]
                );

                $invoice->update([
                    'total_price' => $subtotal,
                    'subtotal_price' => $subtotal,
                ]);

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    if ($request->status == 'invoice' || $request->status == 'credit_note') {

                        $cost = getCostForOrder($order, $product, $combination);
                        $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);
                        $stock_interim_delivered_account = Account::findOrFail(settingAccount(getAccountNameForOrder('sales', 'interim'), $order->branch_id));

                        createEntry($cs_product_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $request->qty[$index]), $returned == true ? ($cost * $request->qty[$index]) : 0, $branch_id, $order, null, getDefaultCurrency()->id);
                        createEntry($stock_interim_delivered_account, $returned == true ? 'sales_return' : 'sales',  $returned == true ? ($cost * $request->qty[$index]) : 0, $returned == true ? 0 : ($cost * $request->qty[$index]), $order->branch_id, $order, null, getDefaultCurrency()->id);

                        $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                    } elseif ($request->status == 'bill' || $request->status == 'debit_note') {
                        $stock_interim_received_account = Account::findOrFail(settingAccount(getAccountNameForOrder('purchases', 'interim'), $order->branch_id));
                        createEntry($stock_interim_received_account, $returned == true ? 'purchase_return' : 'purchase', $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]),  $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $order->branch_id, $order, null, $invoice->currency_id);
                    }
                } else {
                    if ($request->status == 'invoice' || $request->status == 'credit_note') {
                        $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                    }
                }

                if ($request->status == 'invoice' || $request->status == 'credit_note') {
                    createEntry($revenue_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $branch_id, $order, null, $invoice->currency_id);
                }
            } catch (Exception $e) {
            }
        }

        $total = $invoice->total_price;

        if ($request->taxes) {
            foreach ($request->taxes as $index => $tax) {
                $tax_data = calcTaxByID($invoice->total_price, $tax);
                $taxes_data[$index] = $tax_data;
                $total += $tax_data['tax_amount'];

                if ($tax_data['tax_amount'] > 0) {
                    $vat_amount += $tax_data['tax_amount'];
                } else {
                    $wht_amount += abs($tax_data['tax_amount']);
                }
                $invoice->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);
            }
        }

        $invoice->update([
            'total_price' => $total,
            'subtotal_price' => $invoice->subtotal_price + $request->discount,
            'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
            'discount_amount' => $request->discount,
        ]);




        if (isset($request->shipping) && $request->shipping > 0) {
            $shipping_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'shipping'), $branch_id));
            createEntry($shipping_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $request->shipping, $order_from, 'shipping', 'dr'), getAmountForOrder($returned, $request->shipping, $order_from, 'shipping', 'cr'), $branch_id, $order, null, $invoice->currency_id);
        }

        if ($discount > 0) {
            $discount_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'discount'), $branch_id));
            createEntry($discount_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $discount, $order_from, 'discount', 'dr'), getAmountForOrder($returned, $discount, $order_from, 'discount', 'cr'), $branch_id, $order, null, $invoice->currency_id);
        }

        if ($vat_amount > 0) {
            $vat_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'vat'), $branch_id));
            createEntry($vat_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $vat_amount, $order_from, 'vat', 'dr'), getAmountForOrder($returned, $vat_amount, $order_from, 'vat', 'cr'), $branch_id, $order, null, $invoice->currency_id);
        }


        if ($wht_amount > 0) {
            $wht_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'wht'), $branch_id));
            createEntry($wht_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $wht_amount, $order_from, 'wht', 'dr'), getAmountForOrder($returned, $wht_amount, $order_from, 'wht', 'cr'), $branch_id, $order, null, $invoice->currency_id);
        }


        $user_account = getItemAccount($user->id, null, getAccountNameForOrder($order_from, 'user'), $branch_id);
        createEntry($user_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, ($invoice->total_price + $invoice->shipping_amount), $order_from, 'user', 'dr'), getAmountForOrder($returned, ($invoice->total_price + $invoice->shipping_amount), $order_from, 'user', 'cr'), $branch_id, $order, null, $invoice->currency_id);


        return $invoice;
    }
}



if (!function_exists('getTotalorders')) {
    function getTotalorders($user)
    {

        $total = 0;
        $orders = $user->orders;
        $currency = getDefaultCurrency();

        foreach ($orders as $order) {
            if ($order->status == 'completed') {

                if ($order->currency_id != $currency->id) {
                    $exchange_rate = getExchangeRate($order->currency_id);
                } else {
                    $exchange_rate = 1;
                }
                $total += ($order->total_price + $order->shipping_amount) * $exchange_rate;
            }
        }

        return $total;
    }
}




if (!function_exists('getOrderTotalInvoices')) {
    function getOrderTotalInvoices($order)
    {

        $total = 0;
        $invoices = $order->invoices;

        foreach ($invoices as $invoice) {
            if ($invoice->status == 'invoice' || $invoice->status == 'bill') {
                $total += ($invoice->total_price + $invoice->shipping_amount);
            }
        }

        return $total;
    }
}


if (!function_exists('getInvoiceTotalPayments')) {
    function getInvoiceTotalPayments($invoice)
    {

        $total = 0;
        $payments = $invoice->payments;

        foreach ($payments as $payment) {
            if ($invoice->status == 'invoice' || $invoice->status == 'debit_note') {
                if ($payment->amount > 0) {
                    $total += abs($payment->amount);
                }
            } elseif ($invoice->status == 'bill' || $invoice->status == 'credit_note') {
                if ($payment->amount < 0) {
                    $total += abs($payment->amount);
                }
            }
        }

        return $total;
    }
}


if (!function_exists('getInvoiceTotalReturns')) {
    function getInvoiceTotalReturns($invoice)
    {

        $total = 0;
        $payments = $invoice->payments;

        foreach ($payments as $payment) {

            if ($invoice->status == 'invoice' || $invoice->status == 'debit_note') {
                if ($payment->amount < 0) {
                    $total += abs($payment->amount);
                }
            } elseif ($invoice->status == 'bill' || $invoice->status == 'credit_note') {
                if ($payment->amount > 0) {
                    $total += abs($payment->amount);
                }
            }
        }

        return $total;
    }
}

if (!function_exists('getInvoiceTotalAmount')) {
    function getInvoiceTotalAmount($invoice)
    {

        $total = 0;
        $total = $invoice->total_price + $invoice->shipping_amount;
        return $total;
    }
}

if (!function_exists('getOrderTotalReturnes')) {
    function getOrderTotalReturnes($order)
    {

        $total = 0;
        $invoices = $order->invoices;

        foreach ($invoices as $invoice) {
            if ($invoice->status == 'credit_note' || $invoice->status == 'debit_note') {
                $total += ($invoice->total_price + $invoice->shipping_amount);
            }
        }

        return $total;
    }
}
