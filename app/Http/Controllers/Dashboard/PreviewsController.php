<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Preview;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:previews-read')->only('index', 'show');
        $this->middleware('permission:previews-create')->only('create', 'store');
        $this->middleware('permission:previews-update')->only('edit', 'update');
        $this->middleware('permission:previews-delete|previews-trash')->only('destroy', 'trashed');
        $this->middleware('permission:previews-restore')->only('restore');
    }

    public function index()
    {


        $previews = Preview::where('created_by', Auth::id())
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);

        $stages = Stage::all();

        return view('dashboard.previews.index', compact('previews', 'stages'));
    }
}
