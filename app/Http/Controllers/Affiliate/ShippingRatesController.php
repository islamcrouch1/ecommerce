<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingRatesController extends Controller
{
    public function index()
    {
        $shipping_rates = ShippingRate::whenSearch(request()->search)
            ->whenCountry(Auth::user()->country->id)
            ->latest()
            ->paginate(100);

        return view('affiliate.shipping_rates.index')->with('shipping_rates', $shipping_rates);
    }
}
