<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenMiddleware
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
        // if ($request->session()->exists("dosen")) {
        //     return $next($request);
        // }

        // return redirect("/login");
        if (Auth::guard()->user()) {
            // return $next($request);
            return redirect()->intended('/dashboard');
        // }
        }

        return redirect()->guest('/login');
    }
}
