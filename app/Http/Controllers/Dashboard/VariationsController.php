<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Variation;
use Illuminate\Http\Request;

class VariationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:variations-read')->only('index', 'show');
        $this->middleware('permission:variations-create')->only('create', 'store');
        $this->middleware('permission:variations-update')->only('edit', 'update');
        $this->middleware('permission:variations-delete|variations-trash')->only('destroy', 'trashed');
        $this->middleware('permission:variations-restore')->only('restore');
    }

    public function index()
    {


        $variations = Variation::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.variations.index')->with('variations', $variations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::get();
        return view('dashboard.variations.create')->with('attributes', $attributes);
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
            'name_ar' => "required|string|max:255|unique:variations",
            'name_en' => "required|string|max:255|unique:variations",
            'attribute_id' => "required|string",
            'value' => "nullable|string",
        ]);

        $attribute = Attribute::findOrFail($request['attribute_id']);

        $variation = variation::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'attribute_id' => $request['attribute_id'],
            'value' => in_array($attribute->name_en, array('color', 'Color', 'colors', 'Colors'), true) ? $request['value'] : null,
        ]);

        alertSuccess('variation created successfully', 'تم إضافة متغير المنتجات بنجاح');
        return redirect()->route('variations.index');
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
    public function edit($variation)
    {
        $attributes = Attribute::get();
        $variation = variation::findOrFail($variation);
        return view('dashboard.variations.edit ')->with('variation', $variation)->with('attributes', $attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, variation $variation)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:variations,name_ar," . $variation->id,
            'name_en' => "required|string|max:255|unique:variations,name_en," . $variation->id,
            'value' => "nullable|string",
        ]);



        $variation->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'value' => in_array($variation->attribute->name_en, array('color', 'Color', 'colors', 'Colors'), true) ? $request['value'] : null,
        ]);

        // foreach ($variation->products as $product) {
        //     CalculateProductPrice($product);
        // }

        alertSuccess('variation updated successfully', 'تم تعديل متغير المنتجات بنجاح');
        return redirect()->route('variations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($variation)
    {
        $variation = variation::withTrashed()->where('id', $variation)->first();
        if ($variation->trashed() && auth()->user()->hasPermission('variations-delete')) {
            $variation->forceDelete();
            alertSuccess('variation deleted successfully', 'تم حذف متغير المنتجات بنجاح');
            return redirect()->route('variations.trashed');
        } elseif (!$variation->trashed() && auth()->user()->hasPermission('variations-trash') && checkvariationForTrash($variation)) {
            $variation->delete();
            alertSuccess('variation trashed successfully', 'تم حذف متغير المنتجات مؤقتا');
            return redirect()->route('variations.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the variation cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو متغير المنتجات لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $variations = variation::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.variations.index', ['variations' => $variations]);
    }

    public function restore($variation, Request $request)
    {
        $variation = variation::withTrashed()->where('id', $variation)->first()->restore();
        alertSuccess('variation restored successfully', 'تم استعادة متغير المنتجات بنجاح');
        return redirect()->route('variations.index');
    }
}
