<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Cart;
use App\Models\Client;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:crm-read')->only('index', 'show');
        $this->middleware('permission:crm-create')->only('create', 'store');
        $this->middleware('permission:crm-update')->only('edit', 'update');
        $this->middleware('permission:crm-delete|crm-trash')->only('destroy', 'trashed');
        $this->middleware('permission:crm-restore')->only('restore');
    }


    public function index(Request $request)
    {


        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $countries = Country::all();


        $clients = Client::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.clients.index', compact('countries', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.clients.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $phone = getPhoneWithCode($request->phone, $request->country_id);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name' => "required|string|max:255",
            'email' => "max:255|unique:clients|unique:users",
            'phone' => "required|string|unique:clients|unique:users",
            'whatsapp' => "nullable|string",
            'place_type' => "nullable|string",
            'gender' => "required",
            'address' => "nullable|string",
            'email' => "nullable|string",
            'country_id' => "required|string",
            'state_id' => "required|string",
            'city_id' => "required|string",
        ]);





        $profile = $request->profile;

        if (!isset($request->profile)) {
            if ($request->gender == 'male') {
                $profile = 'avatarmale.png';
            } else {
                $profile = 'avatarfemale.png';
            }
        };

        if (!isset($request->email)) {
            $request->merge(['email' => $phone . '@unitedtoys-eg.com']);
        };




        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make('123456789'),
            'country_id' => $request->country_id,
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'profile' => $profile,
        ]);



        attachRole($user, 'user');

        userCreationData($user);


        $client = Client::create([
            'user_id' => $user->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'place_type' => $request->place_type,
            'whatsapp' => $request->whatsapp,
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
            'created_by' => Auth::id(),
        ]);


        $description_ar = "تم اضافة عميل - " . $user->name . ' #' . $client->id;
        $description_en  = "add new client - " .  $user->name . ' #' . $client->id;
        addLog('admin', 'users', $description_ar, $description_en);



        $admins = unserialize(setting('clients_notifications'));

        $users = User::whereHas('roles', function ($query) use ($admins) {
            $query->whereIn('name', $admins ? $admins : []);
        })->get();


        foreach ($users as $admin) {

            $title_ar = 'تم اضافة عميل جديد';
            $body_ar = $client->name;
            $title_en = 'add new client';
            $body_en  = $client->name;
            $url = route('users.show', ['user' => $user->id]);

            if ($admin->id != Auth::user()->id) {
                addNoty($admin, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }


        alertSuccess('client created successfully', 'تم اضافة العميل بنجاح');
        return redirect()->route('clients.index');
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
    public function edit($client)
    {
        $client = Client::findOrFail($client);
        $countries = Country::all();

        return view('dashboard.clients.edit', compact('countries', 'client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client)
    {



        $phone = getPhoneWithCode($request->phone, $request->country_id);
        $request->merge(['phone' => $phone]);



        $request->validate([
            'name' => "required|string|max:255",
            'email' => "max:255|unique:clients,email," . $client->id,
            'phone' => "required|string|unique:clients,phone," . $client->id,
            'whatsapp' => "string|nullable",
            'place_type' => "nullable|string",
            'gender' => "required",
            'address' => "string|nullable",
            'country_id' => "required|string",
            'state_id' => "required|string",
            'city_id' => "required|string",
        ]);


        $client->user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'country_id' => $request->country_id,

        ]);


        $client->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'place_type' => $request->place_type,
            'whatsapp' => $request->whatsapp,
            'country_id' => $request['country_id'],
            'state_id' => $request['state_id'],
            'city_id' => $request['city_id'],
        ]);


        $description_ar = "تم تعديل بيانات عميل - " . $client->name . ' #' . $client->id;
        $description_en  = "edit client data - " .  $client->name . ' #' . $client->id;
        addLog('admin', 'users', $description_ar, $description_en);


        $admins = unserialize(setting('clients_notifications'));

        $users = User::whereHas('roles', function ($query) use ($admins) {
            $query->whereIn('name', $admins ? $admins : []);
        })->get();



        foreach ($users as $admin) {

            $title_ar = 'تم تعديل بيانات عميل ';
            $body_ar = $client->name . ' #' . $client->id;
            $title_en = 'edit client data';
            $body_en  = $client->name . ' #' . $client->id;
            $url = route('users.show', ['user' => $client->user->id]);

            if ($admin->id != Auth::user()->id) {
                addNoty($admin, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }



        alertSuccess('client updated successfully', 'تم تعديل العميل بنجاح');
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {
        $client = Client::withTrashed()->where('id', $client)->first();
        if ($client->trashed() && auth()->user()->hasPermission('clients-delete')) {
            $client->forceDelete();
            alertSuccess('client deleted successfully', 'تم حذف العميل بنجاح');
            return redirect()->route('clients.trashed');
        } elseif (!$client->trashed() && auth()->user()->hasPermission('clients-trash') && checkClientForTrash($client)) {
            $client->delete();
            alertSuccess('client trashed successfully', 'تم حذف العميل مؤقتا');
            return redirect()->route('clients.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the client cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو العميل لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $clients = Client::onlyTrashed()->paginate(100);
        $countries = Country::all();
        return view('dashboard.clients.index', compact('clients', 'countries'));
    }

    public function restore($client)
    {
        $client = Client::withTrashed()->where('id', $client)->first()->restore();
        alertSuccess('client restored successfully', 'تم استعادة العميل بنجاح');
        return redirect()->route('clients.index');
    }
}
