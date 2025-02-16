<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfQuestionAsked
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->permisao_id == 1 || Auth::user()->permisao_id == 2)) {
            if (!$request->session()->has('question_asked')) {
                $request->session()->put('question_asked', false);
            }
        }

        return $next($request);
    }
}