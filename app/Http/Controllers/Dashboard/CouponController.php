<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:coupons-read')->only('index', 'show');
        $this->middleware('permission:coupons-create')->only('create', 'store');
        $this->middleware('permission:coupons-update')->only('edit', 'update');
        $this->middleware('permission:coupons-delete|coupons-trash')->only('destroy', 'trashed');
        $this->middleware('permission:coupons-restore')->only('restore');
    }


    public function index()
    {
        $coupons = Coupon::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();
        return view('dashboard.coupons.index', compact('countries', 'coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.coupons.create', compact('countries'));
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
            'code' => "required|string|max:255|unique:coupons",
            'country_id' => "required|string",
            'type' => "required|string",
            'amount' => "required|numeric|gt:0",
            'max_value' => "required|numeric|gt:0",
            'ended_at' => "required|string",
            'frequency' => "required|integer|gt:0",
        ]);

        $date = $request['ended_at'];
        $coupon = coupon::create([
            'code' => $request['code'],
            'country_id' => $request['country_id'],
            'type' => $request['type'],
            'amount' => $request['amount'],
            'max_value' => $request['max_value'],
            'frequency' => $request['frequency'],
            'ended_at' => $date,
        ]);

        alertSuccess('coupon created successfully', 'تم اضافة الكوبون بنجاح');
        return redirect()->route('coupons.index');
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
    public function edit($coupon)
    {
        $countries = Country::all();
        $coupon = coupon::findOrFail($coupon);
        return view('dashboard.coupons.edit ', compact('countries', 'coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, coupon $coupon)
    {

        $request->validate([
            'code' => "required|string|max:255|unique:coupons,code," . $coupon->id,
            'country_id' => "required|string",
            'type' => "required|string",
            'amount' => "required|numeric|gt:0",
            'max_value' => "required|numeric|gt:0",
            'ended_at' => "required|string",
            'frequency' => "required|integer|gt:0",
        ]);


        $coupon->update([
            'code' => $request['code'],
            'country_id' => $request['country_id'],
            'type' => $request['type'],
            'amount' => $request['amount'],
            'max_value' => $request['max_value'],
            'frequency' => $request['frequency'],
            'ended_at' => $request['ended_at'],
        ]);


        alertSuccess('coupon updated successfully', 'تم تعديل الكوبون بنجاح');
        return redirect()->route('coupons.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($coupon)
    {
        $coupon = coupon::withTrashed()->where('id', $coupon)->first();
        if ($coupon->trashed() && auth()->user()->hasPermission('coupons-delete')) {
            $coupon->forceDelete();
            alertSuccess('coupon deleted successfully', 'تم حذف الكوبون بنجاح');
            return redirect()->route('coupons.trashed');
        } elseif (!$coupon->trashed() && auth()->user()->hasPermission('coupons-trash')) {
            $coupon->delete();
            alertSuccess('coupon trashed successfully', 'تم حذف الكوبون مؤقتا');
            return redirect()->route('coupons.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the coupon cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الكوبون لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $coupons = coupon::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);

        $countries = Country::all();

        return view('dashboard.coupons.index', compact('coupons', 'countries'));
    }

    public function restore($coupon)
    {
        $coupon = coupon::withTrashed()->where('id', $coupon)->first()->restore();
        alertSuccess('coupon restored successfully', 'تم استعادة الكوبون بنجاح');
        return redirect()->route('coupons.index');
    }
}
