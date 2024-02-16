<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
Use DataTables;


class registrationController extends Controller
{


//--------------------------function to register seller or customer --------------------------
public function register(Request $data)
{
    $this->validate($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'mobileno'=>['required'],
        'cnic'=>['required','unique:users'],
        'address'=>['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ]);
    if($data->input('check')=='Seller'){
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobileno'=>$data['mobileno'],
            'cnic'=>$data['cnic'],
            'address'=>$data['address'],
            'password' => Hash::make($data['password']),
            'role'=>"seller",
        ]);

        return view('auth.login');
    }
    else{
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobileno'=>$data['mobileno'],
            'cnic'=>$data['cnic'],
            'address'=>$data['address'],
            'password' => Hash::make($data['password']),
            'role'=>"customer",
        ]);

        return view('auth.login');
    }

}
   //
}
