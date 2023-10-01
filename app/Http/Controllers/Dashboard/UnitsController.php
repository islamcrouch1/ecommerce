<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitsCategory;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:units-read')->only('index', 'show');
        $this->middleware('permission:units-create')->only('create', 'store');
        $this->middleware('permission:units-update')->only('edit', 'update');
        $this->middleware('permission:units-delete|units-trash')->only('destroy', 'trashed');
        $this->middleware('permission:units-restore')->only('restore');
    }

    public function index()
    {


        $units = Unit::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.units.index')->with('units', $units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = UnitsCategory::all();
        return view('dashboard.units.create', compact('categories'));
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
            'name_ar' => "required|string|max:255|unique:units",
            'name_en' => "required|string|max:255|unique:units",
            'type' => "required|string",
            'ratio' => "required|numeric|gt:0",
            'category_id' => "required|integer",
        ]);

        $unit = Unit::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'type' => $request['type'],
            'ratio' => $request['ratio'],
            'units_category_id' => $request['category_id'],
        ]);

        alertSuccess('unit created successfully', 'تم إضافة وحدة الفياس بنجاح');
        return redirect()->route('units.index');
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
    public function edit($unit)
    {
        $unit = Unit::findOrFail($unit);
        $categories = UnitsCategory::all();
        return view('dashboard.units.edit', compact('categories', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unit $unit)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:units,name_ar," . $unit->id,
            'name_en' => "required|string|max:255|unique:units,name_en," . $unit->id,
            // 'type' => "required|string",
            // 'ratio' => "required|numeric|gt:0",
        ]);

        $unit->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            // 'type' => $request['type'],
            // 'ratio' => $request['ratio'],

        ]);

        alertSuccess('unit updated successfully', 'تم تعديل وحدة القياس بنجاح');
        return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unit)
    {
        $unit = Unit::withTrashed()->where('id', $unit)->first();
        if ($unit->trashed() && auth()->user()->hasPermission('units-delete')) {
            $unit->forceDelete();
            alertSuccess('unit deleted successfully', 'تم حذف وحدة القياس بنجاح');
            return redirect()->route('units.trashed');
        } elseif (!$unit->trashed() && auth()->user()->hasPermission('units-trash') && checkUnitForTrash($unit)) {

            $category = UnitsCategory::findOrFail($unit->units_category_id);

            if ($unit->type == 'default' && $category->units()->count() > 1) {
                alertError('Sorry, you do not have permission to perform this action, or the unit cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو وحدة القياس لا يمكن حذفه حاليا');
                return redirect()->back()->withInput();
            }
            $unit->delete();

            alertSuccess('unit trashed successfully', 'تم حذف وحدة القياس مؤقتا');
            return redirect()->route('units.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the unit cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو وحدة القياس لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $units = Unit::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.units.index', ['units' => $units]);
    }

    public function restore($unit, Request $request)
    {
        $unit = Unit::withTrashed()->where('id', $unit)->first()->restore();
        alertSuccess('unit restored successfully', 'تم استعادة وحدة القياس بنجاح');
        return redirect()->route('units.index');
    }
}
