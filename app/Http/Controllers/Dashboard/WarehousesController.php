<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:warehouses-read')->only('index', 'show');
        $this->middleware('permission:warehouses-create')->only('create', 'store');
        $this->middleware('permission:warehouses-update')->only('edit', 'update');
        $this->middleware('permission:warehouses-delete|warehouses-trash')->only('destroy', 'trashed');
        $this->middleware('permission:warehouses-restore')->only('restore');
    }

    public function index()
    {


        $warehouses = Warehouse::whenSearch(request()->search)
            ->where('vendor_id', null)
            ->latest()
            ->paginate(100);



        return view('dashboard.warehouses.index')->with('warehouses', $warehouses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.warehouses.create')->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:warehouses",
            'name_en' => "required|string|max:255|unique:warehouses",
            'code' => "required|string|max:255|unique:warehouses",
            'address' => "required|string",
            'phone' => "nullable|string",
            'email' => "nullable|string",
            'country_id' => "required|string",
            'city_id' => "required|string",
        ]);


        $warehouse = Warehouse::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'country_id' => $request['country_id'],
            'city_id' => $request['city_id'],
        ]);

        alertSuccess('warehouse created successfully', 'تم إضافة المخزن بنجاح');
        return redirect()->route('warehouses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($warehouse)
    {
        $warehouse = Warehouse::findOrFail($warehouse);
        $countries = Country::all();
        return view('dashboard.warehouses.edit ')->with('warehouse', $warehouse)->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:warehouses,name_ar," . $warehouse->id,
            'name_en' => "required|string|max:255|unique:warehouses,name_en," . $warehouse->id,
            'code' => "required|string|max:255|unique:warehouses,code," . $warehouse->id,
            'address' => "required|string",
            'phone' => "nullable|string",
            'email' => "nullable|string",
            'country_id' => "required|string",
            'city_id' => "required|string",
        ]);

        $warehouse->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'country_id' => $request['country_id'],
            'city_id' => $request['city_id'],
        ]);

        alertSuccess('warehouse updated successfully', 'تم تعديل المخزن بنجاح');
        return redirect()->route('warehouses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($warehouse)
    {
        $warehouse = Warehouse::withTrashed()->where('id', $warehouse)->first();
        if ($warehouse->trashed() && auth()->user()->hasPermission('warehouses-delete')) {
            $warehouse->forceDelete();
            alertSuccess('warehouse deleted successfully', 'تم حذف المخزن بنجاح');
            return redirect()->route('warehouses.trashed');
        } elseif (!$warehouse->trashed() && auth()->user()->hasPermission('warehouses-trash') && checkwarehouseForTrash($warehouse)) {
            $warehouse->delete();
            alertSuccess('warehouse trashed successfully', 'تم حذف المخزن مؤقتا');
            return redirect()->route('warehouses.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the warehouse cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المخزن لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $warehouses = Warehouse::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.warehouses.index', ['warehouses' => $warehouses]);
    }

    public function restore($warehouse, Request $request)
    {
        $warehouse = Warehouse::withTrashed()->where('id', $warehouse)->first()->restore();
        alertSuccess('warehouse restored successfully', 'تم استعادة المخزن بنجاح');
        return redirect()->route('warehouses.index');
    }
}
