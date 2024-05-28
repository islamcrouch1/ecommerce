<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use App\Models\RunningOrder;
use App\Models\Serial;
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

    public function store(Request $request)
    {
    }


    public function update(Request $request, RunningOrder $running_order)
    {


        $request->validate([
            'approved_qty' => "required|integer|gt:0",
            'notes' => "nullable|string",
            'serials' => "nullable|array",
        ]);

        $remaining_qty = $running_order->requested_qty - $running_order->approved_qty - $running_order->returned_qty;
        $approved_qty = $request->approved_qty;

        if ($request->approved_qty > $remaining_qty) {
            alertError('The quantity required for approval is more than the required quantity', 'الكمية المطلوبة للاعتماد اكثر من الكمية المطلوبة');
            return redirect()->back()->withInput();
        }

        if ($remaining_qty == 0) {
            alertError('All quantities have been validated', 'تم التحقق من جميع الكميات مسبقا');
            return redirect()->back()->withInput();
        }

        if (isset($request->serials) && (count($request->serials) > $approved_qty)) {
            alertError('The number of serials entered is greater than the quantity of products', 'عدد السيريال المدخلة اكبر من كمية المنتجات ');
            return redirect()->back()->withInput();
        }

        // if ($returned_qty > 0 && ($running_order->stock_type == 'sales' || $running_order->stock_type == 'purchases')) {

        //     $refund = Refund::create([
        //         'user_id' => Auth::id(),
        //         'order_id' => $running_order->reference_id,
        //         'reason' => $request->notes,
        //         'status' => 'pending',
        //         'type' => 'warehouse',
        //         'product_id' => $running_order->product_id,
        //         'combination_id' => $running_order->product_combination_id,
        //         'qty' => $returned_qty
        //     ]);
        // }


        if ($approved_qty > 0) {

            if ($running_order->stock_type == 'purchases') {
                $returned = $running_order->stock_status == 'IN' ? false : true;



                $check = createPurchasesEntries($running_order->product_combination_id, $running_order->reference_id, $returned, $approved_qty, $running_order->unit_id, $request->serials);
                if ($check == false) {
                    alertError('Quantities are not available in stock', 'الكميات غير متوفره في المخزون');
                    return redirect()->back()->withInput();
                }
            }

            if ($running_order->stock_type == 'sales') {

                $returned = $running_order->stock_status == 'OUT' ? false : true;
                $check = createSalesEntries($running_order->product_combination_id, $running_order->reference_id, $returned, $approved_qty, $running_order->unit_id);
                if ($check == false) {
                    alertError('Quantities are not available in stock', 'الكميات غير متوفره في المخزون');
                    return redirect()->back()->withInput();
                }
            }
        }


        $running_order->update([
            'approved_qty' => $running_order->approved_qty +  $approved_qty,
            'notes' => $request->notes,
        ]);

        if ($running_order->approved_qty == $running_order->requested_qty) {
            $running_order->update([
                'status' => 'completed',
            ]);
        } elseif ($running_order->approved_qty < $running_order->requested_qty) {
            $running_order->update([
                'status' => 'partial',
            ]);
        }


        alertSuccess('Quantities validated successfully', 'تم التحقق من الكميات بنجاح');
        return redirect()->route('running_orders.index');
    }
}
