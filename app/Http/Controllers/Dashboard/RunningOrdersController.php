<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RunningOrder;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RunningOrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:add_stock-read')->only('atockAdd');
        $this->middleware('permission:stock_lists-read')->only('stockList');
        $this->middleware('permission:stock_inventory-read')->only('inventory');
        $this->middleware('permission:stock_shortages-read')->only('index');
    }


    public function index()
    {

        $user = Auth::user();


        if ($user->hasPermission('branches-read')) {
            $warehouses = Warehouse::all()->pluck('id')->toArray();
        } else {
            $warehouses = $user->branch->warehouses->pluck('id')->toArray();
        }


        $orders = RunningOrder::whenProduct(request()->product)
            ->whenWarehouse(request()->warehouse_id)
            ->whereHas('warehouse', function ($query) {
                $query->where('vendor_id', null);
            })->whereIn('warehouse_id', $warehouses)
            ->whenSearch(request()->search)
            ->whenWarehouse(request()->warehouse_is)
            ->whenStatus(request()->status)
            ->whenStockStatus(request()->stock_status)
            ->latest()
            ->paginate(50);


        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();

        return view('dashboard.running_orders.index', compact('orders', 'warehouses'));
    }

    public function edit(RunningOrder $running_order)
    {
        return view('dashboard.running_orders.edit', compact('running_order'));
    }


    public function update(Request $request, RunningOrder $running_order)
    {


        $request->validate([
            'approved_qty' => "required|integer|gt:-1",
            'returned_qty' => "required|integer|gt:-1",
            'notes' => "nullable|string",
        ]);

        $remaining_qty = $running_order->requested_qty - ($running_order->approved_qty + $running_order->returned_qty);

        $returned_qty = $request->returned_qty -  $running_order->returned_qty;
        $approved_qty = $request->approved_qty -  $running_order->approved_qty;

        if (($returned_qty < 0) ||  ($approved_qty < 0)) {
            alertError('The quantities do not match', 'الكميات غير متطابقة');
            return redirect()->back();
        }


        if (($returned_qty + $approved_qty) >  $remaining_qty) {

            alertError('The quantities do not match', 'الكميات غير متطابقة');
            return redirect()->back();
        }


        if ($remaining_qty == 0) {
            alertError('All quantities have been validated', 'تم التحقق من جميع الكميات مسبقا');
            return redirect()->back();
        }


        if ($returned_qty > 0 && ($running_order->stock_type == 'Sale' || $running_order->stock_type == 'Purchase')) {

            $combinations = [$running_order->product_combination_id];
            $prods = [$running_order->product_id];
            $qty = [$returned_qty];
            $notes = $request->notes;
            $warehouse_id = $running_order->warehouse->id;
            $supplier_id = $running_order->user_id;
            $user_id = $running_order->user_id;
            $order_id = $running_order->reference_id;
            $order = Order::findOrFail($running_order->reference_id);
            $price = [$order->products()->where('product_id', $running_order->product_id)->where('product_combination_id', $running_order->product_combination_id)->first()->pivot->product_price];
            $tax = $order->taxes->pluck('id')->toArray();

            $request->merge([
                'combinations' => $combinations,
                'prods' => $prods,
                'qty' => $qty,
                'tax' => $tax,
                'price' => $price,
                'warehouse_id' => $warehouse_id,
                'supplier_id' => $supplier_id,
                'user_id' => $user_id,
                'order_id' => $order_id,
                'running_order' => true,
            ]);

            if ($running_order->stock_type == 'Purchase') {
                $purchase = new PurchasesController();
                $purchase->storeReturn($request);
            } elseif ($running_order->stock_type == 'Sale') {
                $sale = new SalesController();
                $sale->storeReturn($request);
            }
        }

        $running_order->update([
            'approved_qty' => $running_order->approved_qty +  $approved_qty,
            'returned_qty' => $running_order->returned_qty + $returned_qty,
        ]);

        if (($running_order->approved_qty + $running_order->returned_qty) == $running_order->requested_qty) {
            $running_order->update([
                'status' => 'completed',
            ]);
        } elseif (($running_order->approved_qty + $running_order->returned_qty) < $running_order->requested_qty) {
            $running_order->update([
                'status' => 'partial',
            ]);
        }


        alertSuccess('Quantities validated successfully', 'تم التحقق من الكميات بنجاح');
        return redirect()->route('running_orders.edit', ['running_order' => $running_order->id]);
    }
}
