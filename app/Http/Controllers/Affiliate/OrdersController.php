<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Models\ShippingRate;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'shipping' => 'required|string',
            'phone1' => 'required|string',
            'notes' => 'nullable|string',
            'house' => 'nullable|string',
            'phone2' => 'nullable|string',
            'special_mark' => 'nullable|string',
        ]);

        $count = 0;

        foreach ($user->cart->products as $product) {
            if ($product->pivot->product_type == 0) {
                if ($product->pivot->quantity > intval(Stock::find($product->pivot->stock_id)->quantity)) {
                    // $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
                    $count = $count + 1;
                }
            }
            // else {

            //     if ($product->pivot->stock > intval(Astock::find($product->pivot->stock_id)->stock)) {
            //         $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
            //         $count = $count + 1;
            //     }
            // }
        }

        if ($count > 0) {
            alertError('There are products that do not have enough stock to make the order, please check the available quantities in stock', 'هناك منتجات ليس بها مخزون كافي لعمل الطلب يرجى مراجعة الكميات المتاحه في المخزون مع العلم انه تم حذف هذه المنتجات من سلة مشترياتك');
            return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }

        if ($user->cart->products->count() <= 0) {
            alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }

        foreach ($user->cart->products as $product) {
            if ($product->pivot->product_price != $product->price) {
                $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
                alertError('Some prices of the products in your cart have been updated, please check the order again', 'تم تحديث بعض أسعار المنتجات الموجودة بسلة مشترياتك يرجى مراجعة الطلب مرة أخرى');
                return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
            }
        }

        $this->attach_order($request, $user);
        alertSuccess('Order added successfully', 'تم عمل الطلب بنجاح');
        return redirect()->route('orders.affiliate.index');
    }

    private function attach_order($request, $user)
    {

        $shipping = ShippingRate::find($request->shipping)->cost;

        $order = $user->orders()->create([
            'total_price' => 0,
            'total_commission' => 0,
            'total_profit' => 0,
            'address' => $request->address,
            'house' => $request->house,
            'special_mark' => $request->special_mark,
            'full_name' => $request->name,
            'client_phone' => $request->phone1,
            'phone2' => $request->phone2,
            'notes' => $request->notes,
            'country_id' => $user->country->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'shipping_rate_id' => $request->shipping,
            'shipping' => $shipping,
        ]);





        foreach ($user->cart->products as $product) {

            if ($product->pivot->product_type == '0') {
                $av_stock = Stock::find($product->pivot->stock_id);
            }

            // else {
            //     $av_stock = Astock::find($product->pivot->stock_id);
            // }

            $order->products()->attach(
                $product->id,
                [
                    'stock_id' => $product->pivot->stock_id,
                    'quantity' => $product->pivot->quantity,
                    'selling_price' => $product->pivot->price,
                    'vendor_price' => $product->vendor_price,
                    'commission_per_item' => $product->pivot->price - $product->price,
                    'profit_per_item' => $product->price - $product->vendor_price,
                    'total_selling_price' => ($product->pivot->price * $product->pivot->quantity),
                    'total_commission' => ($product->pivot->price - $product->price) * $product->pivot->quantity,
                    'product_type' => $product->pivot->product_type,
                    'size_ar' => $av_stock->size->size_ar,
                    'size_en' => $av_stock->size->size_en,
                    'color_en' => $av_stock->color->color_en,
                    'color_ar' => $av_stock->color->color_ar
                ]
            );


            $vendor_order = $product->vendor->vendor_orders()->create([
                'total_price' => $product->vendor_price * $product->pivot->quantity,
                'order_id' => $order->id,
                'country_id' => $user->country->id,
                'user_id' => $product->vendor->id,
                'user_name' => $product->vendor->name,
            ]);
            $vendor_order->products()->attach(
                $product->id,
                [
                    'stock_id' => $product->pivot->stock_id,
                    'quantity' => $product->pivot->quantity,
                    'vendor_price' => $product->vendor_price,
                    'total_vendor_price' => ($product->vendor_price * $product->pivot->quantity),
                    'product_type' => $product->pivot->product_type,
                    'size_ar' => $av_stock->size->size_ar,
                    'size_en' => $av_stock->size->size_en,
                    'color_en' => $av_stock->color->color_en,
                    'color_ar' => $av_stock->color->color_ar
                ]
            );
            changeOutStandingBalance($product->vendor, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'add');
            $total_price = 0;
        }

        $total_price = 0;
        $total_commission = 0;
        $total_profit = 0;
        $stocks_limit = [];

        foreach ($user->cart->products as $product) {

            $total_price += ($product->pivot->price * $product->pivot->quantity);
            $total_commission += ($product->pivot->price - $product->price) * $product->pivot->quantity;
            $total_profit += ($product->price - $product->vendor_price) * $product->pivot->quantity;

            $product_stock = $product->stocks->find($product->pivot->stock_id);

            if ($product->pivot->product_type == '0') {
                $product_stock->update([
                    'quantity' => $product_stock->quantity - $product->pivot->quantity
                ]);
            }

            if ($product_stock->quantity < $product_stock->limit) {
                array_push($stocks_limit, $product_stock->id);
            }

            // else {

            //     $product->astocks->find($product->pivot->stock_id)->update([
            //         'stock' => $product->astocks->find($product->pivot->stock_id)->stock - $product->pivot->stock
            //     ]);
            // }
        } //end of foreach

        $order->update([
            'total_price' => $total_price,
            'total_commission' => $total_commission,
            'total_profit' => $total_profit,
        ]);

        // $mystock_price = 0;
        // foreach ($user->cart->products as $product) {
        //     if ($product->pivot->product_type != '0') {
        //         $mystock_price += ($product->price * $product->pivot->quantity);
        //     }
        // }

        changeOutStandingBalance($user, $order->total_commission, $order->id, $order->status, 'add');

        foreach ($user->cart->products as $product) {

            $user->cart->products()->detach();
        }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
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
                $url = route('stock.management.index', ['search' => $product->id]);
                addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }
    }


    public function index(Request $request)
    {

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('user_id', Auth::id())
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $user = Auth::user();
        return view('affiliate.orders.index')->with('orders', $orders)->with('user', $user);
    }

    public function cancelOrder(Order $order)
    {


        foreach ($order->products as $product) {
            if ($product->pivot->product_type == '0') {
                $product->stocks->find($product->pivot->stock_id)->update([
                    'quantity' => $product->stocks->find($product->pivot->stock_id)->quantity + $product->pivot->quantity
                ]);
            }
            // else {

            //     $product->astocks->find($product->pivot->stock_id)->update([
            //         'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
            //     ]);
            // }
        }

        foreach ($order->vendor_orders as $vendor_order) {
            changeOutStandingBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, 'canceled', 'sub');

            $vendor_order->update([
                'status' => 'canceled',
            ]);
        }

        $order->update([
            'status' => 'canceled',
        ]);

        createOrderHistory($order, $order->status);


        $description_ar = "تم تغيير حالة الطلب الى ملغي" . ' طلب رقم ' . ' #' . $order->id;
        $description_en  = "order status has been changed to cancelled" . ' order No ' . ' #' . $order->id;

        addLog('affiliate', 'orders', $description_ar, $description_en);

        // $mystock_price = 0;

        // foreach ($order->products as $product) {
        //     if ($product->pivot->product_type != '0') {
        //         $mystock_price += ($product->min_price * $product->pivot->stock);
        //     }
        // }

        changeOutStandingBalance($order->user, $order->total_commission, $order->id, $order->status, 'sub');

        alertSuccess('Order canceled successfully', 'تم إلغاء الطلب بنجاح');
        return redirect()->route('orders.affiliate.index');
    }

    public function show(Order $order)
    {
        return view('affiliate.orders.show')->with('order', $order);
    }

    public function storeRefund(Request $request, Order $order)
    {

        $request->validate([
            'reason' => "required|string",
        ]);

        $user = Auth::user();

        $rerturn = Refund::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'reason' => $request->reason,
        ]);


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
        })->get();

        foreach ($users as $admin) {
            $title_ar = 'يوجد طلب مرتجع جديد';
            $body_ar = 'تم اضافة طلب مرتجع جديد من  : ' . $user->name;
            $title_en = 'There is a new refund request';
            $body_en  = 'A new refund request has been added from : ' . $user->name;
            $url = route('orders.refunds');
            addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
        }

        alertSuccess('Request sent successfully', 'تم ارسال الطلب بنجاح');
        return redirect()->route('orders.affiliate.index');
    }
}
