<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Variation;
use Illuminate\Http\Request;

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

        if ($request->type == 'variations') {

            $data['elements'] = Variation::whenAttribute($request->parent)->whenSearch($search)
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
