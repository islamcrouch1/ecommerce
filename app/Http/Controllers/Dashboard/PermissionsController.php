<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EmployeePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:employee_permissions-read')->only('index', 'show');
        $this->middleware('permission:employee_permissions-create')->only('create', 'store');
        $this->middleware('permission:employee_permissions-update')->only('edit', 'update');
        $this->middleware('permission:employee_permissions-delete|employee_permissions-trash')->only('destroy', 'trashed');
        $this->middleware('permission:employee_permissions-restore')->only('restore');
    }



    public function index()
    {
        $permissions = EmployeePermission::whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->whenType(request()->type)
            ->latest()
            ->paginate(100);


        return view('dashboard.permits.index', compact('permissions'));
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($permission)
    {
        $permission = EmployeePermission::findOrFail($permission);

        return view('dashboard.permits.edit ', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeePermission $permit)
    {

        $request->validate([
            'type' => "required|string",
            'date' => "required|string",
            'reason' => "required|string",
            'status' => "required|string",
            'media' => "nullable|image",
        ]);


        if ($request->hasFile('media')) {

            if ($permit->media_id != null) {
                deleteImage($permit->media_id);
            }

            $media_id = saveMedia('image', $request['media'], 'permissions');
        }


        $permit->update([
            'type' => $request['type'],
            'date' => $request['date'],
            'reason' => $request['reason'],
            'status' => $request['status'],
            'admin_id' => Auth::id(),
            'media_id' => isset($media_id) ? $media_id : $permit->media_id,
        ]);


        alertSuccess('permission updated successfully', 'تم تعديل الاذن بنجاح');
        return redirect()->route('permits.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($permission)
    {
        $permission = EmployeePermission::withTrashed()->where('id', $permission)->first();
        if ($permission->trashed() && auth()->user()->hasPermission('employee_permissions-delete')) {

            $permission->forceDelete();
            alertSuccess('permission deleted successfully', 'تم حذف الاذن بنجاح');
            return redirect()->route('permits.trashed');
        } elseif (!$permission->trashed() && auth()->user()->hasPermission('employee_permissions-trash')) {
            $permission->delete();
            alertSuccess('permission trashed successfully', 'تم حذف الاذن مؤقتا');
            return redirect()->route('permits.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the permission cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الفرع لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $permissions = EmployeePermission::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->whenType(request()->type)
            ->latest()
            ->paginate(100);
        return view('dashboard.permits.index', ['permissions' => $permissions]);
    }

    public function restore($permission)
    {
        $permission = EmployeePermission::withTrashed()->where('id', $permission)->first()->restore();
        alertSuccess('permission restored successfully', 'تم استعادة الاذن بنجاح');
        return redirect()->route('permits.index');
    }
}
