<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use PHPUnit\Framework\Constraint\Count;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:countries-read')->only('index', 'show');
        $this->middleware('permission:countries-create')->only('create', 'store');
        $this->middleware('permission:countries-update')->only('edit', 'update');
        $this->middleware('permission:countries-delete|countries-trash')->only('destroy', 'trashed');
        $this->middleware('permission:countries-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.countries.index')->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.countries.create');
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
            'name_ar' => "required|string|max:255|unique:countries",
            'name_en' => "required|string|max:255|unique:countries",
            'code' => "required|string",
            'phone_digits' => "required|integer",
            'currency' => "required|string",
            'media' => "required|image",
            'status' => "required|string",
            'is_default' => "nullable|string",
            'shipping_amount' => "required|string",
        ]);

        $media_id = saveMedia('image', $request['media'], 'countries');


        $country = Country::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'phone_digits' => $request['phone_digits'],
            'currency' => $request['currency'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'] == 'on' ? 'active' : $request['status'],
            'media_id' => $media_id,
            'is_default' => $request['is_default'] == 'on' ? '1' : '0',

        ]);


        $this->checkDefault($request['is_default'], $country->id);


        alertSuccess('Country created successfully', 'تم اضافة الدولة بنجاح');
        return redirect()->route('countries.index');
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
    public function edit($country)
    {
        $country = Country::findOrFail($country);
        return view('dashboard.countries.edit ')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:countries,name_ar," . $country->id,
            'name_en' => "required|string|max:255|unique:countries,name_en," . $country->id,
            'code' => "required|string",
            'phone_digits' => "required|integer",
            'currency' => "required|string",
            'media' => "nullable|image",
            'status' => "required|string",
            'is_default' => "nullable|string",
            'shipping_amount' => "required|string",
        ]);



        if ($request->hasFile('media')) {
            deleteImage($country->media_id);
            $media_id = saveMedia('image', $request['media'], 'countries');
        }


        $country->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'phone_digits' => $request['phone_digits'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'] == 'on' ? 'active' : $request['status'],
            'media_id' => isset($media_id) ? $media_id : $country->media_id,
            'is_default' => $request['is_default'] == 'on' ? '1' : '0',
        ]);


        $this->checkDefault($request['is_default'], $country->id);


        alertSuccess('Country updated successfully', 'تم تعديل الدولة بنجاح');
        return redirect()->route('countries.index');
    }


    private function checkDefault($is_default, $country_id)
    {

        $countries = Country::all();

        if ($is_default == 'on') {

            foreach ($countries as $scountry) {

                $scountry->update([
                    'is_default' => $scountry->id == $country_id ? '1' : '0'
                ]);
            }
        }

        $setting = Setting::where('type', 'country_id')->first();

        if ($setting == null) {

            Setting::create([
                'type' => 'country_id',
                'value' => $country_id,
            ]);
        } elseif ($setting->value != $country_id) {

            $setting->update([
                'value' => $country_id,
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($country)
    {
        $country = Country::withTrashed()->where('id', $country)->first();
        if ($country->trashed() && auth()->user()->hasPermission('countries-delete')) {
            deleteImage($country->media_id);
            $country->forceDelete();
            alertSuccess('country deleted successfully', 'تم حذف الدولة بنجاح');
            return redirect()->route('countries.trashed');
        } elseif (!$country->trashed() && auth()->user()->hasPermission('countries-trash') && checkCountryForTrash($country)) {
            $country->delete();
            alertSuccess('country trashed successfully', 'تم حذف الدولة مؤقتا');
            return redirect()->route('countries.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the country cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الدولة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $countries = Country::onlyTrashed()->paginate(100);
        return view('dashboard.countries.index', ['countries' => $countries]);
    }

    public function restore($country)
    {
        $country = Country::withTrashed()->where('id', $country)->first()->restore();
        alertSuccess('country restored successfully', 'تم استعادة الدولة بنجاح');
        return redirect()->route('countries.index');
    }
}
