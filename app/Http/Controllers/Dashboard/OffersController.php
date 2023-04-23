<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Offer;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:offers-read')->only('index', 'show');
        $this->middleware('permission:offers-create')->only('create', 'store');
        $this->middleware('permission:offers-update')->only('edit', 'update');
        $this->middleware('permission:offers-delete|offers-trash')->only('destroy', 'trashed');
        $this->middleware('permission:offers-restore')->only('restore');
    }


    public function index()
    {
        $offers = Offer::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();
        return view('dashboard.offers.index', compact('countries', 'offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.offers.create', compact('countries'));
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
            'name_ar' => "required|string|max:255|unique:offers",
            'name_en' => "required|string|max:255|unique:offers",
            'country_id' => "required|string",
            'ended_at' => "required|string",
            'products' => "nullable|array",
            'categories' => "nullable|array",
        ]);

        $date = $request['ended_at'];

        $offer = Offer::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'products' => serialize($request['products']),
            'categories' => serialize($request['categories']),
            'ended_at' => $date,
        ]);

        alertSuccess('offer created successfully', 'تم اضافة العرض بنجاح');
        return redirect()->route('offers.index');
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
    public function edit($offer)
    {
        $countries = Country::all();
        $offer = offer::findOrFail($offer);
        return view('dashboard.offers.edit ', compact('countries', 'offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:offers,name_ar," . $offer->id,
            'name_en' => "required|string|max:255|unique:offers,name_en," . $offer->id,
            'country_id' => "required|string",
            'ended_at' => "required|string",
            'products' => "nullable|array",
            'categories' => "nullable|array",
        ]);


        $offer->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'products' => serialize($request['products']),
            'categories' => serialize($request['categories']),
            'ended_at' => $request['ended_at'],
        ]);


        alertSuccess('offer updated successfully', 'تم تعديل العرض بنجاح');
        return redirect()->route('offers.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($offer)
    {
        $offer = Offer::withTrashed()->where('id', $offer)->first();
        if ($offer->trashed() && auth()->user()->hasPermission('offers-delete')) {
            $offer->forceDelete();
            alertSuccess('offer deleted successfully', 'تم حذف العرض بنجاح');
            return redirect()->route('offers.trashed');
        } elseif (!$offer->trashed() && auth()->user()->hasPermission('offers-trash')) {
            $offer->delete();
            alertSuccess('offer trashed successfully', 'تم حذف العرض مؤقتا');
            return redirect()->route('offers.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the offer cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو العرض لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $offers = Offer::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);

        $countries = Country::all();

        return view('dashboard.offers.index', compact('offers', 'countries'));
    }

    public function restore($offer)
    {
        $offer = Offer::withTrashed()->where('id', $offer)->first()->restore();
        alertSuccess('offer restored successfully', 'تم استعادة العرض بنجاح');
        return redirect()->route('offers.index');
    }
}
