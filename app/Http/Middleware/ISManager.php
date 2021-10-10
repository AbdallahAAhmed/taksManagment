<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ISManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'manager') {
            return $next($request);
        }
        abort(505);
        return response()->json('Your dont have permession !');

    }
}
