<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:brands-read')->only('index', 'show');
        $this->middleware('permission:brands-create')->only('create', 'store');
        $this->middleware('permission:brands-update')->only('edit', 'update');
        $this->middleware('permission:brands-delete|brands-trash')->only('destroy', 'trashed');
        $this->middleware('permission:brands-restore')->only('restore');
    }

    public function index()
    {


        $brands = Brand::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);

        $countries = Country::all();

        return view('dashboard.brands.index')->with('brands', $brands)->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.brands.create')->with('countries', $countries);
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
            'name_ar' => "required|string|max:255|unique:brands",
            'name_en' => "required|string|max:255|unique:brands",
            'image' => "required|image",
            'country' => "required",
            'brand_slug' => "nullable|string|max:255",
            'sort_order' => "nullable|numeric",
        ]);

        $media_id = saveMedia('image', $request['image'], 'brands');

        $brand = Brand::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'media_id' => $media_id,
            'country_id' => $request['country'],
            'brand_slug' => createSlug($request['brand_slug']),
            'sort_order' => $request['sort_order'],
            'created_by' => Auth::id(),
            'status' => $request['status'] == 'on' ? 'active' : 'inactive',

        ]);

        alertSuccess('brand created successfully', 'تم إضافة العلامة التجارية بنجاح');
        return redirect()->route('brands.index');
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
    public function edit($brand)
    {
        $countries = Country::all();
        $brand = brand::findOrFail($brand);
        return view('dashboard.brands.edit ')->with('brand', $brand)->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, brand $brand)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:brands,name_ar," . $brand->id,
            'name_en' => "required|string|max:255|unique:brands,name_en," . $brand->id,
            'image' => "image",
            'country' => "required",
            'brand_slug' => "nullable|string|max:255",
            'sort_order' => "nullable|numeric",
        ]);

        if ($request->hasFile('image')) {
            deleteImage($brand->media_id);
            $media_id = saveMedia('image', $request['image'], 'brands');
            $brand->update([
                'media_id' => $media_id,
            ]);
        }

        $brand->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country'],
            'brand_slug' => createSlug($request['brand_slug']),
            'sort_order' => $request['sort_order'],
            'updated_by' => Auth::id(),
            'status' => $request['status'] == 'on' ? 'active' : 'inactive',
        ]);

        alertSuccess('brand updated successfully', 'تم تعديل العلامة اتجارية بنجاح');
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($brand)
    {
        $brand = Brand::withTrashed()->where('id', $brand)->first();
        if ($brand->trashed() && auth()->user()->hasPermission('brands-delete')) {
            deleteImage($brand->media_id);
            $brand->forceDelete();
            alertSuccess('brand deleted successfully', 'تم حذف العلامة التجارية بنجاح');
            return redirect()->route('brands.trashed');
        } elseif (!$brand->trashed() && auth()->user()->hasPermission('brands-trash') && checkbrandForTrash($brand)) {
            $brand->delete();
            alertSuccess('brand trashed successfully', 'تم حذف العلامة التجارية مؤقتا');
            return redirect()->route('brands.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the brand cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو العلامة التجارية لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {
        $countries = Country::all();
        $brands = Brand::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.brands.index', ['brands' => $brands])->with('countries', $countries);
    }

    public function restore($brand, Request $request)
    {
        $brand = Brand::withTrashed()->where('id', $brand)->first()->restore();
        alertSuccess('brand restored successfully', 'تم استعادة العلامة التجارية بنجاح');
        return redirect()->route('brands.index');
    }
}
