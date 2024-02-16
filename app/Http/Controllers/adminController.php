<?php

namespace App\Http\Controllers;
use App\Models\admin;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use DataTables;


class adminController extends Controller
{



    //------------------------------------analytics--------------------------------

    public function analytics()
    {
        $data =DB::table('product')
        ->select(
            DB::raw('(SELECT COUNT(*) FROM product) as totalProducts'),
            DB::raw('(SELECT COUNT(Order_Id) FROM orderdetail) as totalOrders'),
            DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE Status = "placed") as pendingOrders'),
            DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE Status = "cancelled") as cancelledOrders'),
            DB::raw('(SELECT ROUND(AVG(Rating), 1) FROM orderdetail) as overallRating'),
            DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE Status = "delivered") as deliveredOrders'),
            DB::raw('(SELECT SUM(Purchase_Price * Quantity) FROM orderdetail WHERE Status = "delivered") as totalSale'),
            DB::raw('(SELECT ROUND(((SUM(orderdetail.Purchase_Price * orderdetail.Quantity) - SUM(product.Cost * orderdetail.Quantity)) / 100) * 10, 0) FROM orderdetail JOIN product ON product.ID = orderdetail.Product_Id WHERE orderdetail.Status = "delivered") as earning'),
            DB::raw('(SELECT COUNT(*) FROM users WHERE role = "customer") as totalCustomers'),
            DB::raw('(SELECT COUNT(*) FROM users WHERE role = "seller") as totalSellers')
        )
        ->first();
        $products = DB::table('product')
    ->join('users', 'product.Seller_Id', '=', 'users.id')
    ->select('product.Name', 'users.name AS sellerName', DB::raw('AVG(orderdetail.Rating) AS avgRating'))
    ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
    ->whereNotNull('orderdetail.Rating')
    ->groupBy('product.ID', 'product.Name', 'users.name')
    ->orderByDesc('avgRating')
    ->take(10)
    ->get();

        return response()->json(['success' => true, 'data' => $data,'products'=>$products]);

    }






    //--------------------------------Function to get all seller details for admin panel  from users table
    public function getseller(Request $request)
    {

        $search=trim($request->input('search'),'["]');
        if($request->input('search')==""){
            $sellerdata = DB::table('users')
                ->select('shop.*', 'users.name AS sellername', 'users.cnic AS sellercnic', 'users.address AS selleraddress', 'users.email AS selleremail', 'users.mobileno AS sellermobileno')
                ->join('shop', 'users.id', '=', 'shop.Seller_Id')
                ->where('users.role', '=', 'seller')
                ->get();

        return view('admin.seller',['sellerdata'=>$sellerdata]);
        }
        else{
            $sellerdata = DB::table('users')
                ->select('shop.*', 'users.name AS sellername', 'users.cnic AS sellercnic', 'users.address AS selleraddress', 'users.email AS selleremail', 'users.mobileno AS sellermobileno')
                ->join('shop', 'users.id', '=', 'shop.Seller_Id')
                ->where('users.role', '=', 'seller')
                ->where('users.name', 'LIKE', '%' . $search . '%')
                ->get();
        return view('admin.seller',['sellerdata'=>$sellerdata]);
        }


    }








    //-------------------------------Function to get all customer details for admin panel from users table
    public function getcustomer(Request $request)
    {
        $search=trim($request->input('search'),'["]');
        //Session::put('search', $search);
        if($request->input('search')==""){
            $customerdata=DB::table('users')->where('role','customer')->get();
            return view('admin.customer',['customerdata'=>$customerdata]);
        }
        else{
            $customerdata=DB::table('users')->where('role','customer')->where('name', 'LIKE', '%'.$search.'%')->get();
            return view('admin.customer',['customerdata'=>$customerdata]);
        }


    }






    //-------------------------------Function to remove customer from users table
    public function removecustomer(Request $request)
    {
        $status=$request->input('ID');
        DB::table('users')->where('id',$status)->delete();
      return redirect()->back()->withInput();
    }










    ////-------------------------------Function to approve seller from users table
    public function approvedseller(Request $request)
    {
        $status=$request->input('ID');
        DB::table('shop')->where('ID',$status)->update(['status'=>"Approved"]);
        return redirect()->back()->withInput();
    }







    //-------------------------------Function to block seller from users table
    public function blockseller(Request $request)
    {
        $status=$request->input('ID');
        DB::table('shop')->where('ID',$status)->update(['status'=>"Block"]);
        return redirect()->back()->withInput();
    }







    //-----------------------function to change password of admin
    public function changepassword(Request $request){
        $id=$request->input('id');
        $oldpassword=$request->input('oldpassword');
        $newpassword=$request->input('newpassword');
        $confrimnewpassword=$request->input('conpassword');
        if($newpassword==$confrimnewpassword){
            DB::table('users')->where('id',$id && 'password',$oldpassword)->update(['password'=>hash::make($confrimnewpassword)]);
            return view('admin.changepassword');
        }
        else{
            return redirect()->back()->withErrors('Please Confirm password');

        }
    }






    //--------------------function to go to settings
    public function setting(){
        return view ('admin.setting');
    }









    //---------------------------function to get all admins from users table to admin panel display
    public function getadmin(Request $request){


        $search=trim($request->input('search'),'["]');
        //Session::put('search', $search);
        if($request->input('search')==""){
            $admindata=DB::table('users')->where('role','admin')->get();
            return view('admin.admins',['admindata'=>$admindata]);
        }
        else{
            $admindata=DB::table('users')->where('role','admin')->where('name', 'LIKE', '%'.$search.'%')->get();
        return view('admin.admins',['admindata'=>$admindata]);
        }




    }









     //---------------------------function to edit admin from users table to admin panel display
    public function editadmin(Request $request){
        $id=$request->input('id');
        $name=$request->input('name');
        $email=$request->input('email');
        $mob=$request->input('mobileno');
        $password=$request->input('password');
        $role=$request->input('role');
        if($id=="" ||$name==""|| $email==""|| $mob==""||$password==""||$role==""){
            return redirect()->back()->withErrors('Please fill the admin information');

        }
        else{
            DB::table('users')->where('id',$id)->update(['name'=>$name,'email'=>$email,'mobileno'=>$mob,'password'=>$password,'role'=>$role]);
            return redirect()->back()->withInput();


        }

    }







     //---------------------------function to add new admin to users table from admin panel display
    public function addadmin(Request $request){
        $name=$request->input('name');
        $email=$request->input('email');
        $mob=$request->input('mobileno');
        $password=$request->input('password');
        if($name==""|| $email==""|| $mob==""||$password==""){
            return redirect()->back()->withErrors('Please input all admin information!');
        }
        else{
            DB::table('users')->insertGetId(['name'=>$name,'email'=>$email,'mobileno'=>$mob,'password'=>Hash::make($password),'role'=>'admin']);
           return redirect()->back()->withInput();
        }
    }










     //---------------------------function to delete admin from users table to admin panel display
    public function removeadmin(Request $request){
            $id=$request->input('ID');
            DB::table('users')->where('id',$id)->delete();
            return redirect()->back()->withInput();

    }










     //---------------------------function to update admin from users table to admin panel display
    public function updateadmin(Request $request){
        $id=$request->input('id');
        $name=$request->input('name');
        $email=$request->input('email');
        $mobileno=$request->input('mobileno');
        $address=$request->input('address');
        DB::table('users')->where('id',$id)->update(['name'=>$name,'email'=>$email,'mobileno'=>$mobileno,'address'=>$address]);
        return redirect()->back()->withInput();

    }









    //-----------------------------function to getvalues for sizes
    public function getdataforsize(Request $request){

        $search=trim($request->input('search'),'["]');
        if($request->input('search')==""){
            $subcategorydata = DB::table('subcategory')
            ->select('subcategory.*', 'category.Name as maincategoryname')
            ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
            ->get();

            $categorydata = DB::table('category AS c1')
            ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
            ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
            ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
            ->get();

            $sizelist = DB::table('productsize')
            ->select('productsize.*', 'subcategory.Name as subcategoryname', 'category.Name as categoryname')
            ->leftJoin('subcategory', 'subcategory.Id', '=', 'productsize.Subcategory_Id')
            ->leftJoin('category', 'category.ID', '=', 'subcategory.Category_Id')
            ->get();

              Return view('admin.size',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata,'sizelist'=>$sizelist]);
        }
        else{
            $subcategorydata = DB::table('subcategory')
            ->select('subcategory.*', 'category.Name as maincategoryname')
            ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
            ->get();

            $categorydata = DB::table('category AS c1')
            ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
            ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
            ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
            ->get();

            $sizelist = DB::table('productsize')
                        ->select('productsize.*', 'subcategory.Name as subcategoryname', 'category.Name as categoryname')
                        ->leftJoin('subcategory', 'subcategory.Id', '=', 'productsize.Subcategory_Id')
                        ->leftJoin('category', 'category.ID', '=', 'subcategory.Category_Id')
                        ->where('productsize.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('subcategory.Name', 'LIKE', '%' . $search . '%')
                        ->orWhere('category.Name', 'LIKE', '%' . $search . '%')
                        ->get();

              Return view('admin.size',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata,'sizelist'=>$sizelist]);
        }

    }









    //-----------------------------function to getvalues for color
    public function getdataforcolor(Request $request){

        $search=trim($request->input('search'),'["]');
        //Session::put('search', $search);
        if($request->input('search')==""){

          $colorlist=DB::table('productcolor')->get();
              Return view('admin.color',['colorlist'=>$colorlist]);
        }
        else{

          $colorlist=DB::table('productcolor')->where('name','like','%'.$search.'%')->get();
              Return view('admin.color',['colorlist'=>$colorlist]);
        }

    }








    //-----------------------function to add data in color table
    public function putincolor(Request $request){

        $colorname=$request->input('catname');
        if($colorname==""){
            return Redirect::back()->withErrors($colorname.' Please Enter Color name');

           }
           else{
        DB::table('productcolor')->InsertGetId(['Name'=>$colorname]);
        return redirect()->back()->withInput();

    }
    }








    //--------Function to delete value from color table
    public function delcolor(Request $request){
        $cid=$request->input('catidp');
        DB::table('productcolor')->where('ID',$cid)->delete();
        return redirect()->back()->withInput();
    }










    //--------------------------function to edit color table
    public function editcolor(Request $request){
        $cid=$request->input('catid');
        $name=$request->input('catname');
        DB::table('productcolor')->where('ID',$cid)->update(['Name'=>$name]);
        return redirect()->back()->withInput();
    }












    //------------------------function to delete Product Sizes from productsize table
    public function delsize(Request $request){
        $id=$request->input('catidp');
        DB::table('productsize')->where('ID',$id)->delete();
        return redirect()->back()->withInput();

    }








    //------------------------function to delete Product Sizes from productsize table
