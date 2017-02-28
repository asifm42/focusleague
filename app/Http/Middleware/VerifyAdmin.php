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
        if (auth()->user()->isAdmin()
            || auth()->user()->isGod()) {
            return $next($request);
        }
        throw new UnauthorizedAccessException('You must be an admin to access this page.');
    }
}
