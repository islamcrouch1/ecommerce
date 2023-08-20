<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class SlidesController extends Controller
{
    public function index()
    {
        $slides = Slide::whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.slides.index')->with('slides', $slides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.slides.create');
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
            'slider_id' => "required|numeric",
            'url' => "required|string",
            'image' => "required|image",
            'sort_order' => "nullable|string",
            'text_1_ar' => "nullable|string",
            'text_1_en' => "nullable|string",
            'text_2_ar' => "nullable|string",
            'text_2_en' => "nullable|string",
            'button_text_ar' => "nullable|string",
            'button_text_en' => "nullable|string",

        ]);



        $media_id = saveMedia('image', $request['image'], 'slides');


        $slide = Slide::create([
            'slider_id' => $request['slider_id'],
            'url' => $request['url'],
            'media_id' => $media_id,
            'sort_order' => $request['sort_order'],
            'text_1_ar' => $request['text_1_ar'],
            'text_1_en' => $request['text_1_en'],
            'text_2_ar' => $request['text_2_ar'],
            'text_2_en' => $request['text_2_en'],
            'button_text_ar' => $request['button_text_ar'],
            'button_text_en' => $request['button_text_en'],
        ]);

        alertSuccess('slide created successfully', 'تم إضافة الصورة بنجاح');
        return redirect()->route('slides.index');
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
    public function edit($slide)
    {
        $slide = Slide::find($slide);
        return view('dashboard.slides.edit ')->with('slide', $slide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, slide $slide)
    {
        $request->validate([
            'slider_id' => "string",
            'url' => "string",
            'image' => "image",
            'sort_order' => "nullable|string",
            'text_1_ar' => "nullable|string",
            'text_1_en' => "nullable|string",
            'text_2_ar' => "nullable|string",
            'text_2_en' => "nullable|string",
            'button_text_ar' => "nullable|string",
            'button_text_en' => "nullable|string",
        ]);

        if ($request->hasFile('image')) {
            deleteImage($slide->media_id);
            $media_id = saveMedia('image', $request['image'], 'slides');
            $slide->update([
                'media_id' => $media_id,
            ]);
        }

        $slide->update([
            'slider_id' => $request['slider_id'],
            'url' => $request['url'],
            'sort_order' => $request['sort_order'],
            'text_1_ar' => $request['text_1_ar'],
            'text_1_en' => $request['text_1_en'],
            'text_2_ar' => $request['text_2_ar'],
            'text_2_en' => $request['text_2_en'],
            'button_text_ar' => $request['button_text_ar'],
            'button_text_en' => $request['button_text_en'],
        ]);

        alertSuccess('slide updated successfully', 'تم تحديث الصورة بنجاح');
        return redirect()->route('slides.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slide)
    {
        $slide = Slide::withTrashed()->where('id', $slide)->first();
        if ($slide->trashed() && auth()->user()->hasPermission('slides-delete')) {
            deleteImage($slide->media_id);
            $slide->forceDelete();
            alertSuccess('slide deleted successfully', 'تم حذف الصورة بنجاح');
            return redirect()->route('slides.trashed');
        } elseif (!$slide->trashed() && auth()->user()->hasPermission('slides-trash')) {
            $slide->delete();
            alertSuccess('slide trashed successfully', 'تم حذف الصورة مؤقتا');
            return redirect()->route('slides.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the slide cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الصورة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $slides = Slide::onlyTrashed()->paginate(100);
        return view('dashboard.slides.index', ['slides' => $slides]);
    }

    public function restore($slide)
    {
        $slide = Slide::withTrashed()->where('id', $slide)->first()->restore();
        alertSuccess('slide restored successfully', 'تم استعادة الصورة بنجاح');
        return redirect()->route('slides.index');
    }
}
