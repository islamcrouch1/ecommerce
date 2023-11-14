<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteCategory;
use Illuminate\Http\Request;

class WebsiteCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:website_categories-read')->only('index', 'show');
        $this->middleware('permission:website_categories-create')->only('create', 'store');
        $this->middleware('permission:website_categories-update')->only('edit', 'update');
        $this->middleware('permission:website_categories-delete|website_categories-trash')->only('destroy', 'trashed');
        $this->middleware('permission:website_categories-restore')->only('restore');
    }

    public function index()
    {


        $website_categories = WebsiteCategory::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.website_categories.index')->with('website_categories', $website_categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.website_categories.create');
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
            'name_ar' => "required|string|max:255|unique:website_categories",
            'name_en' => "required|string|max:255|unique:website_categories",
            'type' => "required|string",
            'sort_order' => "nullable|string",
        ]);


        $website_category = WebsiteCategory::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'type' => $request['type'],
            'sort_order' => $request['sort_order'],
        ]);

        alertSuccess('website_category created successfully', 'تم إضافة القسم بنجاح');
        return redirect()->route('website_categories.index');
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
    public function edit($website_category)
    {
        $website_category = WebsiteCategory::findOrFail($website_category);
        return view('dashboard.website_categories.edit ')->with('website_category', $website_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebsiteCategory $website_category)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:website_categories,name_ar," . $website_category->id,
            'name_en' => "required|string|max:255|unique:website_categories,name_en," . $website_category->id,
            'type' => "required|string",
            'sort_order' => "nullable|string",

        ]);

        $website_category->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'type' => $request['type'],
            'sort_order' => $request['sort_order'],
        ]);

        alertSuccess('website_category updated successfully', 'تم تعديل القسم بنجاح');
        return redirect()->route('website_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($website_category)
    {
        $website_category = WebsiteCategory::withTrashed()->where('id', $website_category)->first();
        if ($website_category->trashed() && auth()->user()->hasPermission('website_categories-delete')) {
            $website_category->forceDelete();
            alertSuccess('website_category deleted successfully', 'تم حذف القسم بنجاح');
            return redirect()->route('website_categories.trashed');
        } elseif (!$website_category->trashed() && auth()->user()->hasPermission('website_categories-trash') && checkWebsiteCategoryForTrash($website_category)) {
            $website_category->delete();
            alertSuccess('website_category trashed successfully', 'تم حذف القسم مؤقتا');
            return redirect()->route('website_categories.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the website_category cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو القسم لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $website_categories = WebsiteCategory::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.website_categories.index', ['website_categories' => $website_categories]);
    }

    public function restore($website_category, Request $request)
    {
        $website_category = WebsiteCategory::withTrashed()->where('id', $website_category)->first()->restore();
        alertSuccess('website_category restored successfully', 'تم استعادة القسم بنجاح');
        return redirect()->route('website_categories.index');
    }
}
