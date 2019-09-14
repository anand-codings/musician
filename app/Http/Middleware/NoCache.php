<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Session;
class NoCache {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::guard('user')->check()) {
            if (!Auth::user()->is_active) {
                Session::flash('welcomeback', 'Welcome back!');
                User::where('id', Auth::user()->id)->update(['is_returned' => 1]);
            }
            User::where('id', Auth::user()->id)->update(['is_online' => 1, 'is_active' => 1]);
        }
        $response = $next($request);
        $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        return $response;
    }

}
