<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use Stevebauman\Location\Facades\Location;


class ProfileController extends Controller
{
    public function edit()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator'])->get();
        $user = Auth::user();
        return view('dashboard.users.profile ', compact('user', 'countries', 'roles'));
    }


    public function update(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'profile' => "image",
        ]);




        if (isset($request->password) && !Hash::check($request->old_password, $user->password)) {
            alertError('The password you entered is incorrect', 'الرقم السري الذي ادخلته غير صحيح');
            return redirect()->back()->withInput();
        }

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
            'password' => isset($request->password) ? Hash::make($request['password']) : $user->password,
        ]);

        alertSuccess('Your profile updated successfully', 'تم تحديث حسابك بنجاح');
        return redirect()->route('user.edit');
    }


    public function updateStore(Request $request)
    {



        if (isset($request->user)) {
            $user = User::findOrFail($request->user);
        } else {
            $user = Auth::user();
        }



        $request->validate([
            'store_description' => "nullable|string",
            'store_name' => "nullable|string|max:255",
            'store_profile' => "nullable|image",
            'store_cover' => "nullable|image",
            'commercial_record' => "nullable|image",
            'tax_card' => "nullable|image",
            'id_card_front' => "nullable|image",
            'id_card_back' => "nullable|image",
            'company_address' => "nullable|string|max:255",
            'bank_account' => "nullable|string|max:255",
            'website' => "nullable|string|max:255",
            'facebook_page' => "nullable|string|max:255",
            'store_status' => "nullable|integer",
        ]);



        $user_info = getUserInfo($user);


        if ($request->hasFile('store_profile')) {
            $store_profile = saveMedia('image', $request['store_profile'], 'users');
        } else {


            if (getUserInfo($user) == null) {

                $store_profile = null;
            } else {

                $store_profile = $user_info->store_profile;
            }
        }





        if ($request->hasFile('store_cover')) {

            $store_cover = saveMedia('image', $request['store_cover'], 'users');
        } else {
            if (getUserInfo($user) == null) {
                $store_cover = null;
            } else {
                $store_cover = $user_info->store_cover;
            }
        }



        if ($request->hasFile('commercial_record')) {
            $commercial_record = saveMedia('image', $request['commercial_record'], 'users');
        } else {
            if (getUserInfo($user) == null) {
                $commercial_record = null;
            } else {
                $commercial_record = $user_info->commercial_record;
            }
        }

        if ($request->hasFile('tax_card')) {
            $tax_card = saveMedia('image', $request['tax_card'], 'users');
        } else {
            if (getUserInfo($user) == null) {
                $tax_card = null;
            } else {
                $tax_card = $user_info->tax_card;
            }
        }

        if ($request->hasFile('id_card_front')) {
            $id_card_front = saveMedia('image', $request['id_card_front'], 'users');
        } else {
            if (getUserInfo($user) == null) {
                $id_card_front = null;
            } else {
                $id_card_front = $user_info->id_card_front;
            }
        }

        if ($request->hasFile('id_card_back')) {
            $id_card_back = saveMedia('image', $request['id_card_back'], 'users');
        } else {
            if (getUserInfo($user) == null) {
                $id_card_back = null;
            } else {
                $id_card_back = $user_info->id_card_back;
            }
        }




        if (getUserInfo($user) == null) {



            $user_info = UserInfo::create([
                'store_profile' =>  $store_profile,
                'store_cover' =>  $store_cover,
                'commercial_record' =>  $commercial_record,
                'tax_card' =>  $tax_card,
                'id_card_front' =>  $id_card_front,
                'id_card_back' =>  $id_card_back,
                'store_description' =>  $request->store_description,
                'store_name' =>  $request->store_name,
                'company_address' =>  $request->company_address,
                'bank_account' =>  $request->bank_account,
                'website' =>  $request->website,
                'facebook_page' =>  $request->facebook_page,
                'store_status' => $request->store_status ? $request->store_status : 1,
                'user_id' => $user->id,
            ]);
        } else {
            $user_info = getUserInfo($user);
            $user_info->update([
                'store_profile' =>  $store_profile,
                'store_cover' =>  $store_cover,
                'commercial_record' =>  $commercial_record,
                'tax_card' =>  $tax_card,
                'id_card_front' =>  $id_card_front,
                'id_card_back' =>  $id_card_back,
                'store_description' =>  $request->store_description,
                'store_name' =>  $request->store_name,
                'company_address' =>  $request->company_address,
                'bank_account' =>  $request->bank_account,
                'website' =>  $request->website,
                'facebook_page' =>  $request->facebook_page,
                'store_status' => $request->store_status ? $request->store_status : 1,

            ]);
        }

        alertSuccess('Your store information updated successfully', 'تم تحديث بيانات متجرك بنجاح');
        return redirect()->back()->withInput();
    }


    public function attendanceStore(Request $request)
    {

        if (isset($request->user)) {
            $user = User::findOrFail($request->user);
        } else {
            $user = Auth::user();
        }

        $request->validate([
            'password' => "required|string|min:8",
            'latitude' => "required|string",
            'longitude' => "required|string",
        ]);


        if (!Hash::check($request->password, $user->password)) {
            alertError('The password you entered is incorrect', 'الرقم السري الذي ادخلته غير صحيح');
            return redirect()->back()->withInput();
        }

        $date = Carbon::now();

        $ip =  request()->ip();
        $position = Location::get($ip);

        if ($position) {
            $countryName = $position->countryName;
            $regionName = $position->regionName;
            $cityName = $position->cityName;
        } else {
            $countryName = null;
            $regionName = null;
            $cityName = null;
        }
        $device = strval(request()->userAgent());

        $employee_info = getEmployeeInfo($user);



        if (getUserAttendance() == null) {
            $attendance_date = $date->toDateTimeString();
            $attendance = Attendance::create([
                'user_id' => $user->id,
                'ip' => $ip,
                'country_name' => $countryName,
                'state_name' => $regionName,
                'city_name' => $cityName,
                'device' => $device,
                'attendance_date' => $attendance_date,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'start_time' => $employee_info->start_time,
            ]);

            alertSuccess('attendance record saved successfully', 'تم تسجيل حضورك بنجاح');
        } else {

            if (getUserLeave() == null) {
                $leave_date = $date->toDateTimeString();
                $attendance = Attendance::create([
                    'user_id' => $user->id,
                    'ip' => $ip,
                    'country_name' => $countryName,
                    'state_name' => $regionName,
                    'city_name' => $cityName,
                    'device' => $device,
                    'leave_date' => $leave_date,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'start_time' => $employee_info->start_time,

                ]);

                alertSuccess('leave record saved successfully', 'تم تسجيل انصرافك بنجاح');
            }
        }


        return redirect()->back()->withInput();
    }
}
