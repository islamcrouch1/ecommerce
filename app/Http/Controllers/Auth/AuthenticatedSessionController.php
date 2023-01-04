<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Dashboard.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
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

        if (Auth::user()->hasRole('affiliate')) {
            return redirect()->route('affiliate.products.index');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {


        if (Auth::user()->hasRole('user')) {
            $path = '/ecommerce';
        } else {
            $path = '/';
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($path);
    }
}
