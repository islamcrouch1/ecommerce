<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\InstallmentCompany;
use Illuminate\Http\Request;

class InstallmentsCompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:installment_companies-read')->only('index', 'show');
        $this->middleware('permission:installment_companies-create')->only('create', 'store');
        $this->middleware('permission:installment_companies-update')->only('edit', 'update');
        $this->middleware('permission:installment_companies-delete|installment_companies-trash')->only('destroy', 'trashed');
        $this->middleware('permission:installment_companies-restore')->only('restore');
    }


    public function index()
    {
        $installment_companies = InstallmentCompany::whenSearch(request()->search)
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.installment_companies.index', compact('installment_companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.installment_companies.create');
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
            'name_ar' => "required|string|max:255|unique:installment_companies",
            'name_en' => "required|string|max:255|unique:installment_companies",
            'admin_expenses' => "required|numeric|gt:0",
            'amount' => "required|numeric|gt:0",
            'type' => "required|string",
            'months' => "nullable|array",
            'image' => "required|image",


        ]);

        $media_id = saveMedia('image', $request['image'], 'installment');
        $installment_company = InstallmentCompany::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'amount' => $request['amount'],
            'admin_expenses' => $request['admin_expenses'],
            'months' => serialize($request['months']),
            'type' => $request['type'],
            'media_id' => $media_id,

        ]);



        alertSuccess('installment company created successfully', 'تم اضافة شركة التقسيط بنجاح');
        return redirect()->route('installment_companies.index');
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
    public function edit($installment_company)
    {
        $installment_company = InstallmentCompany::findOrFail($installment_company);
        return view('dashboard.installment_companies.edit ', compact('installment_company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstallmentCompany $installment_company)
    {

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'admin_expenses' => "required|numeric|gt:0",
            'amount' => "required|numeric|gt:0",
            'type' => "required|string",
            'months' => "nullable|array",
            'image' => "nullable|image",


        ]);

        if ($request->hasFile('image')) {
            deleteImage($installment_company->media_id);
            $media_id = saveMedia('image', $request['image'], 'installment');
            $installment_company->update([
                'media_id' => $media_id,
            ]);
        }

        $installment_company->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'amount' => $request['amount'],
            'admin_expenses' => $request['admin_expenses'],
            'months' => serialize($request['months']),
            'type' => $request['type'],

        ]);

        alertSuccess('installment company updated successfully', 'تم تعديل شركة التقسيط بنجاح');
        return redirect()->route('installment_companies.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($installment_company)
    {
        $installment_company = InstallmentCompany::withTrashed()->where('id', $installment_company)->first();
        if ($installment_company->trashed() && auth()->user()->hasPermission('installment_companies-delete')) {

            $installment_company->forceDelete();
            alertSuccess('installment_company deleted successfully', 'تم حذف شركة التقسيط بنجاح');
            return redirect()->route('installment_companies.trashed');
        } elseif (!$installment_company->trashed() && auth()->user()->hasPermission('installment_companies-trash')) {
            $installment_company->delete();
            alertSuccess('installment_company trashed successfully', 'تم حذف شركة التقسيط مؤقتا');
            return redirect()->route('installment_companies.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the installment_company cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو شركة التقسيط لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $installment_companies = InstallmentCompany::onlyTrashed()
            ->whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.installment_companies.index', ['installment_companies' => $installment_companies]);
    }

    public function restore($installment_company)
    {
        $installment_company = InstallmentCompany::withTrashed()->where('id', $installment_company)->first()->restore();
        alertSuccess('installment_company restored successfully', 'تم استعادة شركة التقسيط بنجاح');
        return redirect()->route('installment_companies.index');
    }
}
