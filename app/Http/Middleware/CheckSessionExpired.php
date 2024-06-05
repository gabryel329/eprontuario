<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (time() - $request->session()->get('last_activity', time()) > config('session.lifetime') * 60) {
                Auth::logout();
                return redirect()->route('error.419');
            }
            $request->session()->put('last_activity', time());
        }

        return $next($request);
    }
}
