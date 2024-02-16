<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \Integer  role
     * @return mixed
     */

    // Add custom parameter $role which pass from Route.php
    public function handle(Request $request, Closure $next,)
    {

        // Check & verify with route, you will more understand
        if(Auth::check() && Auth::user()->role == "admin"||Auth::check() && Auth::user()->role == "seller" ||Auth::check() && Auth::user()->role == "customer")
        {
            return $next($request);
        }/*
        if(Auth::check() && Auth::guard('admin')||Auth::check() && Auth::guard('seller')||Auth::check() && Auth::guard('web'))
        {
            return $next($request);
        }*/
        return response()->json(['You do not have permission to access for this page.']);
    }
}
