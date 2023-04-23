<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:testimonials-read')->only('index', 'show');
        $this->middleware('permission:testimonials-create')->only('create', 'store');
        $this->middleware('permission:testimonials-update')->only('edit', 'update');
        $this->middleware('permission:testimonials-delete|testimonials-trash')->only('destroy', 'trashed');
        $this->middleware('permission:testimonials-restore')->only('restore');
    }


    public function index()
    {
        $testimonials = Testimonial::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();
        return view('dashboard.testimonials.index', compact('countries', 'testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.testimonials.create', compact('countries'));
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
            'name_ar' => "required|string|max:255|unique:testimonials",
            'name_en' => "required|string|max:255|unique:testimonials",
            'country_id' => "required|string",
            'title_ar' => "nullable|string|max:255",
            'title_en' => "nullable|string|max:255",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'media' => "required|image",
            'rating' => "required|integer|lt:6|gt:0",
        ]);

        $media_id = saveMedia('image', $request['media'], 'testimonials');

        $testimonial = Testimonial::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'title_ar' => $request['title_ar'],
            'title_en' => $request['title_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'rating' => $request['rating'],
            'media_id' => $media_id,
        ]);

        alertSuccess('testimonial created successfully', 'تم اضافة راي العميل بنجاح');
        return redirect()->route('testimonials.index');
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
    public function edit($testimonial)
    {
        $countries = Country::all();
        $testimonial = Testimonial::findOrFail($testimonial);
        return view('dashboard.testimonials.edit ', compact('countries', 'testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, testimonial $testimonial)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:testimonials,name_ar," . $testimonial->id,
            'name_en' => "required|string|max:255|unique:testimonials,name_en," . $testimonial->id,
            'country_id' => "required|string",
            'title_ar' => "nullable|string|max:255",
            'title_en' => "nullable|string|max:255",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'media' => "nullable|image",
            'rating' => "required|integer|lt:6|gt:0",
        ]);

        if ($request->hasFile('media')) {
            deleteImage($testimonial->media_id);
            $media_id = saveMedia('image', $request['media'], 'testimonials');
        }


        $testimonial->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'title_ar' => $request['title_ar'],
            'title_en' => $request['title_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'rating' => $request['rating'],
            'media_id' => isset($media_id) ? $media_id : $testimonial->media_id,

        ]);


        alertSuccess('testimonial updated successfully', 'تم تعديل راي العميل بنجاح');
        return redirect()->route('testimonials.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($testimonial)
    {
        $testimonial = Testimonial::withTrashed()->where('id', $testimonial)->first();
        if ($testimonial->trashed() && auth()->user()->hasPermission('testimonials-delete')) {
            deleteImage($testimonial->media_id);
            $testimonial->forceDelete();
            alertSuccess('testimonial deleted successfully', 'تم حذف راي العميل بنجاح');
            return redirect()->route('testimonials.trashed');
        } elseif (!$testimonial->trashed() && auth()->user()->hasPermission('testimonials-trash')) {
            $testimonial->delete();
            alertSuccess('testimonial trashed successfully', 'تم حذف راي العميل مؤقتا');
            return redirect()->route('testimonials.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the testimonial cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو راي العميل لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $testimonials = Testimonial::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);

        $countries = Country::all();

        return view('dashboard.testimonials.index', compact('testimonials', 'countries'));
    }

    public function restore($testimonial)
    {
        $testimonial = Testimonial::withTrashed()->where('id', $testimonial)->first()->restore();
        alertSuccess('testimonial restored successfully', 'تم استعادة راي العميل بنجاح');
        return redirect()->route('testimonials.index');
    }
}
