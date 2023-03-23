<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\Message;
use App\Models\Note;
use App\Models\Order;
use App\Models\Product;
use App\Models\Query;
use App\Models\Request as ModelsRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:users-read')->only('index', 'show', 'trashed');
        $this->middleware('permission:users-create')->only('create', 'store');
        $this->middleware('permission:users-update')->only('edit', 'update');
        $this->middleware('permission:users-delete|users-trash')->only('destroy', 'trashed');
        $this->middleware('permission:users-restore')->only('restore');
    }


    public function index(Request $request)
    {

        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $countries = Country::all();
        $branches = Branch::all();

        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->with('roles')
            ->latest()
            ->paginate(100);


        return view('dashboard.users.index', compact('users', 'roles', 'countries', 'branches'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator'])->get();
        return view('dashboard.users.create')->with('roles', $roles)->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $phone = getPhoneWithCode($request->phone, $request->country);
        $request->merge(['phone' => $phone]);


        $request->validate([
            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|string|min:8|confirmed",
            'country' => "required",
            'phone' => "required|string|unique:users",
            'gender' => "required",
            'profile' => "image",
            'role' => "required|string"
        ]);


        $profile = $request->profile;

        if (!isset($request->profile)) {
            if ($request->gender == 'male') {
                $profile = 'avatarmale.png';
            } else {
                $profile = 'avatarfemale.png';
            }
        } else {
            Image::make($request->profile)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/users/' . $request->profile->hashName()), 80);
        }

        if ($profile !== 'avatarmale.png' && $profile !== 'avatarfemale.png') {
            $profile = $request->profile->hashName();
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'country_id' => $request['country'],
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'profile' => $profile,
        ]);


        if ($request['role'] == '3' || $request['role'] == '4' || $request['role'] == '5') {
            $user->attachRole($request['role']);
        } else {
            $user->attachRoles(['administrator', $request['role']]);
        }


        Cart::create([
            'user_id' => $user->id,
        ]);


        Balance::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'outstanding_balance' => 0,
            'pending_withdrawal_requests' => 0,
            'completed_withdrawal_requests' => 0,
            'bonus' => $user->hasRole('affiliate') ?  0 : 0,
        ]);


        alertSuccess('user created successfully', 'تم إضافة المستخدم بنجاح');
        return redirect()->route('users.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator', 'user', 'vendor', 'affiliate'])->get();
        $user = User::findOrFail($user);
        return view('dashboard.users.edit ', compact('user', 'roles', 'countries'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $phone = getPhoneWithCode($request->phone, $request->country);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'country' => "required",
            'phone' => "required|string|unique:users,phone," . $user->id,
            'gender' => "required",
            'profile' => "image",
            'password' => "nullable|string|min:8|confirmed",
        ]);

        if ($request->hasFile('profile')) {

            if ($user->profile == 'avatarmale.png' || $user->profile == 'avatarfemale.png') {

                Image::make($request['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $request['profile']->hashName()), 60);
            } else {
                Storage::disk('public')->delete('/images/users/' . $user->profile);

                Image::make($request['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $request['profile']->hashName()), 60);
            }

            $user->update([
                'profile' => $request['profile']->hashName(),
            ]);
        }

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'country_id' => $request['country'],
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'password' => isset($request->password) ? Hash::make($request['password']) : $user->password,
        ]);


        if ($request->password == NULL) {
            $description_ar = " تم تعديل بيانات المستخدم " . ' - ' .  $request['name'] . ' - ' . $request['email']  . ' - ' .  $request->phone . ' - ' . $request['gender'];
            $description_en  = "user data changed" . ' - ' .  $request['name'] . ' - ' . $request['email']  . ' - ' .  $request->phone . ' - ' . $request['gender'];
            addLog('admin', 'users', $description_ar, $description_en);
        } else {
            $description_ar = "تم تعديل الرقم السري "  . 'مستخدم رقم ' . ' #' . $user->id;
            $description_en  = "password changed" . ' uesr ID ' . ' #' . $user->id;
            addLog('admin', 'users', $description_ar, $description_en);
        }


        if ($request['role'] != '3' && $request['role'] != '4') {
            $user->detachRoles($user->roles);
            $user->attachRoles(['administrator', $request['role']]);
        }
        alertSuccess('user updated successfully', 'تم تعديل المستخدم بنجاح');
        return redirect()->route('users.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $user = User::withTrashed()->where('id', $user)->first();
        if ($user->trashed() && auth()->user()->hasPermission('users-delete')) {
            Storage::disk('public')->delete('/images/users/' . $user->profile);
            $user->forceDelete();
            alertSuccess('user deleted successfully', 'تم حذف المستخدم بنجاح');
            return redirect()->route('users.trashed');
        } elseif (!$user->trashed() && auth()->user()->hasPermission('users-trash') && checkUserForTrash($user)) {
            $user->delete();
            alertSuccess('user trashed successfully', 'تم حذف المستخدم مؤقتا');
            return redirect()->route('users.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the user cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المستخدم لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }



    public function trashed()
    {
        $countries = Country::all();
        $branches = Branch::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::onlyTrashed()
            ->whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->with('roles')
            ->latest()
            ->paginate(100);
        return view('dashboard.users.index', compact('users', 'roles', 'countries', 'branches'));
    }

    public function restore($user)
    {
        $user = User::withTrashed()->where('id', $user)->first()->restore();
        alertSuccess('user restored successfully', 'تم استعادة المستخدم بنجاح');
        return redirect()->route('users.index');
    }


    public function activate(User $user)
    {
        if (hasVerifiedPhone($user)) {
            $user->forceFill([
                'phone_verified_at' => NULL,
            ])->save();
        } else {
            markPhoneAsVerified($user);
        }
        return redirect()->route('users.index');
    }


    public function block(User $user)
    {
        $user->forceFill([
            'status' => $user->status == 0 ? 1 : 0,
        ])->save();
        return redirect()->route('users.index');
    }


    public function bonus(Request $request, User $user)
    {

        $request->validate([
            'bonus' => "required|numeric",
        ]);

        if ($request->bonus == 0 || $request->bonus < 0) {
            alertError('Can not make this action', 'نأسف , لا يمكن إتمام هذا الإجؤاء');
            return redirect()->route('users.index');
        }

        $user->balance->update([
            'bonus' => $user->balance->bonus + intval($request->bonus)
        ]);

        $ar = 'تم اضافة بونص الى حسابك من الادارة';
        $en = 'A bonus has been added to your account from the administration';
        addFinanceRequest($user, $request->bonus, $en, $ar);

        $title_ar = 'اشعار من الإدارة';
        $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
        $title_en = 'New notification from admin';
        $body_en = 'A bonus has been added to your account from the administration';
        $url = route('withdrawals.user.index');

        addNoty($user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);

        $description_ar = "اضافة رصيد بونص";
        $description_en  = "Add bonus balance";

        addLog('admin', 'bonus', $description_ar, $description_en);

        alertSuccess('Bonus added successfully to the user', 'تم إضافة رصيد البونص بنجاح');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);

        $orders = Order::where('customer_id', $user->id)
            ->whenSearch(request()->search_order)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);

        $vendor_orders = VendorOrder::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $requests = ModelsRequest::where('user_id', $user->id)->latest()
            ->paginate(50);

        $products = Product::where('created_by', $user->id)
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $messages = Message::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(20);


        $notes = Note::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $queries = Query::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        $countries = Country::all();

        $categories = Category::all();

        $roles = Role::WhereRoleNot('superadministrator')->WhereRoleNot('administrator')->WhereRoleNot('vendor')->WhereRoleNot('affiliate')->get();


        return view('dashboard.users.show', compact('roles', 'user', 'withdrawals', 'orders', 'countries', 'vendor_orders', 'requests', 'products', 'categories', 'notes', 'messages', 'queries'));
    }





    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function ordersExport($lang, Request $request)
    {
        return Excel::download(new ProductExport($request->status, $request->from, $request->to), 'orders.xlsx');
    }

    public function withdrawalsExport($lang, Request $request)
    {

        return Excel::download(new WithdrawalsExport($request->status, $request->from, $request->to), 'withdrawals.xlsx');
    }



    public function productsExport($lang, Request $request)
    {
        return Excel::download(new Product1Export($request->status, $request->category), 'products.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file('file')->store('import');


        $import = new ProductImport;
        $import->import($file);


        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }


        if (!session('status')) {

            if (app()->getLocale() == 'ar') {
                return back()->withStatus('تم رفع الملف بنجاح.');
            } else {
                return back()->withStatus('The file has been uploaded successfully.');
            }
        } else {
            return back();
        }
    }
}
