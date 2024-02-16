<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->role == 'admin'){
                    return redirect(RouteServiceProvider::ADMIN);
                }
                if(auth()->user()->role == 'seller'){
                    if(trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('status'),'["]')=="Approved"){
                        return redirect(RouteServiceProvider::SELLER);
                    }
                    elseif(trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('status'),'["]')=="Block"){
                        return redirect(RouteServiceProvider::BLOCK);
                    }
                    else{
                        return redirect(RouteServiceProvider::UNDERREVIEW);
                    }

                }
                if(auth()->user()->role == 'customer'){
                    return redirect(RouteServiceProvider::CUSTOMER);
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
