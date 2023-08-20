<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:branches-read')->only('index', 'show');
        $this->middleware('permission:branches-create')->only('create', 'store');
        $this->middleware('permission:branches-update')->only('edit', 'update');
        $this->middleware('permission:branches-delete|branches-trash')->only('destroy', 'trashed');
        $this->middleware('permission:branches-restore')->only('restore');
    }


    public function index()
    {
        $branches = Branch::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();


        return view('dashboard.branches.index', compact('countries', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $warehouses = Warehouse::where('branch_id', null)
            ->where('vendor_id', null)->get();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
        })->where('branch_id', null)
            ->get();

        return view('dashboard.branches.create', compact('countries', 'warehouses', 'users'));
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
            'name_ar' => "required|string|max:255|unique:branches",
            'name_en' => "required|string|max:255|unique:branches",
            'country_id' => "required|string",
            'phone' => "nullable|string",
            'email' => "nullable|string",
            'address' => "nullable|string",
            'status' => "required|string",
            'users' => "required|array",
            'warehouses' => "required|array",
        ]);


        $branch = Branch::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'email' => $request['email'],
            'status' => $request['status'],
        ]);


        // $branch->users()->attach($request['users']);
        // $branch->warehouses()->attach($request['warehouses']);


        foreach ($request['warehouses'] as $warehouse) {
            $warehouse = Warehouse::findOrFail($warehouse);
            if ($warehouse->branch_id == null) {
                $warehouse->update([
                    'branch_id' => $branch->id,
                ]);
            }
        }

        foreach ($request['users'] as $user) {
            $user = User::findOrFail($user);
            if ($user->hasRole('administrator|superadministrator') && $user->branch_id == null) {
                $user->update([
                    'branch_id' => $branch->id,
                ]);

                $employee_info = getEmployeeInfo($user);
                $employee_info->update([
                    'branch_id' => $branch->id,
                ]);
            }
        }


        alertSuccess('branch created successfully', 'تم اضافة الفرع بنجاح');
        return redirect()->route('branches.index');
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
    public function edit($branch)
    {
        $countries = Country::all();
        $branch = Branch::findOrFail($branch);

        $warehouses = Warehouse::where('branch_id', null)
            ->where('vendor_id', null)->get();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name',  'superadministrator')
                ->orwhere('name', 'administrator');
        })->where('branch_id', null)
            ->get();
        return view('dashboard.branches.edit ', compact('countries', 'branch', 'warehouses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:branches,name_ar," . $branch->id,
            'name_en' => "required|string|max:255|unique:branches,name_en," . $branch->id,
            'country_id' => "required|string",
            'phone' => "nullable|string",
            'email' => "nullable|string",
            'address' => "nullable|string",
            'status' => "required|string",
            'users' => "nullable|array",
            'warehouses' => "nullable|array",
        ]);


        $branch->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'email' => $request['email'],
            'status' => $request['status'],
        ]);


        // $branch->users()->detach();
        // $branch->users()->attach($request['users']);

        // $branch->warehouses()->detach();
        // $branch->warehouses()->attach($request['warehouses']);


        foreach ($branch->warehouses as $warehouse) {
            if ($warehouse->stocks->count() == 0) {
                $warehouse->update([
                    'branch_id' => null,
                ]);
            }
        }

        foreach ($branch->users as $user) {
            $user->update([
                'branch_id' => null,
            ]);
        }

        foreach ($request['warehouses'] as $warehouse) {
            $warehouse = Warehouse::findOrFail($warehouse);
            if ($warehouse->branch_id == null) {
                $warehouse->update([
                    'branch_id' => $branch->id,
                ]);
            }
        }


        foreach ($request['users'] as $user) {
            $user = User::findOrFail($user);
            if ($user->hasRole('administrator|superadministrator') && $user->branch_id == null) {
                $user->update([
                    'branch_id' => $branch->id,
                ]);
            }
        }


        alertSuccess('branch updated successfully', 'تم تعديل الفرع بنجاح');
        return redirect()->route('branches.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($branch)
    {
        $branch = Branch::withTrashed()->where('id', $branch)->first();
        if ($branch->trashed() && auth()->user()->hasPermission('branches-delete')) {

            $branch->forceDelete();
            alertSuccess('branch deleted successfully', 'تم حذف الفرع بنجاح');
            return redirect()->route('branches.trashed');
        } elseif (!$branch->trashed() && auth()->user()->hasPermission('branches-trash') && checkBranchForTrash($branch)) {
            $branch->delete();
            alertSuccess('branch trashed successfully', 'تم حذف الفرع مؤقتا');
            return redirect()->route('branches.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the branch cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الفرع لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $branches = Branch::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('dashboard.branches.index', ['branches' => $branches]);
    }

    public function restore($branch)
    {
        $branch = Branch::withTrashed()->where('id', $branch)->first()->restore();
        alertSuccess('branch restored successfully', 'تم استعادة الفرع بنجاح');
        return redirect()->route('branches.index');
    }
}
