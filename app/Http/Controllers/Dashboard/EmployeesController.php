<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Country;
use App\Models\EmployeeInfo;
use App\Models\EmployeeInfoImage;
use App\Models\EmployeePermission;
use App\Models\Entry;
use App\Models\Message;
use App\Models\Note;
use App\Models\Order;
use App\Models\Product;
use App\Models\Query;
use App\Models\Reward;
use App\Models\Role;
use App\Models\SalaryCard;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Request as ModelsRequest;


class EmployeesController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:employees-read')->only('index', 'show');
        $this->middleware('permission:employees-create')->only('create', 'store');
        $this->middleware('permission:employees-update')->only('edit', 'update');
        $this->middleware('permission:employees-delete|employees-trash')->only('destroy', 'trashed');
        $this->middleware('permission:employees-restore')->only('restore');
    }


    public function index(Request $request)
    {

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $countries = Country::all();

        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereRoleNot('superadministrator')
            ->whereRole('administrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->with('roles')
            ->latest()
            ->paginate(100);



        return view('dashboard.employees.index', compact('users', 'roles', 'countries', 'branches'));
    }


    public function edit($employee)
    {
        $employee = EmployeeInfo::findOrFail($employee);
        $user = $employee->user;
        return view('dashboard.employees.edit ', compact('employee', 'user'));
    }

    public function update(Request $request, EmployeeInfo $employee)
    {


        $user = $employee->user;

        $request->validate([
            'address' => "nullable|string",
            'national_id' => "nullable|string",
            'job_title' => "nullable|string|max:255",
            'branch_id' => "nullable|integer",
            'basic_salary' => "nullable|numeric|gt:0",
            'variable_salary' => "nullable|numeric|gte:0",
            'Weekend_days' => "nullable|array",
            'work_hours' => "nullable|numeric|gt:0",
            'images' => "nullable|array",
            'start_time' => "nullable|string",
        ]);


        if (getEmployeeInfo($user) == null) {
            $employee_info = EmployeeInfo::create([
                'address' =>  $request->address,
                'national_id' =>  $request->national_id,
                'job_title' =>  $request->job_title,
                'branch_id' =>  $request->branch_id,
                'Weekend_days' => is_array($request->Weekend_days) ? serialize($request->Weekend_days) : serialize(null),
                'basic_salary' =>  $request->basic_salary,
                'variable_salary' =>  $request->variable_salary,
                'work_hours' =>  $request->work_hours,
                'start_time' =>  $request->start_time,
                'user_id' => $user->id,
            ]);
        } else {
            $employee_info = getEmployeeInfo($user);
            $employee_info->update([
                'address' =>  $request->address,
                'national_id' =>  $request->national_id,
                'job_title' =>  $request->job_title,
                'branch_id' =>  $request->branch_id,
                'Weekend_days' => is_array($request->Weekend_days) ? serialize($request->Weekend_days) : serialize(null),
                'basic_salary' =>  $request->basic_salary,
                'variable_salary' =>  $request->variable_salary,
                'work_hours' =>  $request->work_hours,
                'start_time' =>  $request->start_time,

            ]);
        }

        if ($request->branch_id != null) {
            $user->update([
                'branch_id' => $request->branch_id,
            ]);
        }


        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'users');
                EmployeeInfoImage::create([
                    'employee_info_id' => $employee_info->id,
                    'media_id' => $media_id,
                ]);
            }
        }



        alertSuccess('Employee data stored successfully', 'تم تحديث بيانات الموظف بنجاح');
        return redirect()->route('employees.index');
    }



    public function payrollPreparation(Request $request, $user, $date)
    {
        $user = User::findOrFail($user);

        if (!$request->has('date')) {
            $request->merge(['date' => Carbon::parse($date)->format('Y-m')]);
        }


        $permissions = EmployeePermission::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereYear('start_date', '<=', Carbon::parse($request->date)->format('Y'))
            ->whereMonth('start_date', '<=', Carbon::parse($request->date)->format('m'))
            ->whereYear('end_date', '>=', Carbon::parse($request->date)->format('Y'))
            ->whereMonth('end_date', '>=', Carbon::parse($request->date)->format('m'))
            ->get();

        $employee_info = getEmployeeInfo($user);

        if ($employee_info) {
            $day_salary = ((($employee_info->basic_salary + $employee_info->variable_salary) * 12) / 365);
            $day_salary = round($day_salary, 2);
        }

        $start = Carbon::parse($request->date)->startOfMonth();
        $end = Carbon::parse($request->date)->endOfMonth();
        $dates = [];
        while ($start->lte($end)) {
            $dates[$start->toDateString()] = $start->format('D');
            $start->addDay();
        }

        $weekend_days = ($employee_info->Weekend_days &&
            is_array(unserialize($employee_info->Weekend_days))) ? unserialize($employee_info->Weekend_days) : [];


        $absence_days = 0;
        foreach ($dates as $key => $date) {

            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('attendance_date', '=', $key)
                ->whereNotNull('attendance_date')
                ->first();

            $leave = Attendance::where('user_id', $user->id)
                ->whereDate('leave_date', '=', $key)
                ->whereNotNull('leave_date')
                ->first();

            $permission = EmployeePermission::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->where('type', 'vacation')
                ->whereDate('start_date', '<=', $key)
                ->whereDate('end_date', '>=', $key)
                ->first();


            if ((!in_array($date, $weekend_days) && ($attendance == null || $leave == null))) {
                if ($permission == null) {
                    $absence_days++;
                }
            }
        }

        $total_absence = $absence_days * $day_salary;



        $month = Carbon::parse($request->date)->format('m');
        $year = Carbon::parse($request->date)->format('Y');

        $penalties = Reward::where('user_id', $user->id)
            ->where('type', 'penalty')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->get();

        $penalties_amount = 0;
        foreach ($penalties as $penalty) {
            $penalties_amount += $penalty->amount;
        }


        $rewards = Reward::where('user_id', $user->id)
            ->where('type', 'reward')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', '=', $year)
            ->get();

        $rewards_amount = 0;
        foreach ($rewards as $reward) {
            $rewards_amount += $reward->amount;
        }


        $branch_id = getUserBranchId($user);
        $loans_account = getItemAccount($user->id, null, 'employee_loan_account', $branch_id);
        $loans =  getTrialBalance($loans_account->id, null, null);


        $total_deduction = $total_absence + $penalties_amount + $loans;

        $net_salary = $employee_info->basic_salary + $employee_info->variable_salary - $total_absence - $penalties_amount - $loans + $rewards_amount;


        return view('dashboard.payrolls.payroll', compact('user', 'permissions', 'day_salary', 'absence_days', 'total_absence', 'penalties_amount', 'loans', 'total_deduction', 'rewards_amount', 'net_salary'));
    }


    public function payrollList(Request $request)
    {

        $user = Auth::user();

        if (!$request->has('date')) {
            $request->merge(['date' => Carbon::now()->format('Y-m')]);
        }

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'administrator');
        })->get();


        foreach ($users as $u) {

            if (getEmployeeInfo($u) == null) {
                $employee_info = EmployeeInfo::create([
                    'user_id' => $u->id,
                ]);
            }
        }

        // where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
        //     ->

        $employees = EmployeeInfo::whenSearch(request()->search)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.payrolls.index', compact('branches', 'employees'));
    }


    public function payrollListStore(Request $request, User $user, $date)
    {

        $request->validate([
            'penalties_amount' => "required|numeric|gt:-0.99",
            'insurance' => "required|numeric|gt:-0.99",
            'loans' => "required|numeric|gt:-0.99",
            'rewards_amount' => "required|numeric|gt:-0.99",
        ]);

        $employee_info = getEmployeeInfo($user);
        // $branch_id = getUserBranchId($user);


        if ($employee_info) {
            $basic_salary = $employee_info->basic_salary;
            $variable_salary = $employee_info->variable_salary;
            $day_salary = getUserDaySalary($user);
            $absence_days = getUserAbsenceDays($user, $date);
            $total_absence = ($day_salary * $absence_days);
        } else {
            $basic_salary = 0;
            $variable_salary = 0;
            $day_salary = 0;
            $absence_days = 0;
            $total_absence = 0;
        }

        $total_deduction = ($request->penalties_amount + $request->insurance + $request->loans + $total_absence);



        if (getSalaryCard($user, $date)) {
            getSalaryCard($user, $date)->update([
                'penalties' => $request->penalties_amount,
                'insurance' => $request->insurance,
                'loans' => $request->loans,
                'rewards' => $request->rewards_amount,
                'basic_salary' =>  $basic_salary,
                'variable_salary' =>  $variable_salary,
                'day_salary' =>  $day_salary,
                'absence_days' => $absence_days,
                'total_absence' => $total_absence,
                'total_deduction' => $total_deduction,
                'net_salary' => ($basic_salary + $variable_salary + $request->rewards_amount) - $total_deduction,
                'date' => $date,
                'status' => 'unconfirmed',
            ]);
        } else {
            $salary_card = SalaryCard::create([
                'user_id' => $user->id,
                'penalties' => $request->penalties_amount,
                'insurance' => $request->insurance,
                'loans' => $request->loans,
                'rewards' => $request->rewards_amount,
                'basic_salary' =>  $basic_salary,
                'variable_salary' =>  $variable_salary,
                'day_salary' =>  $day_salary,
                'absence_days' => $absence_days,
                'total_absence' => $total_absence,
                'total_deduction' => $total_deduction,
                'net_salary' => ($basic_salary + $variable_salary + $request->rewards_amount) - $total_deduction,
                'date' => $date,
                'status' => 'unconfirmed',
                'created_by' => Auth::id(),
            ]);
        }



        alertSuccess('salary card saved successfully', 'تم حفظ كارت الراتب بنجاح بنجاح');
        return redirect()->route('payroll.index');
    }


    public function getSalaryCards(Request $request)
    {

        $request->validate([
            'users' => "required|array",
            'type' => "required|string"
        ]);

        $data = [];


        $salary_cards = SalaryCard::whereIn('user_id', $request->users)
            ->groupBy('date')
            ->whereIn('status', ['unconfirmed', 'confirmed'])
            ->select([
                DB::raw('SUM(net_salary) as net_salary'),
                DB::raw('SUM(basic_salary) as basic_salary'),
                DB::raw('SUM(variable_salary) as variable_salary'),
                DB::raw('SUM(total_deduction) as total_deduction'),
                DB::raw('SUM(rewards) as rewards'),
                DB::raw('(date) as date')
            ])
            ->get();

        $data['elements'] = $salary_cards;


        if (isset($data['elements'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }

    public function getSalary(Request $request)
    {

        $request->validate([
            'users' => "required|array",
            'type' => "required|string"
        ]);

        $data = [];


        $salary_cards = SalaryCard::whereIn('user_id', $request->users)
            ->groupBy('date')
            ->whereIn('status', ['paid', 'confirmed'])
            ->select([
                DB::raw('SUM(net_salary) as net_salary'),
                DB::raw('SUM(basic_salary) as basic_salary'),
                DB::raw('SUM(variable_salary) as variable_salary'),
                DB::raw('SUM(total_deduction) as total_deduction'),
                DB::raw('SUM(rewards) as rewards'),
                DB::raw('(date) as date')
            ])
            ->get();

        $data['elements'] = $salary_cards;


        if (isset($data['elements'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }


    public function show(EmployeeInfo $employee)
    {


        $user = $employee->user;

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


        if ($user->hasRole('administrator')) {
            $messages = Message::where([
                ['user_id', '=', $user->id],
                ['sender_id', '=', Auth::user()->id],
            ])
                ->orwhere([
                    ['user_id', '=', Auth::user()->id],
                    ['sender_id', '=', $user->id],
                ])
                ->whenSearch(request()->search)
                ->latest()
                ->paginate(20);
        } else {
            $messages = Message::where([
                ['user_id', '=', $user->id],
            ])
                ->orwhere([
                    ['sender_id', '=', $user->id],
                ])
                ->whenSearch(request()->search)
                ->latest()
                ->paginate(20);
        }




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
}
