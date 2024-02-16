<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OrderPlacedNotification;
Use DataTables;


class sellerController extends Controller
{




    public function notifications()
{
    $sellerEmail = auth()->user()->email;
    $notifications = Auth::user()->notifications()->where('notifiable_type', 'App\User')
        ->where('notifiable_id', $sellerEmail)
        ->get();

    return response()->json($notifications);
}




//------------------------Function to create Shop------------------ after Registration
public function newshop(Request $request){

    $sid=$request->input('sellerId');
    $sname=$request->input('shopname');
    $sdesc=$request->input('shopdesc');
    if($sname=="")
    {
        return Redirect::back()->withErrors('Please Enter Shop name');
    }
    elseif($sdesc==""){
        return Redirect::back()->withErrors('Please Enter Shop Description');
    }
    else
    {
    $insertintoshop=DB::table('shop')->insertGetid(array('Seller_Id'=>$sid,'Name'=>$sname,'Description'=>$sdesc));
    if(DB::table('shop')->where('Seller_Id',$sid)->pluck('status')=="Approved"){
        return view('seller.dashboard',);
    }
    else{
        return view('seller.underreview');
    }

}
}










//--------------------static function to get shop name---------------------------
public static function getshopname(){
    return trim(DB::table('shop')->where('Seller_Id',auth()->user()->id)->pluck('Name'),'["]');
}









//------------------------function to get analytics for dashboard
public function analytics(Request $request)
{
    $data = DB::table('product')
    ->select(DB::raw('(SELECT COUNT(*) FROM product WHERE product.Seller_Id = '.auth()->user()->id.') as totalProducts'))
    ->addSelect(DB::raw('(SELECT COUNT(Order_Id) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.') as totalOrders'))
    ->addSelect(DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.' AND Status = "placed") as pendingOrders'))
    ->addSelect(DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.' AND Status = "cancelled") as cancelledOrders'))
    ->addSelect(DB::raw('(SELECT ROUND(AVG(Rating), 1) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.') as overallRating'))
    ->addselect(DB::raw('(SELECT COUNT(*) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.'  AND Status = "delivered") as deliveredOrders'))
    ->addSelect(DB::raw('(SELECT SUM(Purchase_Price * Quantity) FROM orderdetail WHERE orderdetail.seller_Id = '.auth()->user()->id.' AND Status = "delivered") as totalSale'))
    ->addSelect(DB::raw('(SELECT ROUND(((SUM(orderdetail.Purchase_Price * orderdetail.Quantity) - SUM(product.Cost * orderdetail.Quantity)) / 100) * 90, 0)
         FROM orderdetail
         JOIN product ON product.ID = orderdetail.Product_Id
         WHERE orderdetail.Status = "delivered" AND orderdetail.seller_Id = '.auth()->user()->id.') as earning'))
    ->first();

    $lowstock=DB::table('product')
    ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
    ->select('product.*', DB::raw('SUM(productdetail.Quantity) AS stock'))
    ->where('product.Seller_Id', auth()->user()->id)
    ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
    ->havingRaw('stock < 10')
    ->get();
    return response()->json(['success' => true, 'data' => $data,'lowstock'=>$lowstock]);
}










//----------------------------------function to add product fully done-----------------------
public function addprod(Request $request){
    $shop=$request->input('shop');
    $productname=$request->input('name');
    $productdesc=$request->input('desc');
    $productcat=$request->input('cat');
    $productcost=$request->input('cost');
    $productprice=$request->input('price');
    //$productbrand=$request->input('brand');
    $productquantity=$request->input('quantity');
    $file = $request->file('productimage');
        $this->validate($request, [

            'name' => 'required',
            'desc' => 'required',
            'cat' => 'required',
            'price' => 'required',
            'productimage' => 'required',
        ]);
        if ($request->hasFile('productimage')) {
            $image= $request->file('productimage');
            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $path= $request->file('productimage')->storeAs('public/images',$filename);
        DB::table('product')->insertGetid(array('Name'=>$productname,'Description'=>$productdesc,'Subcategory_Id'=>$productcat,'Cost'=>$productcost,'Price'=>$productprice,'CoverImage'=>'images/'.$filename,'Seller_Id'=>auth()->user()->id));}
        $productId= trim(DB::table('product')->where('Name',$productname)->pluck('Id'),'[]');
        $input=$request->all();
            if ($request->hasFile('productimage1')) {
            foreach($input['productimage1'] as $image){
                $filename1 = uniqid() . '_' . $image->getClientOriginalName();
                $path= $image->storeAs('public/images',$filename1);
                DB::table('productimage')->insert(array('Product_Id'=>$productId,'image'=>'images/'.$filename1));
            }
        }

        $id=auth()->user()->id;
        //$productdata=DB::table('product')->where('Seller_Id',$id)->get();
        $productdata = DB::table('product')
                ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
                ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
                ->where('product.Seller_Id', $id)
                ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
                ->get();

        $branddata=DB::table('productbrand')->get();
        $catdata = DB::table('subcategory AS c')
            ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
            ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
            ->get();

        $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
        return view('seller.product',['catdata'=>$catdata,'branddata'=>$branddata,'shop'=>$shop,'productdata'=>$productdata]);

}











//------------------------function to search stock
public function searchstock(Request $request){
    $sid=auth()->user()->id;
    $id=$request->input('id');
    $productsubcategory=trim(DB::table('product')->where('Id',$id)->where('Seller_Id',$sid)->pluck('Subcategory_Id'),'["]');
    if($productsubcategory=="")
    {
        return redirect()->back()->withErrors('Your enter product is not found.'.$productsubcategory);
    }
    elseif($request->input('category')=="")
    {
        $sizesubcategory=DB::table('productsize')->where('Subcategory_Id',$productsubcategory)->get();
        $colorsubcategory=DB::table('productcolor')->get();
        $supplierdata = DB::table('supplier')
        ->join('users', 'supplier.Seller_Id', '=', 'users.id')
        ->select('supplier.*')
        ->where('supplier.Seller_Id', $sid)
        ->get();

        return view('seller.addstock',['sizesubcategory'=>$sizesubcategory,'colorsubcategory'=>$colorsubcategory,'supplierdata'=>$supplierdata,'productsubcategory'=>$productsubcategory,'id'=>$id]);

    }
    else
    {
    $sizesubcategory=DB::table('productsize')->where('Subcategory_Id',$productsubcategory)->get();
    $colorsubcategory=DB::table('productcolor')->get();
    $supplierdata = DB::table('supplier')
    ->join('users', 'supplier.Seller_Id', '=', 'users.id')
    ->select('supplier.*')
    ->where('supplier.Seller_Id', $sid)
    ->get();

    return view('seller.addstock',['sizesubcategory'=>$sizesubcategory,'colorsubcategory'=>$colorsubcategory,'supplierdata'=>$supplierdata,'productsubcategory'=>$productsubcategory,'id'=>$id]);
};

}






//--------------------function to edit product
public function editproduct(Request $request){
    $productid=$request->input('id');
    $productname=$request->input('name');
    $productdesc=$request->input('desc');
    $productcat=$request->input('cat');
    $productcost=$request->input('cost');
    $productprice=$request->input('price');
    DB::table('product')->where('ID',$productid)
    ->update(['Name'=>$productname,'Description'=>$productdesc,'Subcategory_Id'=>$productcat,'Cost'=>$productcost,'Price'=>$productprice]);
    $id=auth()->user()->id;
    $productdata = DB::table('product')
    ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
    ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
    ->where('product.Seller_Id', $id)
    ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
    ->get();
return view('seller.product',['productdata'=>$productdata]);
}









//------------------------function to add stock
public function addstock(Request $request){
    $id=$request->input('id');
    $color=$request->input('color');
    $size=$request->input('size');
    $supplier=$request->input('supplier');
    $quantity=$request->input('quantity');
    $allreadyexists=trim(DB::table('productdetail')->where('Product_Id',$id)->where('Size',$size)->where('Color',$color)->where('Supplier_Id',$supplier)->pluck('Id'),'["]');
    if($allreadyexists==""){

        DB::table('productdetail')->insertGetId(array('Product_Id'=>$id,'Supplier_Id'=>$supplier,'Color'=>$color,'Size'=>$size,'Quantity'=>$quantity));
        $id=auth()->user()->id;
        //$productdata=DB::table('product')->where('Seller_Id',$id)->get();
        $productdata = DB::table('product')
        ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
        ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
        ->where('product.Seller_Id', $id)
        ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
        ->get();

        $branddata=DB::table('productbrand')->get();
        $catdata = DB::table('subcategory AS c')
            ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
            ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
            ->get();

        $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
        return view('seller.product',['catdata'=>$catdata,'branddata'=>$branddata,'shop'=>$shop,'productdata'=>$productdata]);
    }
    else
    {
        DB::table('productdetail')->where('Id',$allreadyexists)->increment('Quantity',$quantity);
        $id=auth()->user()->id;
        //$productdata=DB::table('product')->where('Seller_Id',$id)->get();
        $productdata = DB::table('product')
        ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
        ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
        ->where('product.Seller_Id', $id)
        ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
        ->get();

        $branddata=DB::table('productbrand')->get();
        $catdata = DB::table('subcategory AS c')
            ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
            ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
            ->get();

        $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
        return view('seller.product',['catdata'=>$catdata,'branddata'=>$branddata,'shop'=>$shop,'productdata'=>$productdata]);

};

}






//-----------------------------function to get all supplier
public function getsupplier(Request $request){
    $id=auth()->user()->id;
    $search=trim($request->input('search'),'["]');
    if($request->input('search')=="")
    {
        $supplierdata = DB::table('supplier')
        ->join('users', 'supplier.Seller_Id', '=', 'users.id')
        ->where('supplier.Seller_Id', $id)
        ->select('supplier.*')
        ->get();

    $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
    return view('seller.supplier',['supplierdata'=>$supplierdata,'shop'=>$shop]);
}
    else{
        $supplierdata = DB::table('supplier')
        ->join('users', 'supplier.Seller_Id', '=', 'users.id')
        ->where('supplier.Seller_Id', $id)
        ->where('supplier.name', 'like', '%' . $search . '%')
        ->select('supplier.*')
        ->get();

        $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
        return view('seller.supplier',['supplierdata'=>$supplierdata,'shop'=>$shop]);
    }


}



//----------------------------function to add supplier
public function addsupplier(Request $request){
    $this->validate($request, [
        'name' => 'required',
        'mobileno' => 'required',
        'address' => 'required',
    ]);
    $Name=$request->input('name');
    $mobileno=$request->input('mobileno');
    $address=$request->input('address');
    DB::table('supplier')->insertGetId(array('Name'=>$Name,'MobileNo'=>$mobileno,'Address'=>$address,'Seller_Id'=>auth()->user()->id));
    $id=auth()->user()->id;
    $supplierdata = DB::table('supplier')
    ->join('users', 'supplier.Seller_Id', '=', 'users.id')
    ->where('supplier.Seller_Id', $id)
    ->select('supplier.*')
    ->get();

    $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
    return view('seller.supplier',['supplierdata'=>$supplierdata,'shop'=>$shop]);



}







//----------------------------function to delete supplier
public function delsupplier(Request $request){

    $deleteid=$request->input('ID');
    DB::table('supplier')->where('Id',$deleteid)->delete();
    $id=auth()->user()->id;
    $supplierdata = DB::table('supplier')
    ->join('users', 'supplier.Seller_Id', '=', 'users.id')
    ->where('supplier.Seller_Id', $id)
    ->select('supplier.*')
    ->get();

    $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
    //return view('seller.supplier',['supplierdata'=>$supplierdata,'shop'=>$shop]);
    return  redirect()->back();



}









//----------------------------function to edit supplier
public function editsupplier(Request $request){
    $this->validate($request, [
        'name' => 'required',
        'mobileno' => 'required',
        'address' => 'required',
    ]);
    $id=$request->input('id');
    $Name=$request->input('name');
    $mobileno=$request->input('mobileno');
    $address=$request->input('address');
    DB::table('supplier')->where('Id',$id)->update(['Name'=>$Name,'MobileNo'=>$mobileno,'Address'=>$address,'Seller_Id'=>auth()->user()->id]);
    return  redirect()->back();
    //return view('seller.supplier',['supplierdata'=>$supplierdata,'shop'=>$shop]);



}






   //-----------------------function to get Values after product addition
   public function getcatbrand(Request $request)
   {

    $search=trim($request->input('search'),'["]');
    if($request->input('search')==""){
        $id=auth()->user()->id;
        $productdata = DB::table('product')
        ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
        ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
        ->where('product.Seller_Id', $id)
        ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
        ->get();

        $branddata = DB::table('productbrand')->get();

         $catdata = DB::table('subcategory as c')
        ->join('category as d', 'd.ID', '=', 'c.Category_Id')
        ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
        ->get();

         $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
    return view('seller.product',['catdata'=>$catdata,'branddata'=>$branddata,'shop'=>$shop,'productdata'=>$productdata]);
    }
    else{
        $id=auth()->user()->id;
        //$productdata=DB::table('product')->where('Seller_Id',$id)->get();
        $productdata = DB::table('product')
        ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
        ->select('product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
        ->where('product.Seller_Id', $id)
        ->where('product.Name', 'LIKE', '%' . $search . '%')
        ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
        ->get();

    $branddata = DB::table('productbrand')->get();

    $catdata = DB::table('subcategory as c')
        ->join('category as d', 'd.ID', '=', 'c.Category_Id')
        ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
        ->get();

        $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
        return view('seller.product',['catdata'=>$catdata,'branddata'=>$branddata,'shop'=>$shop,'productdata'=>$productdata]);
    }



   }




   //--------------------------Get Data Before going to Add Product Page
   public function getdataforproductaddition()
   {
    $productdata=DB::table('product')->get();
    $branddata=DB::table('productbrand')->get();
    $subcatdata=DB::table('subcategory')->get();
    $supplierdata = DB::table('supplier')
    ->select('supplier.*')
    ->join('shop', 'shop.ID', '=', 'supplier.Seller_Id')
    ->get();

    $catdata=DB::table('category')
    ->join('subcategory', 'category.Id', '=', 'subcategory.category_Id')
    ->select('category.Id as categoryid', 'category.Name as categoryname', 'subcategory.Id', 'subcategory.Name')
    ->orderBy('category.Id')
    ->get();
    $shop=DB::table('shop')->where('Seller_Id',auth()->user()->id)->get();
    return view('seller.addproduct',['catdata'=>$catdata,'supplierdata'=>$supplierdata,'shop'=>$shop,'subcatdata'=>$subcatdata]);

   }







   //-----------------------function to get data for edit product
   public function getdataforeditproduct($id)
{
    $productdata = DB::table('product')->where('ID', $id)->get();
    $catdata = DB::table('category')
        ->join('subcategory', 'category.Id', '=', 'subcategory.category_Id')
        ->select('category.Id as categoryid', 'category.Name as categoryname', 'subcategory.Id', 'subcategory.Name')
        ->orderBy('category.Id')
        ->get();

    // Get unique categories
    $uniqueCategories = $catdata->unique('categoryid');

    // Get subcategories for the first product
    $firstProduct = $productdata->first();
    $subcategories = DB::table('subcategory')->where('Id', $firstProduct->Subcategory_Id)->get();
    return view('seller.editproduct', [
        'productdata' => $productdata,
        'catdata' => $catdata,
        'uniqueCategories' => $uniqueCategories,
        'subcategories' => $subcategories,
    ]);
}






   //-------------------------function to getvariation
   public function getvariations($id){
    $variations = DB::table('productdetail')->where('Product_Id', $id)->get();
    return response()->json(['variations' => $variations]);

   }





   //-------------------function to delete variation
   public function deletevariation($id){
    if(empty($id)){

    }
    DB::table('productdetail')->where('Id',$id)->delete();
    return response()->json(['success'=>true,'message' => 'Variation deleted successfully']);

   }




    //-----------------------function to change password of seller
    public function changepassword(Request $request){
        $id=$request->input('id');
        $oldpassword=$request->input('oldpassword');
        $newpassword=$request->input('newpassword');
        $confrimnewpassword=$request->input('conpassword');
        if($newpassword==$confrimnewpassword){
            DB::table('users')->where('id',$id && 'password',$oldpassword)->update(['password'=>hash::make($confrimnewpassword)]);
            return view('seller.changepassword');
        }
        else{
            return redirect()->back()->withErrors('Please Confirm password');
    }
}







   //------------------------------------function to delete Product
   public function deleteproduct(Request $request)
   {

    $id=$request->input('catidp');
    $coverimage=DB::table('product')->where('ID',$id)->pluck('CoverImage');
    $images=DB::table('productimage')->where('Product_ID',$id)->pluck('Image');
    foreach($images as $image) {
        Storage::delete('public/'.$image);
    };
   foreach( $coverimage as $cimage) {
        Storage::delete('public/'.$cimage);
    };
    DB::table('product')->where('ID',$id)->delete();
    DB::table('productimage')->where('Product_ID',$id)->delete();
    DB::table('productdetail')->where('Product_Id',$id)->delete();
    DB::table('complaint')->where('Product_Id',$id)->delete();
    DB::table('wishlist')->where('Product_Id',$id)->delete();
    return redirect()->back()->withInput();
   }







   //---------------------------Function TO Update Profile Details of Seller--------------------------
   public function updateseller(Request $request){
    $id=$request->input('id');
    $name=$request->input('name');
    $email=$request->input('email');
    $mobileno=$request->input('mobileno');
    $address=$request->input('address');
    $cnic=$request->input('cnic');
    DB::table('users')->where('id',$id)->update(['name'=>$name,'email'=>$email,'mobileno'=>$mobileno,'address'=>$address,'cnic'=>$cnic]);
    return redirect()->back()->withInput();

}




//-------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------
//-------------------------------------Speicifc Complaints left-----------------------------------

//-----------------function to see complaint
public function getcomplaint(){
    $id=auth()->user()->id;

    $complaint = DB::table('complaint')
    ->join('users', 'users.id', '=', 'complaint.Customer_Id')
    ->join('product', 'complaint.Product_Id', '=', 'product.ID')
    ->where('product.Seller_Id', $id)
    ->select('complaint.*', 'users.name','product.Name as prodname','product.CoverImage')
    ->get();

    return view('seller.complaint',['complaint'=>$complaint]);
 }








 //---------------------------detial on complaint
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

    return view('seller.viewcomplaint',['data'=>$data]);

 }



 //-------------------------------------Speicifc Complaints left-----------------------------------

//-----------------function to see complaint
public function getreview(){
    $id=auth()->user()->id;
    $review = DB::table('orderdetail')
    ->select('orderdetail.*', 'ordertb.*', 'users.name')
    ->leftJoin('ordertb', 'orderdetail.Order_Id', '=', 'ordertb.Id')
    ->leftJoin('users', 'users.id', '=', 'ordertb.Customer_Id')
    ->leftJoin('product', 'orderdetail.Product_Id', '=', 'product.ID')
    ->whereNotNull('orderdetail.Rating')
    ->whereNotNull('orderdetail.Feedback')
    ->where('product.Seller_Id', $id)
    ->get();

    return view('seller.review',['review'=>$review]);
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

    return view('seller.viewreview',['data'=>$data]);

 }









 //-----------------------function to chnage shop name-----------------------
public function editshop(Request $request){
    $id=$request->input('id');
    $shopname=$request->input('name');
    $shopdescription =$request->input('desc');
    $getshopname=DB::table('shop')->where('Seller_Id',$id)->pluck('Name');
    $getallshopname=DB::table('shop')->where('Name',$shopname)->pluck('Name');
    if($shopname==""|| $shopdescription==""){
        return redirect()->back()->withErrors('Please Enter Shop name and Description.');
    }
    elseif(trim($getshopname,'["]')==$shopname){

        return redirect()->back()->withErrors('Same Shop name as before please different to name.');
    }

    elseif(trim($getallshopname,'["]')==$shopname){
        return redirect()->back()->withErrors('some Other shop exists with the same name you entered');

    }
    else{
        DB::table('shop')->where('Seller_Id',$id)->update(array('Name'=>$shopname,'Description'=>$shopdescription));
        return redirect()->back();

    }
}







//----------------------function to get order which is placed
public function orderstatusplaced(){
    $orders=DB::table('orderdetail')
    ->select('orderdetail.*','product.ID','product.Name','Product.CoverImage','ordertb.Order_Date')
    ->join('product','product.ID','orderdetail.Product_Id')
    ->join('ordertb','ordertb.Id','orderdetail.Order_Id')
    ->orderbyDesc('orderdetail.Order_Id')
    ->where('orderdetail.Seller_Id',auth()->user()->id)->where('orderdetail.Status','placed')->get();
    //return $orders
    return response()->json(['success'=>true,'orders'=>$orders]);
}









//--------------------function to deliver order
public function deliverorder(Request $request){
    $productId=$request->input('prod_Id');
    $orderId=$request->input('order_Id');
    DB::table('orderdetail')->where('Product_Id',$productId)
    ->where('Order_Id',$orderId)->where('Seller_Id',auth()->user()->id)->update(['Status'=>'delivered']);
    return redirect()->back()->withInput();
}









//-------------------function to show orders
public function showorders(Request $request){
    $search=trim($request->input('search'),'["]');
    if($request->input('search')=="")
    {
    $orders=DB::table('ordertb')
    ->select('ordertb.*', 'orderdetail.Status','users.name',DB::raw('count(orderdetail.Order_Id) as productcount'))
    ->join('orderdetail', 'orderdetail.Order_Id', 'ordertb.Id')
    ->join('users','users.id','ordertb.Customer_Id')
    ->groupBy(
       'ordertb.Id',
       'ordertb.Customer_Id',
       'users.name',
       'ordertb.TotalBill',
       'ordertb.DeliveryAddress',
       'ordertb.Order_Date',
       'orderdetail.Status',
       'ordertb.MobileNo',

    )
    ->where('orderdetail.Seller_Id',auth()->user()->id)->where('orderdetail.Status','<>','cancelled')->get();
    return view('seller.order',['orders'=>$orders]);
}
    else{
        $orders = DB::table('ordertb')
        ->select('ordertb.*', 'orderdetail.Status', 'users.name', DB::raw('count(orderdetail.Order_Id) as productcount'))
        ->join('orderdetail', 'orderdetail.Order_Id', '=', 'ordertb.Id')
        ->join('users', 'users.id', '=', 'ordertb.Customer_Id')
        ->groupBy(
            'ordertb.Id',
            'ordertb.Customer_Id',
            'users.name',
            'ordertb.TotalBill',
            'ordertb.DeliveryAddress',
            'ordertb.Order_Date',
            'orderdetail.Status',
            'ordertb.MobileNo'
        )
        ->where('orderdetail.Seller_Id', auth()->user()->id)
        ->where('orderdetail.Status', '<>', 'cancelled')
        ->where('ordertb.Id', 'like', '%' . $search . '%')
        ->orwhere('users.name', 'like', '%' . $search . '%')
        ->orwhere('ordertb.DeliveryAddress', 'like', '%' . $search . '%')
        ->get();

        return view('seller.order',['orders'=>$orders]);
    }
}







//--------------------------function to get orderdetial
public function detailbyorder($id){
    $vieworder=DB::table('orderdetail')
        ->select('orderdetail.*','ordertb.TotalBill','product.Name','product.ID','product.CoverImage','ordertb.Order_Date','ordertb.Customer_Id','users.email','users.mobileno')
        ->join('product','product.ID','orderdetail.Product_Id')
        ->join('ordertb','ordertb.Id','orderdetail.Order_Id')
        ->join('users','ordertb.Customer_Id','users.id')
        ->where('Order_Id',$id)->get();
        $productId = $vieworder->pluck('ID')->toArray();
        $custId = $vieworder->pluck('Customer_Id')->toArray();

        $complaint=DB::table('complaint')->where('Product_Id',$productId)->where('Customer_Id',$custId)->get();
    return view('seller.vieworder',['vieworder'=>$vieworder,'complaint'=>$complaint]);
}









//--------------------------function to get orderdetial
public function viewdetailorder($id,$product){
    $vieworder=DB::table('orderdetail')
        ->select('orderdetail.*','ordertb.TotalBill','product.Name','product.ID','product.CoverImage','ordertb.Order_Date','ordertb.Customer_Id','users.email','users.mobileno')
        ->join('product','product.ID','orderdetail.Product_Id')
        ->join('ordertb','ordertb.Id','orderdetail.Order_Id')
        ->join('users','ordertb.Customer_Id','users.id')
        ->where('Order_Id',$id)->get();
    return view('seller.vieworderdetail',['vieworder'=>$vieworder]);
}















//------------------function to show stock summary
public function stocksummary(){

   $data= DB::table('product')
    ->select('product.ID', 'product.Name', DB::raw('COALESCE(stock.totalStock, 0) AS totalStock'), DB::raw('COALESCE(sold.totalSold, 0) AS totalSold'))
    ->join(DB::raw('(SELECT productdetail.Product_Id, SUM(productdetail.Quantity) AS totalStock FROM productdetail WHERE productdetail.Product_Id IN (SELECT ID FROM product WHERE Seller_Id = 3) GROUP BY productdetail.Product_Id) AS stock'), 'product.ID', '=', 'stock.Product_Id')
    ->leftjoin(DB::raw('(SELECT orderdetail.Product_Id, SUM(orderdetail.Quantity) AS totalSold FROM orderdetail WHERE orderdetail.Product_Id IN (SELECT ID FROM product WHERE Seller_Id = 3) GROUP BY orderdetail.Product_Id) AS sold'), 'product.ID', '=', 'sold.Product_Id')
    ->where('product.Seller_Id', auth()->user()->id)
    ->get();


    return view('seller.stocksummary',['data'=>$data]);
}

















//_-------------------------------------ajax based testing function-----------------------
//----------------------------------------
//00--------------------------------------------
 public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}

