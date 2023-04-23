<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $request->validate([
            'search' => "nullable|string",
            'type' => "required|string",
            'parent' => "nullable|string",
        ]);

        $search = $request->search;
        $data = [];
        $user = Auth::user();


        if ($request->type == 'variations') {

            $data['elements'] = Variation::whenAttribute($request->parent)->whenSearch($search)
                ->get();
        }

        if ($request->type == 'products') {

            $data['elements'] =  Product::where('vendor_id', null)->whenSearch($search)
                ->get();
        }

        if ($request->type == 'categories') {

            $data['elements'] =  Category::whenSearch($search)
                ->get();
        }

        if ($request->type == 'accounts') {

            $data['elements'] =  Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
                ->whenSearch($search)
                ->get();
        }



        if ($data['elements']) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }
}
