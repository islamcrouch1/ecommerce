<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:sizes-read')->only('index', 'show');
        $this->middleware('permission:sizes-create')->only('create', 'store');
        $this->middleware('permission:sizes-update')->only('edit', 'update');
        $this->middleware('permission:sizes-delete|sizes-trash')->only('destroy', 'trashed');
        $this->middleware('permission:sizes-restore')->only('restore');
    }

    public function index()
    {
        $sizes = Size::whenSearch(request()->search)
            ->paginate(100);
        return view('Dashboard.sizes.index')->with('sizes', $sizes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Dashboard.sizes.create');
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
            'size_ar' => "required|string|max:255|unique:sizes",
            'size_en' => "required|string|max:255|unique:sizes",
        ]);

        $size = Size::create([
            'size_ar' => $request['size_ar'],
            'size_en' => $request['size_en'],
        ]);

        alertSuccess('size created successfully', 'تم إضافة المقاس بنجاح');
        return redirect()->route('sizes.index');
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
    public function edit($size)
    {
        $size = size::find($size);
        return view('Dashboard.sizes.edit ')->with('size', $size);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, size $size)
    {
        $request->validate([
            'size_ar' => "required|string|max:255|unique:sizes,size_ar," . $size->id,
            'size_en' => "required|string|max:255|unique:sizes,size_en," . $size->id,
        ]);

        $size->update([
            'size_ar' => $request['size_ar'],
            'size_en' => $request['size_en'],
        ]);

        alertSuccess('size updated successfully', 'تم تعديل المقاس بنجاح');
        return redirect()->route('sizes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($size)
    {
        $size = size::withTrashed()->where('id', $size)->first();
        if ($size->trashed() && auth()->user()->hasPermission('sizes-delete')) {
            $size->forceDelete();
            alertSuccess('size deleted successfully', 'تم حذف المقاس بنجاح');
            return redirect()->route('sizes.trashed');
        } elseif (!$size->trashed() && auth()->user()->hasPermission('sizes-trash') && checkSizeForTrash($size)) {
            $size->delete();
            alertSuccess('size trashed successfully', 'تم حذف المقاس مؤقتا');
            return redirect()->route('sizes.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the size cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المقاس لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $sizes = Size::onlyTrashed()->paginate(100);
        return view('Dashboard.sizes.index', ['sizes' => $sizes]);
    }

    public function restore($size)
    {
        $size = size::withTrashed()->where('id', $size)->first()->restore();
        alertSuccess('size restored successfully', 'تم استعادة المقاس بنجاح');
        return redirect()->route('sizes.index');
    }
}
