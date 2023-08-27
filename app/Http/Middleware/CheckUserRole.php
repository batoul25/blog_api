<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , ...$role)
    {
        if(Auth::user()){
            if(Auth::user()->role == 'admin'){
                return $next($request);
            }
        }
        return response()->json([
            'sattus' => 'error',
            'message' => 'The user is not Authorized',
        ], 401);
       
    }
}
