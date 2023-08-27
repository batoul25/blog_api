<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;

class CheckAuthor
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
        if( ! $request->user()->id == Post::whereSlug($request->slug)->user->id  ){
            return response()->json([
                'status' => 'error' ,
                'message' => 'Only The Original User Can update and delete their posts'
            ],401);
        }
        return $next($request);
    }
}
