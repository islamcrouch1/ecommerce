<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:currencies-read')->only('index', 'show');
        $this->middleware('permission:currencies-create')->only('create', 'store');
        $this->middleware('permission:currencies-update')->only('edit', 'update');
        $this->middleware('permission:currencies-delete|currencies-trash')->only('destroy', 'trashed');
        $this->middleware('permission:currencies-restore')->only('restore');
    }


    public function index()
    {
        $currencies = Currency::whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);
        return view('dashboard.currencies.index')->with('currencies', $currencies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.currencies.create');
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
            'name_ar' => "required|string|max:255|unique:currencies",
            'name_en' => "required|string|max:255|unique:currencies",
            'symbol' => "required|string",
            'status' => "nullable|string",
            'is_default' => "nullable|string",
        ]);


        $currency = Currency::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'symbol' => $request['symbol'],
            'status' => $request['is_default'] == 'on' ? 'on' : $request['status'],
            'is_default' => $request['is_default'],
        ]);


        $this->checkDefault($request['is_default'], $currency->id);


        alertSuccess('currency created successfully', 'تم اضافة العملة بنجاح');
        return redirect()->route('currencies.index');
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
    public function edit($currency)
    {
        $currency = Currency::findOrFail($currency);
        return view('dashboard.currencies.edit ')->with('currency', $currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:currencies,name_ar," . $currency->id,
            'name_en' => "required|string|max:255|unique:currencies,name_en," . $currency->id,
            'symbol' => "required|string",
            'status' => "nullable|string",
            'is_default' => "nullable|string",
        ]);


        $currency->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'symbol' => $request['symbol'],
            'status' => $request['is_default'] == 'on' ? 'on' : $request['status'],
            'is_default' => $request['is_default'],
        ]);


        $this->checkDefault($request['is_default'], $currency->id);


        alertSuccess('currency updated successfully', 'تم تعديل العملة بنجاح');
        return redirect()->route('currencies.index');
    }


    private function checkDefault($is_default, $currency_id)
    {

        $currencies = Currency::all();

        if ($is_default == 'on') {

            foreach ($currencies as $scurrency) {

                $scurrency->update([
                    'is_default' => $scurrency->id == $currency_id ? 'on' : null
                ]);
            }
        }

        $setting = Setting::where('type', 'currency_id')->first();

        if ($setting == null) {

            Setting::create([
                'type' => 'currency_id',
                'value' => $currency_id,
            ]);
        } elseif ($setting->value != $currency_id) {

            $setting->update([
                'value' => $currency_id,
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($currency)
    {
        $currency = Currency::withTrashed()->where('id', $currency)->first();
        if ($currency->trashed() && auth()->user()->hasPermission('currencies-delete')) {
            deleteImage($currency->media_id);
            $currency->forceDelete();
            alertSuccess('currency deleted successfully', 'تم حذف العملة بنجاح');
            return redirect()->route('currencies.trashed');
        } elseif (!$currency->trashed() && auth()->user()->hasPermission('currencies-trash') && checkcurrencyForTrash($currency)) {
            $currency->delete();
            alertSuccess('currency trashed successfully', 'تم حذف العملة مؤقتا');
            return redirect()->route('currencies.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the currency cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو العملة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $currencies = Currency::onlyTrashed()->paginate(100);
        return view('dashboard.currencies.index', ['currencies' => $currencies]);
    }

    public function restore($currency)
    {
        $currency = Currency::withTrashed()->where('id', $currency)->first()->restore();
        alertSuccess('currency restored successfully', 'تم استعادة العملة بنجاح');
        return redirect()->route('currencies.index');
    }
}
