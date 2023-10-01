<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:exchange_rates-read')->only('index', 'show');
        $this->middleware('permission:exchange_rates-create')->only('create', 'store');
        $this->middleware('permission:exchange_rates-update')->only('edit', 'update');
        $this->middleware('permission:exchange_rates-delete|exchange_rates-trash')->only('destroy', 'trashed');
        $this->middleware('permission:exchange_rates-restore')->only('restore');
    }


    public function index()
    {
        $exchange_rates = ExchangeRate::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.exchange_rates.index')->with('exchange_rates', $exchange_rates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currency::where('status', 'on')->whereNull('is_default')->get();
        return view('dashboard.exchange_rates.create', compact('currencies'));
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
            'currency_id' => "required|integer",
            'rate' => "required|numeric|gt:0",
        ]);


        $default_currency = getDefaultCurrency();


        $exchange_rate = ExchangeRate::create([
            'currency_id' => $request['currency_id'],
            'rate' => $request['rate'],
            'default_currency_id' =>  $default_currency != null ?  $default_currency->id : null,
        ]);



        alertSuccess('exchange_rate created successfully', 'تم اضافة سعر الصرف بنجاح');
        return redirect()->route('exchange_rates.index');
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
    public function edit($exchange_rate)
    {
        $currencies = Currency::where('status', 'on')->whereNull('is_default')->get();
        $exchange_rate = ExchangeRate::findOrFail($exchange_rate);
        return view('dashboard.exchange_rates.edit', compact('currencies', 'exchange_rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeRate $exchange_rate)
    {

        $request->validate([
            'currency_id' => "required|integer",
            'rate' => "required|numeric|gt:0",
        ]);


        $exchange_rate->update([
            'currency_id' => $request['currency_id'],
            'rate' => $request['rate'],
        ]);


        alertSuccess('exchange_rate updated successfully', 'تم تعديل سعر الصرف بنجاح');
        return redirect()->route('exchange_rates.index');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($exchange_rate)
    {
        $exchange_rate = ExchangeRate::withTrashed()->where('id', $exchange_rate)->first();
        if ($exchange_rate->trashed() && auth()->user()->hasPermission('exchange_rates-delete')) {
            deleteImage($exchange_rate->media_id);
            $exchange_rate->forceDelete();
            alertSuccess('exchange_rate deleted successfully', 'تم حذف سعر الصرف بنجاح');
            return redirect()->route('exchange_rates.trashed');
        } elseif (!$exchange_rate->trashed() && auth()->user()->hasPermission('exchange_rates-trash') && checkExchangeRateForTrash($exchange_rate)) {
            $exchange_rate->delete();
            alertSuccess('exchange_rate trashed successfully', 'تم حذف سعر الصرف مؤقتا');
            return redirect()->route('exchange_rates.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the exchange_rate cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو سعر الصرف لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $exchange_rates = ExchangeRate::onlyTrashed()->paginate(100);
        return view('dashboard.exchange_rates.index', ['exchange_rates' => $exchange_rates]);
    }

    public function restore($exchange_rate)
    {
        $exchange_rate = ExchangeRate::withTrashed()->where('id', $exchange_rate)->first()->restore();
        alertSuccess('exchange_rate restored successfully', 'تم استعادة سعر الصرف بنجاح');
        return redirect()->route('exchange_rates.index');
    }
}
