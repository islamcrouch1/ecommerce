<?php

namespace App\Http\Middleware;

use App\Models\View;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;


class SetView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (DB::connection()->getDatabaseName() != '' && Auth::check()) {
            $user_id = Auth::id();
            $session_id = null;
        } else {
            $user_id = null;
            $session_id = $request->session()->token();
        }

        $ip =  $request->ip();
        $position = Location::get($ip);

        if ($position) {
            $countryName = $position->countryName;
            $regionName = $position->regionName;
            $cityName = $position->cityName;
        } else {
            $countryName = null;
            $regionName = null;
            $cityName = null;
        }

        $device = strval($request->userAgent());




        $view = View::create([
            'user_id' => $user_id,
            'session_id' => $session_id,
            'ip' => $ip,
            'url' => $request->url(),
            'full_url' => $request->fullUrl(),
            'country_name' => $countryName,
            'state_name' => $regionName,
            'city_name' => $cityName,
            'device' => $device,

        ]);


        // $position->ip;
        // $position->countryName;
        // $position->countryCode;
        // $position->regionCode;
        // $position->regionName;
        // $position->cityName;
        // $position->zipCode;
        // $position->latitude;
        // $position->longitude;


        return $next($request);
    }
}
