<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:states-read')->only('index', 'show');
        $this->middleware('permission:states-create')->only('create', 'store');
        $this->middleware('permission:states-update')->only('edit', 'update');
        $this->middleware('permission:states-delete|states-trash')->only('destroy', 'trashed');
        $this->middleware('permission:states-restore')->only('restore');
    }


    public function index()
    {
        $states = State::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        $countries = Country::all();

        return view('dashboard.states.index', compact('countries', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.states.create', compact('countries'));
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
            'name_ar' => "required|string|max:255|unique:states",
            'name_en' => "required|string|max:255|unique:states",
            'country_id' => "required|string",
            'status' => "required|string",
            'shipping_amount' => "required|string",
        ]);


        $state = State::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'],
        ]);

        alertSuccess('state created successfully', 'تم اضافة المحافظة بنجاح');
        return redirect()->route('states.index');
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
    public function edit($state)
    {
        $countries = Country::all();
        $state = State::findOrFail($state);
        return view('dashboard.states.edit ', compact('countries', 'state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, state $state)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:states,name_ar," . $state->id,
            'name_en' => "required|string|max:255|unique:states,name_en," . $state->id,
            'country_id' => "required|string",
            'status' => "required|string",
            'shipping_amount' => "required|string",
        ]);


        $state->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'country_id' => $request['country_id'],
            'shipping_amount' => $request['shipping_amount'],
            'status' => $request['status'],
        ]);


        alertSuccess('state updated successfully', 'تم تعديل المحافظة بنجاح');
        return redirect()->route('states.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($state)
    {
        $state = State::withTrashed()->where('id', $state)->first();
        if ($state->trashed() && auth()->user()->hasPermission('states-delete')) {
            deleteImage($state->media_id);
            $state->forceDelete();
            alertSuccess('state deleted successfully', 'تم حذف المحافظة بنجاح');
            return redirect()->route('states.trashed');
        } elseif (!$state->trashed() && auth()->user()->hasPermission('states-trash') && checkstateForTrash($state)) {
            $state->delete();
            alertSuccess('state trashed successfully', 'تم حذف المحافظة مؤقتا');
            return redirect()->route('states.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the state cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المحافظة لا يمكن حذفها حاليا');
            return redirect()->back();
        }
    }


    public function trashed()
    {
        $states = State::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('dashboard.states.index', ['states' => $states]);
    }

    public function restore($state)
    {
        $state = State::withTrashed()->where('id', $state)->first()->restore();
        alertSuccess('state restored successfully', 'تم استعادة المحافظة بنجاح');
        return redirect()->route('states.index');
    }
}
