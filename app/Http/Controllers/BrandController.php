<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BrandController extends Controller
{
    public function getbrand()
    {
        $brand=DB::table('productbrand')->get();
        return view('admin.brand',['brand'=>$brand]);
    }
    public function storebrand(Request $request){

        $brandname=$request->input('brandname');
        if($brandname==""){
            return redirect()->back()->withErrors('Please enter brand namew');
        }else{
            DB::table('productbrand')->insertgetid(['Name'=>$brandname]);
            $brand=DB::table('productbrand')->get();
            return view('admin.brand',['brand'=>$brand]);
        }


    }
    public function Editbrand(Request $request){
        $brandid=$request->input('brandid');
        $brandname=$request->input('brandname');
        DB::table('productbrand')->where('ID',$brandid)->Update(['Name'=>$brandname]);
        $brand=DB::table('productbrand')->get();
        return view('admin.brand',['brand'=>$brand]);

    }
    public function Deletebrand(Request $request){
        $brandid=$request->input('brandid');
        DB::table('productbrand')->where('ID',$brandid)->delete();
        $brand=DB::table('productbrand')->get();
        return view('admin.brand',['brand'=>$brand]);

    }
}
