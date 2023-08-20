<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:colors-read')->only('index', 'show');
        $this->middleware('permission:colors-create')->only('create', 'store');
        $this->middleware('permission:colors-update')->only('edit', 'update');
        $this->middleware('permission:colors-delete|colors-trash')->only('destroy', 'trashed');
        $this->middleware('permission:colors-restore')->only('restore');
    }

    public function index()
    {
        $colors = Color::whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.colors.index')->with('colors', $colors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.colors.create');
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
            'color_ar' => "required|string|max:255|unique:colors",
            'color_en' => "required|string|max:255|unique:colors",
            'hex' => "required|string|max:255|unique:colors",
        ]);

        $color = Color::create([
            'color_ar' => $request['color_ar'],
            'color_en' => $request['color_en'],
            'hex' => $request['hex'],
        ]);

        alertSuccess('color created successfully', 'تم إضافة اللون بنجاح');
        return redirect()->route('colors.index');
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
    public function edit($color)
    {
        $color = Color::find($color);
        return view('dashboard.colors.edit ')->with('color', $color);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'color_ar' => "required|string|max:255|unique:colors,color_ar," . $color->id,
            'color_en' => "required|string|max:255|unique:colors,color_en," . $color->id,
            'hex' => "required|string|max:255|unique:colors,hex," . $color->id,
        ]);

        $color->update([
            'color_ar' => $request['color_ar'],
            'color_en' => $request['color_en'],
            'hex' => $request['hex'],
        ]);

        alertSuccess('color updated successfully', 'تم تعديل اللون بنجاح');
        return redirect()->route('colors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($color)
    {
        $color = Color::withTrashed()->where('id', $color)->first();
        if ($color->trashed() && auth()->user()->hasPermission('colors-delete')) {
            $color->forceDelete();
            alertSuccess('color deleted successfully', 'تم حذف اللون بنجاح');
            return redirect()->route('colors.trashed');
        } elseif (!$color->trashed() && auth()->user()->hasPermission('colors-trash') && checkColorForTrash($color)) {
            $color->delete();
            alertSuccess('color trashed successfully', 'تم حذف اللون مؤقتا');
            return redirect()->route('colors.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the color cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو اللون لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $colors = Color::onlyTrashed()->paginate(100);
        return view('dashboard.colors.index', ['colors' => $colors]);
    }

    public function restore($color)
    {
        $color = Color::withTrashed()->where('id', $color)->first()->restore();
        alertSuccess('color restored successfully', 'تم إستعادة اللون بنجاح');
        return redirect()->route('colors.index', app()->getLocale());
    }
}
