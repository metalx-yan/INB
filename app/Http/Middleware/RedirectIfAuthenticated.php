<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/admin/user');
        // }

        if (Auth::guard($guard)->check()) {
            if (Auth::user()->level->name == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->level->name == 'user') {
                return redirect('/user');
            }
        }

        return $next($request);
    }
}
