<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // dd(Auth::guard($guard), $guard);
                // return redirect()->intended(RouteServiceProvider::HOME);
                return $next($request);
            }

            // dd(Auth::guard($guard), $guard);
            if (Auth::guard()->check()) {
                // $request->session()->put('url.intended', $request->session()->get('/dashboard'));
                // return $next($request);
                return redirect('/dashboard');
                // }
            }else if (Auth::guard('admin')->check()) {
                
                // $request->session()->put('url.intended', $request->session()->get('/admin/dashboard'));
                return redirect('/admin/dashboard');
            }
            // return redirect()->intended(RouteServiceProvider::HOME);
            // Auth::guard()->logout();
        }
        // return $next($request);

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();
        return redirect()->guest('/login');
    }
}
