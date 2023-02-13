<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:taxes-read')->only('index', 'show');
        $this->middleware('permission:taxes-create')->only('create', 'store');
        $this->middleware('permission:taxes-update')->only('edit', 'update');
        $this->middleware('permission:taxes-delete|taxes-trash')->only('destroy', 'trashed');
        $this->middleware('permission:taxes-restore')->only('restore');
    }

    public function index()
    {

        $taxes = Tax::whenSearch(request()->search)
            ->latest()
            ->paginate(100);

        return view('dashboard.taxes.index')->with('taxes', $taxes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.taxes.create');
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
            'name' => "required|string|max:255",
            'description' => "required|string|max:255",
            'tax_rate' => "required|numeric",
        ]);



        $tax = tax::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'tax_rate' => $request['tax_rate'],
            'created_by' => Auth::id(),
        ]);

        alertSuccess('tax created successfully', 'تم إضافة الضريبه بنجاح');
        return redirect()->route('taxes.index');
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
    public function edit($tax)
    {
        $tax = tax::findOrFail($tax);
        return view('dashboard.taxes.edit ')->with('tax', $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'name' => "required|string|max:255",
            'description' => "required|string|max:255",
            'tax_rate' => "required|numeric",
        ]);

        $tax->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'tax_rate' => $request['tax_rate'],
            'updated_by' => Auth::id(),
        ]);

        alertSuccess('tax updated successfully', 'تم تعديل الضريبه بنجاح');
        return redirect()->route('taxes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tax)
    {
        $tax = Tax::withTrashed()->where('id', $tax)->first();
        if ($tax->trashed() && auth()->user()->hasPermission('taxes-delete')) {
            $tax->forceDelete();
            alertSuccess('tax deleted successfully', 'تم حذف الضريبه بنجاح');
            return redirect()->route('taxes.trashed');
        } elseif (!$tax->trashed() && auth()->user()->hasPermission('taxes-trash') && checktaxForTrash($tax)) {
            $tax->delete();
            alertSuccess('tax trashed successfully', 'تم حذف الضريبه مؤقتا');
            return redirect()->route('taxes.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the tax cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الضريبه لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {
        $taxes = Tax::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.taxes.index', ['taxes' => $taxes]);
    }

    public function restore($tax, Request $request)
    {
        $tax = Tax::withTrashed()->where('id', $tax)->first()->restore();
        alertSuccess('tax restored successfully', 'تم استعادة الضريبه بنجاح');
        return redirect()->route('taxes.index');
    }
}
