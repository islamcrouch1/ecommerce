<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Cart;
use App\Models\Preview;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PreviewsClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:previews_clients-read')->only('index', 'show', 'trashed');
        $this->middleware('permission:previews_clients-create')->only('create', 'store');
        $this->middleware('permission:previews_clients-update')->only('edit', 'update');
        $this->middleware('permission:previews_clients-delete|previews_clients-trash')->only('destroy', 'trashed');
        $this->middleware('permission:previews_clients-restore')->only('restore');
    }


    public function index(Request $request)
    {

        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $users = User::where('created_by', Auth::id())
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereRole('user')
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.previews_clients.index', compact('users'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.previews_clients.create');
    }

    public function createPreview($user)
    {


        $user = User::findOrFail($user);
        $stages = Stage::all();


        if (request()->preview == null) {
            $stage = Stage::first();
            $preview = request()->preview;
        } else {
            $preview = Preview::findOrFail(request()->preview);
            $count = $preview->stage_count;
            $stage = 0;
            if (isset(request()->stage)) {
                foreach ($stages as $key => $item) {
                    if ($item->id == request()->stage) {
                        $stage = $key;
                    }
                }
                if (isset(request()->dir) && request()->dir == 'prev') {
                    $stage = isset($stages[$stage - 1]) ? $stages[$stage - 1] : $stages[$stage];
                } elseif (isset(request()->dir) && request()->dir == 'next') {
                    $stage = isset($stages[$stage + 1]) ? $stages[$stage + 1] : $stages[$stage];
                }
            } else {
                $stage = isset($stages[$count]) ? $stages[$count] : $stages[$count - 1];
            }
        }




        return view('dashboard.previews_clients.previews', compact('user', 'stage', 'preview'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $phone = getPhoneWithCode($request->phone, Auth::user()->country_id);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name' => "required|string|max:255",
            'password' => "required|string|min:8|confirmed",
            'phone' => "required|string|unique:users",
            'gender' => "required",
        ]);


        if (!isset($request->profile)) {
            if ($request->gender == 'male') {
                $profile = 'avatarmale.png';
            } else {
                $profile = 'avatarfemale.png';
            }
        }

        $country = Auth::user()->country_id;
        $email = $request->phone . '@domain.com';


        $user = User::create([
            'name' => $request['name'],
            'email' => $email,
            'password' => Hash::make($request['password']),
            'country_id' => $country,
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'profile' => $profile,
            'created_by' => Auth::id(),
        ]);


        $user->attachRole('5');

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


        alertSuccess('client created successfully', 'تم إضافة العميل بنجاح');
        return redirect()->route('previews_clients.index');
    }

    public function StorePreview(Request $request, $user)
    {


        $user = User::findOrFail($user);
        $stage = Stage::findOrFail($request->stage);
        $stages = Stage::all();


        if ($request->preview == 0) {

            $preview = Preview::create([
                'user_id' => $user->id,
                'created_by' => Auth::id(),
            ]);
        } else {
            $preview = Preview::findOrFail($request->preview);
        }




        if ($preview->stages->where('id', $stage->id)->count() == 0) {
            $preview->stages()->attach(
                $stage->id,
                [
                    'score' => 0,
                ]
            );

            $prev_score = 0;
        } else {
            $prev_score = $preview->stages->where('id', $stage->id)->first()->score;
        }



        $score = 0;

        foreach ($request->data as $key => $item) {

            $field = $stage->fields->where('id', $key)->first();

            if ($field->type == 'name') {
                $data = implode(',', $item);

                if (is_array($item) && count($item) == 4 && $data != "") {

                    if ($preview->fields->where('id', $field->id)->count() == 0) {
                        $score += $field->score;

                        $preview->fields()->attach(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    } else {
                        $preview->fields()->updateExistingPivot(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    }
                }
            }


            if ($field->type == 'photo') {

                if (is_array($item) && count($item) == 1) {


                    if ($preview->fields->where('id', $field->id)->count() == 0) {

                        $media_id = saveMedia('image', $item[0], 'previews');
                        $score += $field->score;


                        $preview->fields()->attach(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'media_id' => $media_id,
                            ]
                        );
                    } else {

                        deleteImage($preview->fields->where('id', $field->id)->first()->media_id);
                        $media_id = saveMedia('image', $item[0], 'previews');

                        $preview->fields()->updateExistingPivot(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'media_id' => $media_id,
                            ]
                        );
                    }
                }
            }


            if ($field->type == 'number' || $field->type == 'text') {
                $data = implode(',', $item);

                if (is_array($item) && count($item) == 1 && $data != "") {


                    if ($preview->fields->where('id', $field->id)->count() == 0) {
                        $score += $field->score;

                        $preview->fields()->attach(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    } else {
                        $preview->fields()->updateExistingPivot(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    }
                }
            }


            if ($field->type == 'radio' || $field->type == 'checkbox') {
                $data = implode(',', $item);

                if (is_array($item)  && $data != "") {


                    if ($preview->fields->where('id', $field->id)->count() == 0) {

                        $score += $field->score;


                        $preview->fields()->attach(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    } else {
                        $preview->fields()->updateExistingPivot(
                            $field->id,
                            [
                                'score' => $field->score,
                                'stage_id' => $stage->id,
                                'type' => $field->type,
                                'data' => $data,
                            ]
                        );
                    }
                }
            }
        }


        $preview->stages()->updateExistingPivot(
            $stage->id,
            [
                'score' => $score + $prev_score,
            ]
        );


        if ($score >= $stage->score) {
            $preview->update([
                'total_score' => $preview->total_score + $score,
                'stage_count' => $score >= $stage->score ? ($preview->stage_count + 1) : $preview->stage_count,
            ]);
        }


        if ($preview->stage_count >= $stages->count()) {
            alertSuccess('preview endded successfully', 'تم الانتهاء من المعاينة بنجاح');
            return redirect()->route('previews_clients.index');
        }

        if ($score >= $stage->score) {

            alertSuccess('The preview data has been added successfully. Please enter the rest of the required information to complete the preview', 'تم اضافة بيانات المعاينة بنجاح يرجى ادخال باقي المعلومات المطلوبة للانتهاء من المعاينة');
            return redirect()->route('previews.create', ['user' => $user->id, 'preview' => $preview->id]);
        } else {
            alertSuccess('The data entered is not sufficient to continue the preview. Please enter all the required information as much as possible', 'البيانات المدخلة غير كافية لمتابعة المعاينة يرجى ادخال جميع المعلومات المطلوبة قدر الامكان');
            return redirect()->route('previews.create', ['user' => $user->id, 'preview' => $preview->id]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $user = User::findOrFail($user);
        return view('dashboard.previews_clients.edit ', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $previews_client)
    {

        $user = $previews_client;

        $phone = getPhoneWithCode($request->phone, Auth::user()->country_id);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'name' => "required|string|max:255",
            'phone' => "required|string|unique:users,phone," . $user->id,
            'gender' => "required",
            'password' => "nullable|string|min:8|confirmed",
        ]);

        $user->update([
            'name' => $request['name'],
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'password' => isset($request->password) ? Hash::make($request['password']) : $user->password,
            'updated_by' => Auth::id(),
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


        alertSuccess('client updated successfully', 'تم تعديل العميل بنجاح');
        return redirect()->route('previews_clients.index');
    }





    public function show(User $previews_client)
    {
        $user = $previews_client;
        return view('dashboard.previews_clients.show', compact('user'));
    }
}
