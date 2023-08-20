<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{

    public function index()
    {
        $permissions = EmployeePermission::where('user_id', Auth::id())
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->whenType(request()->type)
            ->latest()
            ->paginate(100);


        return view('dashboard.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.permissions.create');
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
            'type' => "required|string",
            'date' => "required|string",
            'reason' => "required|string",
            'media' => "nullable|image",
        ]);



        if ($request->hasFile('media')) {
            $media_id = saveMedia('image', $request['media'], 'permissions');
        }

        $permission = EmployeePermission::create([
            'type' => $request['type'],
            'date' => $request['date'],
            'reason' => $request['reason'],
            'user_id' => Auth::id(),
            'media_id' => isset($media_id) ? $media_id : null,
        ]);


        alertSuccess('permission created successfully', 'تم اضافة الاذن بنجاح');
        return redirect()->route('permissions.index');
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
    public function edit($permission)
    {
        $permission = EmployeePermission::findOrFail($permission);

        return view('dashboard.permissions.edit ', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeePermission $permission)
    {

        $request->validate([
            'type' => "required|string",
            'date' => "required|string",
            'reason' => "required|string",
            'media' => "nullable|image",
        ]);


        if ($request->hasFile('media')) {

            if ($permission->media_id != null) {
                deleteImage($permission->media_id);
            }

            $media_id = saveMedia('image', $request['media'], 'permissions');
        }


        $permission->update([
            'type' => $request['type'],
            'date' => $request['date'],
            'reason' => $request['reason'],
            'media_id' => isset($media_id) ? $media_id : $permission->media_id,
        ]);


        alertSuccess('permission updated successfully', 'تم تعديل الاذن بنجاح');
        return redirect()->route('permissions.index');
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
        if ($permission->trashed() && auth()->user()->hasPermission('permissions-delete')) {

            $permission->forceDelete();
            alertSuccess('permission deleted successfully', 'تم حذف الاذن بنجاح');
            return redirect()->route('permissions.trashed');
        } elseif (!$permission->trashed() && auth()->user()->hasPermission('permissions-trash')) {
            $permission->delete();
            alertSuccess('permission trashed successfully', 'تم حذف الاذن مؤقتا');
            return redirect()->route('permissions.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the permission cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الفرع لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $permissions = EmployeePermission::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('dashboard.permissions.index', ['permissions' => $permissions]);
    }

    public function restore($permission)
    {
        $permission = EmployeePermission::withTrashed()->where('id', $permission)->first()->restore();
        alertSuccess('permission restored successfully', 'تم استعادة الاذن بنجاح');
        return redirect()->route('permissions.index');
    }
}
