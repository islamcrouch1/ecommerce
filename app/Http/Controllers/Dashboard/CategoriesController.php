<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:categories-read')->only('index', 'show');
        $this->middleware('permission:categories-create')->only('create', 'store');
        $this->middleware('permission:categories-update')->only('edit', 'update');
        $this->middleware('permission:categories-delete|categories-trash')->only('destroy', 'trashed');
        $this->middleware('permission:categories-restore')->only('restore');
    }

    public function index()
    {
        if (!request()->has('parent_id')) {
            request()->merge(['parent_id' => null]);
        }

        $categories = Category::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenParent(request()->parent_id)
            ->latest()
            ->paginate(100);

        $countries = Country::all();

        return view('dashboard.categories.index')->with('categories', $categories)->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.create')->with('countries', $countries)->with('categories', $categories)->with('parent_id', request()->parent_id);
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
            'name_ar' => "required|string|max:255|unique:categories",
            'name_en' => "required|string|max:255|unique:categories",
            'image' => "nullable|image",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'country' => "required",
            'parent_id' => "nullable|string",
            'category_slug' => "nullable|string|max:255",
            'profit' => "nullable|numeric|gte:0",
            'sort_order' => "nullable|numeric|gte:0",
            'subtitle_en' => "nullable|string",
            'subtitle_ar' => "nullable|string",
            'vendor_profit' => "nullable|numeric|gte:0",
            'status' => "required|string",

        ]);

        $slug = createSlug($request->category_slug ? $request->category_slug : ($request->name_ar . '-' . $request->name_en));

        if ($request->hasFile('image')) {
            $media_id = saveMedia('image', $request['image'], 'categories');
        }

        $category = Category::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'] ? $request['description_ar'] : ' ',
            'description_en' => $request['description_en'] ? $request['description_en'] : ' ',
            'media_id' => isset($media_id) ? $media_id : null,
            'country_id' => $request['country'],
            'parent_id' => isset($request['parent_id']) ? $request['parent_id'] : null,
            'profit' => $request['profit'] ? $request['profit'] : 0,
            'vendor_profit' => $request['vendor_profit'] ? $request['vendor_profit'] : 0,
            'category_slug' => $slug,
            'sort_order' => $request['sort_order'] ? $request['sort_order'] : 0,
            'created_by' => Auth::id(),
            'subtitle_ar' => $request['subtitle_ar'],
            'subtitle_en' => $request['subtitle_en'],
            'status' => $request['status'],
        ]);

        alertSuccess('Category created successfully', 'تم إضافة القسم بنجاح');
        return redirect()->route('categories.index', ['parent_id' => $request->parent_id]);
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
    public function edit($category)
    {
        $countries = Country::all();
        $category = Category::findOrFail($category);
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.edit ')->with('category', $category)->with('countries', $countries)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:categories,name_ar," . $category->id,
            'name_en' => "required|string|max:255|unique:categories,name_en," . $category->id,
            'image' => "nullable|image",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'country' => "required",
            'parent_id' => "nullable|string",
            'category_slug' => "nullable|string|max:255",
            'profit' => "nullable|numeric|gte:0",
            'sort_order' => "nullable|numeric|gte:0",
            'subtitle_en' => "nullable|string",
            'subtitle_ar' => "nullable|string",
            'vendor_profit' => "nullable|numeric|gte:0",
            'status' => "required|string",
        ]);

        $slug = createSlug($request->category_slug ? $request->category_slug : ($request->name_ar . '-' . $request->name_en));

        if ($request->hasFile('image')) {
            if ($category->media_id != null) {
                deleteImage($category->media_id);
            }
            $media_id = saveMedia('image', $request['image'], 'categories');
            $category->update([
                'media_id' => $media_id,
            ]);
        }


        $category->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'] ? $request['description_ar'] : ' ',
            'description_en' => $request['description_en'] ? $request['description_en'] : ' ',
            'media_id' => isset($media_id) ? $media_id : null,
            'country_id' => $request['country'],
            'parent_id' => isset($request['parent_id']) ? $request['parent_id'] : null,
            'profit' => $request['profit'] ? $request['profit'] : 0,
            'vendor_profit' => $request['vendor_profit'] ? $request['vendor_profit'] : 0,
            'category_slug' => $slug,
            'sort_order' => $request['sort_order'] ? $request['sort_order'] : 0,
            'created_by' => Auth::id(),
            'subtitle_ar' => $request['subtitle_ar'],
            'subtitle_en' => $request['subtitle_en'],
            'status' => $request['status'],
        ]);

        // foreach ($category->products as $product) {
        //     CalculateProductPrice($product);
        // }

        alertSuccess('Category updated successfully', 'تم تعديل القسم بنجاح');
        return redirect()->route('categories.index', ['parent_id' => $request->parent_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $category = Category::withTrashed()->where('id', $category)->first();
        if ($category->trashed() && auth()->user()->hasPermission('categories-delete')) {
            deleteImage($category->media_id);
            $category->forceDelete();
            alertSuccess('category deleted successfully', 'تم حذف القسم بنجاح');
            return redirect()->route('categories.trashed');
        } elseif (!$category->trashed() && auth()->user()->hasPermission('categories-trash') && checkCategoryForTrash($category)) {
            $category->delete();
            alertSuccess('category trashed successfully', 'تم حذف القسم مؤقتا');
            return redirect()->route('categories.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the category cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو القسم لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $countries = Country::all();
        $categories = Category::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.categories.index', ['categories' => $categories])->with('countries', $countries);
    }

    public function restore($category, Request $request)
    {
        $category = Category::withTrashed()->where('id', $category)->first()->restore();
        alertSuccess('Category restored successfully', 'تم استعادة القسم بنجاح');
        return redirect()->route('categories.index', ['parent_id' => $request->parent_id]);
    }
}
