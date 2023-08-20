<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:cities-read')->only('index', 'show');
        $this->middleware('permission:cities-create')->only('create', 'store');
        $this->middleware('permission:cities-update')->only('edit', 'update');
        $this->middleware('permission:cities-delete|cities-trash')->only('destroy', 'trashed');
        $this->middleware('permission:cities-restore')->only('restore');
    }


    public function index()
    {
        $cities = City::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenState(request()->state_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();
        $states = State::all();
        return view('dashboard.cities.index', compact('countries', 'cities', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        return view('dashboard.cities.create', compact('countries', 'states'));
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
            'name_ar' => "required|string|max:255|unique:cities",
            'name_en' => "required|string|max:255|unique:cities",
            'country_id' => "required|string",
            'state_id' => "required|string",
            'status' => "required|string",
            'shipping_amount' => "required|string",
        ]);


        $city = City::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'],
        ]);

        alertSuccess('city created successfully', 'تم اضافة المدينة بنجاح');
        return redirect()->route('cities.index');
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
    public function edit($city)
    {
        $countries = Country::all();
        $city = City::findOrFail($city);
        $states = State::where('country_id', $city->country_id)->get();
        return view('dashboard.cities.edit ', compact('countries', 'city', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, city $city)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:cities,name_ar," . $city->id,
            'name_en' => "required|string|max:255|unique:cities,name_en," . $city->id,
            'country_id' => "required|string",
            'state_id' => "required|string",
            'status' => "required|string",
            'shipping_amount' => "required|string",
        ]);


        $city->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'],
        ]);


        alertSuccess('city updated successfully', 'تم تعديل المدينة بنجاح');
        return redirect()->route('cities.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($city)
    {
        $city = City::withTrashed()->where('id', $city)->first();
        if ($city->trashed() && auth()->user()->hasPermission('cities-delete')) {
            deleteImage($city->media_id);
            $city->forceDelete();
            alertSuccess('city deleted successfully', 'تم حذف المدينة بنجاح');
            return redirect()->route('cities.trashed');
        } elseif (!$city->trashed() && auth()->user()->hasPermission('cities-trash') && checkCityForTrash($city)) {
            $city->delete();
            alertSuccess('city trashed successfully', 'تم حذف المدينة مؤقتا');
            return redirect()->route('cities.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the city cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المدينة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $cities = City::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenState(request()->state_id)
            ->paginate(100);

        $states = State::all();
        $countries = Country::all();

        return view('dashboard.cities.index', compact('cities', 'states', 'countries'));
    }

    public function restore($city)
    {
        $city = City::withTrashed()->where('id', $city)->first()->restore();
        alertSuccess('city restored successfully', 'تم استعادة المدينة بنجاح');
        return redirect()->route('cities.index');
    }
}