public function editsize(Request $request){
    $id=$request->input('catid');
    $name=$request->input('catname');
    DB::table('productsize')->where('ID',$id)->update(['Name'=>$name]);
    return redirect()->back()->withInput();

}






     //function to add size in productsize table
     public function addsize(Request $request){
        $cat=$request->input('cat');
        $name=$request->input('catname');
        if($name=="")
        {
            return Redirect::back()->withErrors($name.' Please Enter Size Value');

       }
        else{
        DB::table('productsize')->InsertGetId(['Name'=>$name,'Subcategory_Id'=>$cat]);
        return redirect()->back()->withInput();
        }

     }








     //---------------------function to view Reviews
     public function getreviews(){
        $review = DB::table('orderdetail')
        ->select('orderdetail.*', 'ordertb.*', 'users.name')
        ->leftJoin('ordertb', 'orderdetail.Order_Id', '=', 'ordertb.Id')
        ->leftJoin('users', 'users.id', '=', 'ordertb.Customer_Id')
        ->whereNotNull('orderdetail.Rating')
    ->whereNotNull('orderdetail.Feedback')
        ->get();

        return view('admin.review',['review'=>$review]);
     }














     //-------------function to get detail on review detail button
     public function detailonreview(Request $request){
        if($request->id=="")
        {}
        $id=$request->id;
        $data = DB::table('orderdetail')
        ->select('orderdetail.Order_Id', 'product.Name as Productname', 'product.Description', 'product.CoverImage', 'product.Price', 'users.ID', 'users.Name', 'users.Address', 'ordertb.Order_Date')
        ->join('product', 'orderdetail.Product_Id', '=', 'product.ID')
        ->join('ordertb', 'orderdetail.Order_Id', '=', 'ordertb.Id')
        ->join('users', 'product.Seller_Id', '=', 'users.id')
        ->where('orderdetail.Order_Id', $id)
        ->get();

        //return $data;
        return view('admin.viewreview',['data'=>$data]);

     }









     //-----------------function to see complaint
     public function getcomplaint(){
        $complaint = DB::table('complaint')
        ->select('complaint.*', 'users.name')
        ->leftJoin('users', 'users.id', '=', 'complaint.Customer_Id')
        ->get();

        return view('admin.complaint',['complaint'=>$complaint]);
     }









      //-------------function to get detail on review detail button
      public function detailoncomplaint(Request $request){
        if($request->id=="")
        {}
        $id=$request->id;
        $data = DB::table('complaint')
            ->select('complaint.Id', 'complaint.Description as compdesc', 'complaint.Creation_at', 'product.Name as prodname', 'product.Description as proddesc', 'product.CoverImage', 'product.Price', 'users.ID as sellerid', 'users.Name as sellername', 'users.mobileno as sellercont')
            ->join('product', 'complaint.Product_Id', '=', 'product.ID')
            ->join('users', 'product.Seller_Id', '=', 'users.id')
            ->where('complaint.Id', $id)
            ->get();

        //return $data;
        return view('admin.viewcomplaint',['data'=>$data]);

     }









     // //---------------------------function to get all admins from users table to admin panel display
     //----------------------------------------------------------------------------------------------------
     //----------------------------server side scripting---------------------------------------
    public function gadmin(Request $request){
        if ($request->ajax()) {
            $data = DB::table('users')->where('role','admin')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-primary" data-id="'.$row->id.'"
                    data-name="'.$row->name.'" data-email="'.$row->email.'"
                    data-mobileno="'.$row->mobileno.'" data-password="'.$row->password.'"
                    data-role="'.$row->role.'" data-toggle="modal"
                    data-target="#editadminmodel"><i class="bi bi-pen"></i></button> <button type="button" class="btn btn-danger m-1"
                    data-catid="'.$row->id.'" data-toggle="modal"
                    data-target="#demoModal"><i class="bi bi-x-octagon"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.admins1');
    }

}
