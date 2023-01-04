<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Cart;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\ImageManagerStatic as Image;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Dashboard.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
            'gender' => ['required', 'string'],
            'profile' => ['image'],
            'check' => ['required'],
            'role' => ['required', 'string'],
        ]);


        // check if role exist


        if ($request->role != '3' && $request->role != '4') {
            return redirect()->back();
        }

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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'profile' => $profile,
        ]);


        $user->attachRole($request->role);

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
        callToVerify($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
