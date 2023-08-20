<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Http\Request;

class ImportController extends Controller
{
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
