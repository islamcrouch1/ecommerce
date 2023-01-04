<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use App\Exports\WithdrawalsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        // $this->middleware('permission:countries-read')->only('index', 'show');
        // $this->middleware('permission:countries-create')->only('create', 'store');
        // $this->middleware('permission:countries-update')->only('edit', 'update');
        // $this->middleware('permission:countries-delete|countries-trash')->only('destroy', 'trashed');
        // $this->middleware('permission:countries-restore')->only('restore');
    }

    public function usersExport(Request $request)
    {
        $response =  Excel::download(new UsersExport($request->role_id, $request->from, $request->to), 'users.xlsx');
        ob_end_clean();
        return $response;
    }

    public function ordersExport(Request $request)
    {
        $response =  Excel::download(new OrdersExport($request->status, $request->from, $request->to), 'orders.xlsx');
        ob_end_clean();
        return $response;
    }

    public function withdrawalsExport(Request $request)
    {
        $response = Excel::download(new WithdrawalsExport($request->status, $request->from, $request->to), 'withdrawals.xlsx');
        ob_end_clean();
        return $response;
    }



    public function productsExport(Request $request)
    {
        $response = Excel::download(new ProductsExport($request->status, $request->category_id), 'products.xlsx');
        ob_end_clean();
        return $response;
    }

    public function import(Request $request)
    {
        $file = $request->file('file')->store('import');

        $import = new ProductImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        if (!session('error')) {
            alertSuccess('The file has been uploaded successfully.', 'تم رفع الملف بنجاح.');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
