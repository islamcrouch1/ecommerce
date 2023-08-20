<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SettlementRecord;
use App\Models\SettlementSheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SettlementController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:petty_cash-read')->only('index', 'show');
        $this->middleware('permission:petty_cash-create')->only('create', 'store');
        $this->middleware('permission:petty_cash-update')->only('edit', 'update');
        $this->middleware('permission:petty_cash-delete|petty_cash-trash')->only('destroy', 'trashed');
        $this->middleware('permission:petty_cash-restore')->only('restore');
    }


    public function index(Request $request)
    {

        $user = Auth::user();

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $branches = getbranches()->pluck('id')->toArray();




        // where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
        //     ->

        $sheets = SettlementSheet::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereIn('branch_id', $branches)
            ->whenSearch(request()->search)
            ->whenUser(request()->user_id)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);

        $branches = getbranches();
        return view('dashboard.petty_cash.index', compact('branches', 'sheets'));
    }


    public function settlementStore(Request $request)
    {

        $request->validate([
            'amount' => "required|numeric|gt:0",
        ]);

        $user = Auth::user();


        $account = getItemAccount(Auth::id(), null, 'petty_cash_account', $user->branch_id);
        $petty_amount = getTrialBalance($account->id, null, null);
        $settlement_amount = getSettlementAmount(Auth::user());





        if ($request->amount <=  ($petty_amount - $settlement_amount)) {
            $sheet = SettlementSheet::create([
                'user_id' => $user->id,
                'branch_id' => $user->branch_id,
                'amount' => $request->amount,
            ]);
        }


        if (isset($sheet)) {

            alertSuccess('Saved successfully. Please add the expenses related to the petty cash amount', 'تم الحفظ بنجاح يرجى اضافة المصروفات الخاصة بمبلغ العهدة');
            return redirect()->route('employee.settlement.create', ['sheet' => $sheet->id]);
        } else {
            alertError('An error occurred, please try again', 'حدث خطا يرجة المحاولة مرة اخرى');
            return redirect()->back();
        }
    }


    public function review(SettlementSheet $petty_cash)
    {

        $petty_cash->update([
            'admin_id' => $petty_cash->admin_id == null ? Auth::id() : null,
        ]);


        return redirect()->back();
    }


    public function settlementCreate(SettlementSheet $sheet)
    {
        $records = $sheet->records;
        return view('dashboard.petty_cash.settlement_create', compact('sheet', 'records'));
    }


    public function show(SettlementSheet $petty_cash)
    {
        $records = $petty_cash->records;
        $sheet = $petty_cash;
        return view('dashboard.petty_cash.show', compact('sheet', 'records'));
    }

    public function settlementSheetStore(Request $request, SettlementSheet $sheet)
    {


        $request->validate([
            'statement' => "required|string",
            'amount' => "required|numeric|gt:0",
            'notes' => "nullable|string",
            'media' => "nullable|image",
        ]);

        $user = Auth::user();
        $records_amount = getSettlementAmountForSheet($sheet);
        $remainig_amount = $sheet->amount - $records_amount;

        if ($user->id == $sheet->user_id && $request->amount <= $remainig_amount && $sheet->admin_id == null) {

            if ($request->hasFile('media')) {
                $media_id = saveMedia('image', $request['media'], 'settlement');
            }

            $record = SettlementRecord::create([
                'settlement_sheet_id' => $sheet->id,
                'notes' => $request->notes,
                'amount' => $request->amount,
                'statement' => $request->statement,
                'media_id' => isset($media_id) ? $media_id : null,
            ]);

            alertSuccess('saved successfully', 'تم الحفظ بنجاح');
        } else {
            alertError('An error occurred, please try again', 'حدث خطا يرجة المحاولة مرة اخرى');
        }
        return redirect()->route('employee.settlement.create', ['sheet' => $sheet->id]);
    }

    public function settlementSheetEdit(SettlementRecord $record)
    {
        return view('dashboard.petty_cash.settlement_edit')->with('record', $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settlementSheetUpdate(Request $request, SettlementRecord $record)
    {

        $request->validate([
            'statement' => "required|string",
            'amount' => "required|numeric|gt:0",
            'notes' => "nullable|string",
            'media' => "nullable|image",
        ]);


        $user = Auth::user();


        $records_amount = getSettlementAmountForSheet($record->sheet);
        $remainig_amount = $record->sheet->amount - $records_amount + $record->amount;



        if ($user->id == $record->sheet->user_id && $request->amount <= $remainig_amount) {

            if ($request->hasFile('media')) {

                if ($record->media_id != null) {
                    deleteImage($record->media_id);
                }

                $media_id = saveMedia('image', $request['media'], 'settlement');
            }

            $record->update([
                'notes' => $request->notes,
                'amount' => $request->amount,
                'statement' => $request->statement,
                'media_id' => isset($media_id) ? $media_id : $record->media_id,
            ]);

            alertSuccess('saved successfully', 'تم الحفظ بنجاح');
        } else {
            alertError('An error occurred, please try again', 'حدث خطا يرجة المحاولة مرة اخرى');
        }
        return redirect()->route('employee.settlement.create', ['sheet' => $record->sheet->id]);
    }


    public function create()
    {
        return view('dashboard.rewards.create');
    }



    public function store(Request $request)
    {


        $request->validate([
            'user_id' => "required|integer",
            'amount' => "required|numeric|gt:0",
            'note' => "required|string",
            'type' => "required|string",
        ]);

        $user = User::findOrFail($request['user_id']);

        $reward = Reward::create([
            'user_id' => $request['user_id'],
            'amount' => $request['amount'],
            'note' => $request['note'],
            'type' => $request['type'],
        ]);



        $description_ar = "تم اضافة" . ' ' . __($request['type']) . ' ' . 'الى' . $user->name . ' - ' . $request['amount'];
        $description_en = __($request['type']) . ' ' . 'has been added' . ' ' . 'to' . $user->name . ' - ' . $request['amount'];
        addLog('admin', 'users', $description_ar, $description_en);


        alertSuccess('saved successfully', 'تم الحفظ بنجاح');
        return redirect()->route('rewards.index');
    }


    public function destroy(SettlementSheet $petty_cash)
    {
        if (auth()->user()->hasPermission('petty_cash-delete') || auth()->user()->hasPermission('petty_cash-trash')) {

            $user = User::findOrFail($petty_cash->user_id);
            $description_ar = "تم حذف" . ' ' . __('petty cash') . ' ' . 'من' . $user->name . ' - ' . $petty_cash->amount;
            $description_en = __('petty cash') . ' ' . 'has been deleted' . ' ' . 'from' . $user->name . ' - ' . $petty_cash->amount;
            addLog('admin', 'users', $description_ar, $description_en);

            $petty_cash->delete();

            alertSuccess('deleted successfully', 'تم الحذف بنجاح');
            return redirect()->route('petty_cash.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the color cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو اللون لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }



    public function settlement(Request $request)
    {

        $request->validate([
            'user_id' => "required|integer",
        ]);

        $data = [];


        $sheets = SettlementSheet::where('user_id', $request->user_id)
            ->whereNotNull('admin_id')
            ->where('status', 'pending')
            ->get();


        $remaining = 0;
        $records = 0;


        $user = User::findOrFail($request->user_id);


        foreach ($sheets as $sheet) {

            $records_amount = getSettlementAmountForSheet($sheet);
            $remainig_amount = $sheet->amount - $records_amount;

            $remaining += $remainig_amount;
            $records += $records_amount;
        }




        $data['sheets'] = $sheets;

        $account = getItemAccount($user->id, null, 'petty_cash_account', $user->branch_id);
        $petty_amount = getTrialBalance($account->id, null, null);
        $settlement_amount = getSettlementAmount($user);

        $data['total_petty_amount'] = $petty_amount;
        $data['total_sheets_amount'] = $settlement_amount;
        $data['total_remaining_amount'] = $remaining;



        if (isset($data['sheets'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }
}
