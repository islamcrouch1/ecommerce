<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitsCategory;
use Illuminate\Http\Request;

class UnitsCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:units_categories-read')->only('index', 'show');
        $this->middleware('permission:units_categories-create')->only('create', 'store');
        $this->middleware('permission:units_categories-update')->only('edit', 'update');
        $this->middleware('permission:units_categories-delete|units_categories-trash')->only('destroy', 'trashed');
        $this->middleware('permission:units_categories-restore')->only('restore');
    }

    public function index()
    {


        $units_categories = UnitsCategory::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.units_categories.index')->with('units_categories', $units_categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.units_categories.create');
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
            'name_ar' => "required|string|max:255|unique:units_categories",
            'name_en' => "required|string|max:255|unique:units_categories",
            'unit_name_ar' => "required|string|max:255",
            'unit_name_en' => "required|string|max:255",
        ]);



        $units_category = UnitsCategory::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);


        $unit = Unit::create([
            'name_ar' => $request['unit_name_ar'],
            'name_en' => $request['unit_name_en'],
            'type' => 'default',
            'ratio' => 1,
            'units_category_id' => $units_category->id,
        ]);



        alertSuccess('units category created successfully', 'تم إضافة قسم وحدات القياس بنجاح');
        return redirect()->route('units_categories.index');
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
    public function edit($units_category)
    {
        $units_category = UnitsCategory::findOrFail($units_category);
        return view('dashboard.units_categories.edit ')->with('units_category', $units_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitsCategory $units_category)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:units_categories,name_ar," . $units_category->id,
            'name_en' => "required|string|max:255|unique:units_categories,name_en," . $units_category->id,
        ]);

        $units_category->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);

        alertSuccess('units_category updated successfully', 'تم تعديل قسم وحدات القياس بنجاح');
        return redirect()->route('units_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($units_category)
    {
        $units_category = UnitsCategory::withTrashed()->where('id', $units_category)->first();
        if ($units_category->trashed() && auth()->user()->hasPermission('units_categories-delete')) {
            $units_category->forceDelete();
            alertSuccess('units_category deleted successfully', 'تم حذف قسم وحدات القياس بنجاح');
            return redirect()->route('units_categories.trashed');
        } elseif (!$units_category->trashed() && auth()->user()->hasPermission('units_categories-trash') && checkUnitsCategoryForTrash($units_category)) {
            $units_category->delete();
            alertSuccess('units_category trashed successfully', 'تم حذف قسم وحدات القياس مؤقتا');
            return redirect()->route('units_categories.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the units_category cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو قسم وحدات القياس لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $units_categories = UnitsCategory::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.units_categories.index', ['units_categories' => $units_categories]);
    }

    public function restore($units_category, Request $request)
    {
        $units_category = UnitsCategory::withTrashed()->where('id', $units_category)->first()->restore();
        alertSuccess('units_category restored successfully', 'تم استعادة قسم وحدات القياس بنجاح');
        return redirect()->route('units_categories.index');
    }
}
