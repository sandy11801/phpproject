<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Student
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
        $role = Auth::user()->role;
        if($role == 'admin'){
            return $next($request);
        }elseif($role == 'teacher'){
            return $next($request);
        }elseif($role == 'student'){
            return $next($request);
        }else{
            abort(404);
        }
    }
}
