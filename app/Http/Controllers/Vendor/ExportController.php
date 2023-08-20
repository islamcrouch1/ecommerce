<?php

namespace App\Http\Controllers\Vendor;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
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
            return redirect()->back()->withInput();
        } else {
            return redirect()->back()->withInput();
        }
    }
}
