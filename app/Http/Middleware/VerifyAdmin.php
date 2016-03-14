<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\UnauthorizedAccessException;

class VerifyAdmin
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
        if (auth()->user()->isAdmin()) {
            return $next($request);
        } else {
            throw new UnauthorizedAccessException();
        }
    }
}