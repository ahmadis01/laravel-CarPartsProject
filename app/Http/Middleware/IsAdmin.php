<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        if(auth()->user()==null)
            return response()->json("you are not auth");
        else if(auth()->user()->role_id==1)
            return $next($request);
        else
            return response()->json('You don\'t have Permissions');
    }
}
