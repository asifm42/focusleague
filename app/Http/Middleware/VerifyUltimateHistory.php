<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUltimateHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->ultimateHistory) {
            return $next($request);
        } else {
            flash()->warning('Please fill out your ultimate history first.');
            return redirect()->route('ultimate_history.create');
        }

    }
}
