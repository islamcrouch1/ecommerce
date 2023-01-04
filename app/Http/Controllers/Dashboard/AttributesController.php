<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:attributes-read')->only('index', 'show');
        $this->middleware('permission:attributes-create')->only('create', 'store');
        $this->middleware('permission:attributes-update')->only('edit', 'update');
        $this->middleware('permission:attributes-delete|attributes-trash')->only('destroy', 'trashed');
        $this->middleware('permission:attributes-restore')->only('restore');
    }

    public function index()
    {


        $attributes = Attribute::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('Dashboard.attributes.index')->with('attributes', $attributes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard.attributes.create');
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
            'name_ar' => "required|string|max:255|unique:attributes",
            'name_en' => "required|string|max:255|unique:attributes",
        ]);


        $attribute = attribute::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);

        alertSuccess('attribute created successfully', 'تم إضافة سمة المنتجات بنجاح');
        return redirect()->route('attributes.index');
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
    public function edit($attribute)
    {
        $attribute = Attribute::findOrFail($attribute);
        return view('Dashboard.attributes.edit ')->with('attribute', $attribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:attributes,name_ar," . $attribute->id,
            'name_en' => "required|string|max:255|unique:attributes,name_en," . $attribute->id,
        ]);

        $attribute->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);

        alertSuccess('attribute updated successfully', 'تم تعديل سمة المنتج بنجاح');
        return redirect()->route('attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($attribute)
    {
        $attribute = Attribute::withTrashed()->where('id', $attribute)->first();
        if ($attribute->trashed() && auth()->user()->hasPermission('attributes-delete')) {
            $attribute->forceDelete();
            alertSuccess('attribute deleted successfully', 'تم حذف سمة المنتج بنجاح');
            return redirect()->route('attributes.trashed');
        } elseif (!$attribute->trashed() && auth()->user()->hasPermission('attributes-trash') && checkattributeForTrash($attribute)) {
            $attribute->delete();
            alertSuccess('attribute trashed successfully', 'تم حذف سمة المنتج مؤقتا');
            return redirect()->route('attributes.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the attribute cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو سمة المنتج لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {
        $attributes = Attribute::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('Dashboard.attributes.index', ['attributes' => $attributes]);
    }

    public function restore($attribute, Request $request)
    {
        $attribute = attribute::withTrashed()->where('id', $attribute)->first()->restore();
        alertSuccess('attribute restored successfully', 'تم استعادة سمة المنتج بنجاح');
        return redirect()->route('attributes.index');
    }
}
