<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.home');
    }

    public function fqs()
    {
        return view('front.fqs');
    }

    public function terms()
    {
        return view('front.terms');
    }
    public function about()
    {
        return view('front.about');
    }
}
