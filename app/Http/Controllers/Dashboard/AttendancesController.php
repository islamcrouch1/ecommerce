<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendancesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:attendances-read')->only('index', 'show');
        $this->middleware('permission:attendances-create')->only('create', 'store');
        $this->middleware('permission:attendances-update')->only('edit', 'update');
        $this->middleware('permission:attendances-delete|attendances-trash')->only('destroy', 'trashed');
        $this->middleware('permission:attendances-restore')->only('restore');
    }


    public function index(Request $request)
    {

        $user = Auth::user();

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }



        // where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
        //     ->

        $attendances = Attendance::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->whenUser(request()->user_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.attendances.index', compact('branches', 'attendances'));
    }


    public function create()
    {
        return view('dashboard.attendances.create');
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
            'type' => "required|string",
            'employee' => "required|integer",
            'date' => "required|string",
        ]);


        $date = Carbon::now();

        if ($date->lt($request['date'])) {
            alertError('The entered time is greater than the current time', 'الوقت المدخل اكبر من الوقت الحالي');
            return redirect()->back()->withInput();
        }

        $employee = User::findOrFail($request->employee);
        $employee_info = getEmployeeInfo($employee);


        if ($request->type == 'attendance' && getUserAttendance($request->date, $employee) != null) {
            alertError('There is a record of the employee on the same date entered', 'يوجد سجل للموظف في نفس التاريح المدخل');
            return redirect()->back()->withInput();
        }

        if (($request->type == 'leave' && getUserLeave($request->date, $employee) != null) || ($request->type == 'leave' && getUserAttendance($request->date, $employee) == null)) {
            alertError('There is a record of the employee on the same date entered', 'يوجد سجل للموظف في نفس التاريح المدخل');
            return redirect()->back()->withInput();
        }


        $attendance = Attendance::create([
            'user_id' => $employee->id,
            'attendance_date' => $request->type == 'attendance' ?  $request->date : null,
            'leave_date' => $request->type == 'leave' ? $request->date : null,
            'start_time' => $employee_info->start_time,
        ]);

        alertSuccess('record created successfully', 'تم إضافة السجل بنجاح');
        return redirect()->route('attendances.index');
    }



    public function edit($attendance)
    {
        $attendance = Attendance::findOrFail($attendance);
        $user = $attendance->user;
        return view('dashboard.attendances.edit ', compact('attendance', 'user'));
    }

    public function update(Request $request, Attendance $attendance)
    {


        $user = $attendance->user;

        $request->validate([
            'date' => "required|string",
        ]);

        $date = Carbon::now();

        if ($date->lt($request['date'])) {
            alertError('The entered time is greater than the current time', 'الوقت المدخل اكبر من الوقت الحالي');
            return redirect()->back()->withInput();
        }




        if ($attendance->attendance_date) {




            $attendance->update([
                'attendance_date' => $request['date'],
            ]);

            $description_ar = "تم تعديل تاريخ الحضور لموظف - " . $user->name . ' - ' . $request['date'];
            $description_en  = "attendance date updated for employee - " .  $user->name . ' - ' . $request['date'];
        } else {

            $attendance->update([
                'leave_date' => $request['date'],
            ]);

            $description_ar = "تم تعديل تاريخ الانصراف لموظف - " . $user->name . ' - ' . $request['date'];
            $description_en  = "leave date updated for employee - " .  $user->name . ' - ' . $request['date'];
        }








        addLog('admin', 'users', $description_ar, $description_en);
        alertSuccess('time updated successfully', 'تم تحديث الوقت بنجاح');
        return redirect()->route('attendances.index');
    }
}