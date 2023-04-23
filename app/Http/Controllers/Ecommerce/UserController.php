<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CartItem;
use App\Models\FavItem;
use App\Models\Order;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadesRoute;

class UserController extends Controller
{
    public function create()
    {
        $countries = Country::all();
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.register', compact('countries', 'categories'));
    }

    public function account()
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->id)->latest()->get();
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.account', compact('categories', 'orders', 'user'));
    }

    public function show(Request $request)
    {
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.login', compact('categories'));
    }


    public function login(LoginRequest $request)
    {
        if (isset($request->phone)) {
            $phone = $request->phone;
            $phone = str_replace(' ', '', $phone);
            if ($phone[0] == '0') {
                $phone[0] = ' ';
                $phone = str_replace(' ', '', $phone);
            }
        }

        $user = User::where('phone', 'like', "%$phone%")->first();
        if ($user != null) {
            $country_id = $user->country_id;

            $country = Country::findOrFail($country_id);
            $phone = $country->code . $phone;

            $request->merge(['phone' =>  $phone]);
        }

        $session_id = $request->session()->token();

        $cart_items = CartItem::where('session_id', $session_id)->get();
        $fav_items = FavItem::where('session_id', $session_id)->get();

        foreach ($cart_items as $item) {
            $item->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        }

        foreach ($fav_items as $item) {
            $item->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        }

        $request->authenticate();

        $request->session()->regenerate();

        if ($user->hasRole('administrator|superadministrator')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect()->intended(RouteServiceProvider::ECOMMERCE);
        }
    }


    public function changePassword(Request $request)
    {


        $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ]);


        $user = Auth::user();



        #Match The Old Password
        if (!Hash::check($request->old_password, $user->password)) {
            alertError('old password is not correct', 'كلمة المرور القديمة غير صحيحة');
            return redirect()->back();
        } else {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            alertError('password changed successfully', 'تم تغيير كلمة المرور بنجاح');
            return redirect()->back();
        }
    }



    public function store(Request $request)
    {


        $phone = getPhoneWithCode($request->phone, $request->country);
        $request->merge(['phone' => $phone]);


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            'country' => ['required'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'check' => ['required'],
        ]);




        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country,
            'phone' => $request->phone,
            'gender' => 'male',
            'profile' => 'avatarmale.png'
        ]);


        $user->attachRole(5);


        $session_id = $request->session()->token();

        $cart_items = CartItem::where('session_id', $session_id)->get();
        $fav_items = FavItem::where('session_id', $session_id)->get();

        foreach ($cart_items as $item) {
            $item->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        }

        foreach ($fav_items as $item) {
            $item->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
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

        event(new Registered($user));

        Auth::login($user);
        // callToVerify($user);

        if (FacadesRoute::is('ecommerce.order.store')) {
        } else {
            alertError('account created successfully', 'تم انشاء حسابك بنجاح شكرا لك..');
            return redirect(RouteServiceProvider::ECOMMERCE);
        }
    }
}
