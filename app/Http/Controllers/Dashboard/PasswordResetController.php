<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('Dashboard.reset_password.password-reset-request');
    }

    public function verify(Request $request)
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

        $user = User::where('phone', $request->phone)->first();

        if ($user == null) {
            if (app()->getLocale() == 'ar') {
                return redirect()->route('password.reset.request')->with('status', 'رقم الموبايل الذي ادخلته غير صحيح أو لم يتم التسجيل به في المنصة الخاصة بنا');
            } else {
                return redirect()->route('password.reset.request')->with('status', 'The mobile number you entered is not valid or has not been registered on our platform');
            }
        } else {
            callToVerify($user);
            return redirect()->route('password.reset.confirm.show', ['user' => $user->id]);
        }
    }


    public function show(Request $request)
    {

        $user = User::findOrFail($request->user);
        return view('Dashboard.reset_password.password-reset-confirm', compact('user'));
    }

    public function resend(Request $request)
    {
        $user = User::findOrFail($request->user);
        callToVerify($user);
        return redirect()->back();
    }


    public function sendConf()
    {
        callToVerify(Auth::user());
        return 1;
    }


    public function change(Request $request)
    {

        $user = User::findOrFail($request->user);
        if ($user->verification_code !== $request->code) {
            if (app()->getLocale() == "en") {
                throw ValidationException::withMessages([
                    'code' => ['The code your provided is wrong. Please try again or request another call.'],
                ]);
            } else {
                throw ValidationException::withMessages([
                    'code' => ['الكود الذي ادخلته غير صحيح , يرجى المحاولة مره اخرى'],
                ]);
            }
        }

        return view('Dashboard.reset_password.password-reset-change', compact('user'));
    }


    public function confirm(Request $request)
    {

        $user = User::findOrFail($request->user);
        if ($request->password != $request->password_confirmation) {

            if (app()->getLocale() == 'ar') {
                session(['status' => 'الرقم السري الذي ادخلته غير متطابق']);
                return view('Dashboard.reset_password.password-reset-change', compact('user'));
            } else {
                session(['status' => 'The password you entered does not match']);
                return view('Dashboard.reset_password.password-reset-change', compact('user'));
            }
        }

        $user->update([
            'password' => Hash::make($request['password']),
        ]);


        session(['status' => null]);
        if (app()->getLocale() == 'ar') {

            session(['success' => 'تم تغيير الرقم السري بنجاح']);
        } else {

            session(['success' => 'Password changed successfully']);
        }

        return redirect()->route('login');
    }
}
