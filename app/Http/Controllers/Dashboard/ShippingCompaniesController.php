<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:shipping_companies-read')->only('index', 'show');
        $this->middleware('permission:shipping_companies-create')->only('create', 'store');
        $this->middleware('permission:shipping_companies-update')->only('edit', 'update');
        $this->middleware('permission:shipping_companies-delete|shipping_companies-trash')->only('destroy', 'trashed');
        $this->middleware('permission:shipping_companies-restore')->only('restore');
    }

    public function index()
    {


        $shipping_companies = ShippingCompany::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.shipping_companies.index')->with('shipping_companies', $shipping_companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shipping_companies.create');
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
            'name_ar' => "required|string|max:255|unique:shipping_companies",
            'name_en' => "required|string|max:255|unique:shipping_companies",

        ]);


        $shipping_company = ShippingCompany::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);

        alertSuccess('shipping_company created successfully', 'تم إضافة شركة الشحنات بنجاح');
        return redirect()->route('shipping_companies.index');
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
    public function edit($shipping_company)
    {
        $shipping_company = ShippingCompany::findOrFail($shipping_company);
        return view('dashboard.shipping_companies.edit')->with('shipping_company', $shipping_company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingCompany $shipping_company)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:shipping_companies,name_ar," . $shipping_company->id,
            'name_en' => "required|string|max:255|unique:shipping_companies,name_en," . $shipping_company->id,
        ]);

        $shipping_company->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
        ]);

        alertSuccess('shipping_company updated successfully', 'تم تعديل شركة الشحن بنجاح');
        return redirect()->route('shipping_companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shipping_company)
    {
        $shipping_company = ShippingCompany::withTrashed()->where('id', $shipping_company)->first();
        if ($shipping_company->trashed() && auth()->user()->hasPermission('shipping_companies-delete')) {
            $shipping_company->forceDelete();
            alertSuccess('shipping_company deleted successfully', 'تم حذف شركة الشحن بنجاح');
            return redirect()->route('shipping_companies.trashed');
        } elseif (!$shipping_company->trashed() && auth()->user()->hasPermission('shipping_companies-trash') && checkShippingCompanyForTrash($shipping_company)) {
            $shipping_company->delete();
            alertSuccess('shipping_company trashed successfully', 'تم حذف شركة الشحن مؤقتا');
            return redirect()->route('shipping_companies.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the shipping_company cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو شركة الشحن لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $shipping_companies = ShippingCompany::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.shipping_companies.index', ['shipping_companies' => $shipping_companies]);
    }

    public function restore($shipping_company, Request $request)
    {
        $shipping_company = ShippingCompany::withTrashed()->where('id', $shipping_company)->first()->restore();
        alertSuccess('shipping_company restored successfully', 'تم استعادة شركة الشحن بنجاح');
        return redirect()->route('shipping_companies.index');
    }
}
