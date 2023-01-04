<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator|affiliate');
        $this->middleware('permission:shipping_rates-read')->only('index', 'show');
        $this->middleware('permission:shipping_rates-create')->only('create', 'store');
        $this->middleware('permission:shipping_rates-update')->only('edit', 'update');
        $this->middleware('permission:shipping_rates-delete|shipping_rates-trash')->only('destroy', 'trashed');
        $this->middleware('permission:shipping_rates-restore')->only('restore');
    }

    public function index()
    {
        $shipping_rates = ShippingRate::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('Dashboard.shipping_rates.index')->with('shipping_rates', $shipping_rates);
    }


    public function affiliate()
    {
        $shipping_rates = ShippingRate::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('Dashboard.shipping_rates.affiliate')->with('shipping_rates', $shipping_rates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('Dashboard.shipping_rates.create')->with('countries', $countries);
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
            'city_ar' => "required|string|max:255|unique:shipping_rates",
            'city_en' => "required|string|max:255|unique:shipping_rates",
            'cost' => "required|numeric",
            'country' => "required|string",
        ]);

        $shipping_rate = ShippingRate::create([
            'city_ar' => $request['city_ar'],
            'city_en' => $request['city_en'],
            'cost' => $request['cost'],
            'country_id' => $request['country'],
        ]);

        alertSuccess('shipping rate created successfully', 'تم إضافة سعر الشحن بنجاح');
        return redirect()->route('shipping_rates.index');
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
    public function edit($shipping_rate)
    {
        $countries = Country::all();
        $shipping_rate = ShippingRate::findORFail($shipping_rate);
        return view('Dashboard.shipping_rates.edit ')->with('shipping_rate', $shipping_rate)->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingRate $shipping_rate)
    {
        $request->validate([
            'city_ar' => "required|string|max:255|unique:shipping_rates,city_ar," . $shipping_rate->id,
            'city_en' => "required|string|max:255|unique:shipping_rates,city_en," . $shipping_rate->id,
            'cost' => "required|numeric",
            'country' => "required|string",
        ]);

        $shipping_rate->update([
            'city_ar' => $request['city_ar'],
            'city_en' => $request['city_en'],
            'cost' => $request['cost'],
            'country_id' => $request['country'],
        ]);

        alertSuccess('shipping rate updated successfully', 'تم تعديل سعر الشحن بنجاح');
        return redirect()->route('shipping_rates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shipping_rate)
    {
        $shipping_rate = ShippingRate::withTrashed()->where('id', $shipping_rate)->first();
        if ($shipping_rate->trashed() && auth()->user()->hasPermission('shipping_rates-delete')) {
            $shipping_rate->forceDelete();
            alertSuccess('shipping rate deleted successfully', 'تم حذف سعر الشحن بنجاح');
            return redirect()->route('shipping_rates.trashed');
        } elseif (!$shipping_rate->trashed() && auth()->user()->hasPermission('shipping_rates-trash') && checkShippingRateForTrash($shipping_rate)) {
            $shipping_rate->delete();
            alertSuccess('shipping rate trashed successfully', 'تم حذف سعر الشحن مؤقتا');
            return redirect()->route('shipping_rates.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the shipping rate cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو سعر الشحن لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $shipping_rates = ShippingRate::onlyTrashed()->paginate(100);
        return view('Dashboard.shipping_rates.index', ['shipping_rates' => $shipping_rates]);
    }

    public function restore($shipping_rate)
    {
        $shipping_rate = ShippingRate::withTrashed()->where('id', $shipping_rate)->first()->restore();
        alertSuccess('shipping_rate restored successfully', 'تم إستعادة سعر الشحن بنجاح');
        return redirect()->route('shipping_rates.index');
    }
}
