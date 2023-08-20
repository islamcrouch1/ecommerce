<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediasController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:medias-read')->only('index', 'show');
        $this->middleware('permission:medias-create')->only('create', 'store');
        $this->middleware('permission:medias-update')->only('edit', 'update');
        $this->middleware('permission:medias-delete|medias-trash')->only('destroy', 'trashed');
        $this->middleware('permission:medias-restore')->only('restore');
    }

    public function index()
    {
        $medias = Media::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.medias.index')->with('medias', $medias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.medias.create');
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
            'images' => "required|array|max:15",
        ]);

        $media = [];
        $text = '';


        if ($files = $request->file('images')) {
            foreach ($files as $index => $file) {
                $media_id = saveMedia('image', $file, 'products');
                $media[$index] = $media_id;
            }
        }

        foreach ($media as $index => $m) {
            $image = Media::findOrFail($m);
            $path = asset($image->path);
            $text .= $path . ',';
        }


        alertSuccess('media created successfully' . ' - ' . $text, 'تم إضافة الوسائط بنجاح - روابط الميديا - ' . ' ' . $text);
        return redirect()->route('medias.index', compact('media'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($media)
    {
        $countries = Country::all();
        $media = media::findOrFail($media);
        return view('dashboard.medias.edit ')->with('media', $media)->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, media $media)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:medias,name_ar," . $media->id,
            'name_en' => "required|string|max:255|unique:medias,name_en," . $media->id,
            'image' => "image",
            'country' => "required",
            'media_slug' => "nullable|string|max:255",
            'sort_order' => "nullable|numeric",
        ]);

        if ($request->hasFile('image')) {
            deleteImage($media->media_id);
            $media_id = saveMedia('image', $request['image'], 'medias');
            $media->update([
                'media_id' => $media_id,
            ]);
        }

        $media->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country'],
            'media_slug' => createSlug($request['media_slug']),
            'sort_order' => $request['sort_order'],
            'updated_by' => Auth::id(),
            'status' => $request['status'] == 'on' ? 'active' : 'inactive',
        ]);

        alertSuccess('media updated successfully', 'تم تعديل العلامة اتجارية بنجاح');
        return redirect()->route('medias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {

        if (auth()->user()->hasPermission('medias-delete') && deleteImage($media->id)) {
            alertSuccess('media deleted successfully', 'تم حذف الوسائط بنجاح');
            return redirect()->route('medias.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the media cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الوسائط لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }
}
