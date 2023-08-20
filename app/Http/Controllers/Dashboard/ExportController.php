<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\AccountsExport;
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
        $response =  Excel::download(new UsersExport($request->data), 'users.xlsx');
        ob_end_clean();
        return $response;
    }


    public function accountsExport(Request $request)
    {
        $response =  Excel::download(new AccountsExport($request->data), 'accounts.xlsx');
        ob_end_clean();
        return $response;
    }





    public function ordersExport(Request $request)
    {
        $response =  Excel::download(new OrdersExport($request->data), 'orders.xlsx');
        ob_end_clean();
        return $response;
    }

    public function withdrawalsExport(Request $request)
    {
        $response = Excel::download(new WithdrawalsExport($request->data), 'withdrawals.xlsx');
        ob_end_clean();
        return $response;
    }



    public function productsExport(Request $request)
    {
        $response = Excel::download(new ProductsExport($request->data, $request->is_vendors), 'products.xlsx');
        ob_end_clean();
        return $response;
    }
}
