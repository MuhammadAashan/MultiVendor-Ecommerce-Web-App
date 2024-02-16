<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use auth;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:seller')->except('logout');
    }
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => ['required', 'email', 'regex:/^.*@.*\.com$/i'],
            'password' => 'required',
        ]);

       if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->role == 'admin')
            {
              return view('admin.dashboard');
            }
            elseif (auth()->user()->role == 'seller')
            {
                if(auth()->user()->id==trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('Seller_Id'),'["]'))
                {
                    if(trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('status'),'["]')=="Approved"){

                        return view('seller.dashboard');
                    }
                    elseif(trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('status'),'["]')=="Block"){

                        return view('seller.block');
                    }
                    else{
                        return view('seller.underreview');
                        Route('logout');
                    }
                }
                else{
                    return view('seller.newshop');
                }
              return view('seller.dashboard');
            }
            else
            {
                return redirect(RouteServiceProvider::CUSTOMER);
            }
          //  else{
            //    return redirect()->route('home');
            //}
        }/*
        if(Auth::guard('admin')->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            return view('admin.dashboard');
        }
        elseif(Auth::guard('seller')->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            return view('seller.dashboard');
        }
        elseif(Auth::guard('web')->attempt(array('email' => $input['email'], 'password' => $input['password']))){

        }*/
        else
        {
            //return redirect()->route('login')->with('error','Incorrect email or password!.');
            return redirect()->back()->withErrors('Incorrect email or password!.');
        }
    }
}
