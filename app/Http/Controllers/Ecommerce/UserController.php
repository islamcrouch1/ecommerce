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
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.account', compact('categories'));
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

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ECOMMERCE);
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
            'profile' => ''
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

        return redirect(RouteServiceProvider::ECOMMERCE);
    }
}