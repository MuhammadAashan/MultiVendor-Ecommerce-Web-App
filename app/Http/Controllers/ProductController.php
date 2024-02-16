<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use DataTables;


class ProductController extends Controller
{

    //-------------function to Show high rating products
    public function recommendedproduct()
    {
        $products = DB::table('product')
        ->select('product.*', DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'), DB::raw('COUNT(orderdetail.Order_Id) as total'))
        ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
        ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
        ->havingRaw('ROUND(AVG(orderdetail.Rating), 1) > 3')
        ->limit(30)
        ->orderByDesc('Rating')
        ->get();
        return view('User.index',['products'=>$products]);

    }







    //--------------functions to get unique Subcategoeries for master user page
    public function getuniquesubcategory()
    {
        $categories = DB::table('subcategory')->select('Name')->distinct()->get();
        return response()->json(['category' => $categories]);
    }







    //----------------------function to show product in product page
    public function showproduct(Request $request)
    {
        $search=$request->input('search');
        $category=$request->input('categoryselect');
        Session::put('search', $search);
        Session::put('Option', $category);

        if($search==""){
            $products=DB::table('product')
            ->select('product.*',DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'),DB::raw('COUNT(orderdetail.Order_Id) as total'))
            ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
            ->groupBy('product.ID','product.Subcategory_Id','product.Name','product.Description','product.CoverImage','product.Cost','product.Price','product.Seller_Id','product.Created_at')
            ->get();
            $category=DB::table('subcategory')->get()->unique('Name');;

            return view('User.product',['products'=>$products,'category'=>$category]);
        }
        else{
            if($category==0){
                $products = DB::table('product')
                ->select('product.*', DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'), DB::raw('COUNT(orderdetail.Order_Id) as total'))
                ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
                ->where('product.Name', 'like', '%' . $search . '%')
                ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
                ->get();
                $category=DB::table('subcategory')->get()->unique('Name');
                return view('User.product',['products'=>$products,'category'=>$category]);
            }
            else{
                $products = DB::table('product')
                ->select('product.*', DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'), DB::raw('COUNT(orderdetail.Order_Id) as total'))
                ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
                ->where('product.Name', 'like', '%' . $search . '%')
                ->where('product.Subcategory_Id', $category)
                ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
                ->get();
                $category=DB::table('subcategory')->get()->unique('Name');;

                return view('User.product',['products'=>$products,'category'=>$category]);
            }

        }



    }









    //-----------------function to show product detail
    public function productdetail($id){

        $products=DB::table('product')->where('ID',$id)->get();
        $productimages=DB::table('productimage')->where('Product_Id',$id)->get();
        //Query for average rating
        $avgrating=DB::table('orderdetail')->where('Product_Id',$id)->avg('Rating');
        $avgrating = round($avgrating, 1);


        $productvariation=DB::table('productdetail')
        ->select('productdetail.*', 'productdetail.Color as colorname', 'productdetail.Size as sizename','productdetail.quantity as stock')
        ->where('Product_Id', $id)
        ->get();

        $rating = DB::table('orderdetail')
        ->select('orderdetail.*', 'users.name', 'ordertb.Order_Date')
        ->leftJoin('ordertb', 'orderdetail.Order_Id', '=', 'ordertb.Id')
        ->leftJoin('users', 'ordertb.Customer_Id', '=', 'users.id')
        ->leftJoin('product', 'product.ID', '=', 'orderdetail.Product_Id')
        ->where('orderdetail.Product_Id', $id)
        ->whereNotNull('orderdetail.Rating')
        ->whereNotNull('orderdetail.Feedback')
        ->groupBy('orderdetail.Order_Id', 'orderdetail.Product_Id', 'orderdetail.Quantity', 'orderdetail.Rating', 'orderdetail.Feedback', 'users.name', 'ordertb.Order_Date', 'orderdetail.Seller_Id', 'orderdetail.Product_Size', 'orderdetail.Product_Color', 'orderdetail.Purchase_Price', 'orderdetail.Status')
        ->get();





        $productSubcategoryIds = $products->pluck('Subcategory_Id');
        $relatedProducts = DB::table('product')
    ->select('product.*', DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'), DB::raw('COUNT(orderdetail.Order_Id) as total'))
    ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
    ->whereIn('Subcategory_Id', $productSubcategoryIds)
    ->groupBy('product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
    ->limit(4)
    ->get();

        return view('User.productdetail',['products'=>$products,'productimages'=>$productimages,'rating'=>$rating,'avgrating'=>$avgrating,'productvariation'=>$productvariation,'relatedProducts'=>$relatedProducts]);


    }










        //-------------------function for ajax to get product quantity for selected stock and color in product detial page
        public function getStock(Request $request)
        {
            $productId = $request->input('product_id');
            $color = $request->input('color');
            $size = $request->input('size');

            $stock = DB::table('productdetail')->where('Product_Id', $productId)
                ->where('Color', $color)
                ->where('Size', $size)
                ->value('quantity');
            return response()->json(['stock' => $stock]);
        }














    //-----------------------function to add product to wishlist (function is ajax based)
    public function addtowishlist($id, $color = null, $size = null)
    {
        $customerId = auth()->user()->id;

        if (DB::table('wishlist')->where('Product_Id', $id)
            ->where('Customer_Id', $customerId)
            ->where('Color', $color)
            ->where('Size', $size)
            ->exists()
        )
        {
            $wishlistCount = DB::table('wishlist')->where('Customer_Id', $customerId)->count();
            return Response::json(['success' => true, 'message' => $wishlistCount]);
        }
        else
        {

                // Add the product to the wishlist
                DB::table('wishlist')->insert([
                    'Product_Id' => $id,
                    'Customer_Id' => $customerId,
                    'Color' => $color,
                    'Size' => $size
                ]);


            // Get the updated wishlist count
            $wishlistCount = DB::table('wishlist')->where('Customer_Id', $customerId)->count();

            return Response::json(['success' => true, 'message' => $wishlistCount]);
        }
    }
















        //----------------------function to remove product from wishlist
        public function removewishlistproduct($id,$color=null,$size=null){

            DB::table('wishlist')->where('Product_Id', $id)->where('Customer_Id', auth()->user()->id)->where('Color',$color)->where('Size',$size)->delete();
            $wishlist=DB::table('wishlist')
            ->select('wishlist.*', 'product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
            ->leftjoin('product', 'wishlist.Product_Id', '=', 'product.ID')
            ->leftjoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
            ->where('Customer_Id', auth()->user()->id)
            ->groupBy('wishlist.Customer_Id','wishlist.product_Id','wishlist.Color','wishlist.Size','wishlist.Created_at','product.ID','product.Subcategory_Id','product.Name','product.Description','product.CoverImage','product.Cost','product.Price','product.Seller_Id','product.Created_at')
            ->get();

            return Response::json(['success' => true, 'message' => $wishlist]);


        }















        //-----------function to show wishlisted items
        public function wishlisteditems(){
            $wishlist = DB::table('wishlist')
            ->select('wishlist.*', 'product.*', DB::raw('SUM(productdetail.Quantity) as stock'))
            ->leftJoin('product', 'wishlist.Product_Id', '=', 'product.ID')
            ->leftJoin('productdetail', 'product.ID', '=', 'productdetail.Product_Id')
            ->where('Customer_Id', auth()->user()->id)
            ->groupBy('wishlist.Customer_Id', 'wishlist.product_Id', 'wishlist.Created_at','wishlist.Color','wishlist.Size', 'product.ID', 'product.Subcategory_Id', 'product.Name', 'product.Description', 'product.CoverImage', 'product.Cost', 'product.Price', 'product.Seller_Id', 'product.Created_at')
            ->get();

        $productvariation = DB::table('productdetail')
            ->select('productdetail.*', 'productdetail.Color as colorname', 'productdetail.Size as sizename')

            ->whereIn('productdetail.Product_Id', $wishlist->pluck('Product_Id'))
            ->get();



            return view('User.wishlist',['wishlist'=>$wishlist]);

        }















        //-----------function to count wishlisted product(function is ajax based)
        public function wishlistbadge(){

                $wishlistCount = DB::table('wishlist')->where('Customer_Id', auth()->user()->id)->count();
                return Response::json(['success' => true, 'message' => $wishlistCount]);
         }














         //-------------------function to show categories on user search bar
         public function categoryoptionforsearch(){
            $catdata = DB::table('subcategory AS c')
            ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description')
            ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
            ->get();
            return Response::json(['success' => true, 'message' => $catdata]);
         }

















         //------------------function to show categoery in category page
         public function showcat()
         {
            $catdata=DB::table('subcategory AS c')
            ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description',DB::raw('COUNT(product.subcategory_Id) as totalproducts'))
            ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
            ->leftjoin('product','c.Id','product.Subcategory_Id')
            ->groupBy('d.ID', 'd.Name', 'c.Id', 'c.Name', 'c.Description')
            ->get();
            return view('User.category',['catdata'=>collect($catdata)]);
         }

















         //---------function to show product according to categroies they selected
         public function categorywiseproduct($id){
            $catid=trim(DB::table('subcategory')->where('Id',$id)->pluck('Id'),'["]');
            $catname=trim(DB::table('subcategory')->where('Name',$id)->pluck('Name')->unique(),'["]');
            if($catid==$id)
            {
                $products=DB::table('product')
                ->select('product.*','subcategory.Name as categoryname',DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'),DB::raw('COUNT(orderdetail.Order_Id) as total'))
                ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
                ->leftjoin('subcategory','product.Subcategory_Id','subcategory.Id')
                ->where('Subcategory_Id',$id)
                ->groupBy('product.ID','product.Subcategory_Id','product.Name','product.Description','product.CoverImage','product.Cost','product.Price','product.Seller_Id','product.Created_at','subcategory.Name')
                ->get();
                $catdata=DB::table('subcategory AS c')
                ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description',DB::raw('COUNT(product.subcategory_Id) as totalproducts'))
                ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
                ->leftjoin('product','c.Id','product.Subcategory_Id')
                ->groupBy('d.ID', 'd.Name', 'c.Id', 'c.Name', 'c.Description')
                ->get();
                return view('User.categoryproduct',['products'=>$products,'catdata'=>$catdata]);

            }
            elseif($catname==$id){

                $products=DB::table('product')
                ->select('product.*','subcategory.Name as categoryname',DB::raw('ROUND(AVG(orderdetail.Rating), 1) AS Rating'),DB::raw('COUNT(orderdetail.Order_Id) as total'))
                ->leftJoin('orderdetail', 'product.ID', '=', 'orderdetail.Product_Id')
                ->leftjoin('subcategory','product.Subcategory_Id','subcategory.Id')
                ->where('subcategory.Name',$id)
                ->groupBy('product.ID','product.Subcategory_Id','product.Name','product.Description','product.CoverImage','product.Cost','product.Price','product.Seller_Id','product.Created_at','subcategory.Name')
                ->get();
                $catdata=DB::table('subcategory AS c')
                ->select('d.ID', 'd.Name as categoryname', 'c.Id', 'c.Name', 'c.Description',DB::raw('COUNT(product.subcategory_Id) as totalproducts'))
                ->join('category AS d', 'd.ID', '=', 'c.Category_Id')
                ->leftjoin('product','c.Id','product.Subcategory_Id')
                ->groupBy('d.ID', 'd.Name', 'c.Id', 'c.Name', 'c.Description')
                ->get();
                return view('User.categoryproduct',['products'=>$products,'catdata'=>$catdata]);
            }
         }





















         //-----------------function to add product to cart in local storage
         public function addtocart(Request $request){
            $productId = $request->input('product_id');
            $inputSize = $request->input('sizeof');
            $inputColor = $request->input('colorof');
            $quantity = $request->input('quantity');

            $product = DB::table('product')->where('ID', $productId)->first();

            // Create an array to represent the product item
            $item = [
                'id' => $product->ID,
                'name' => $product->Name,
                'price' => $product->Price,
                'image' => $product->CoverImage,
                'size' => $inputSize,
                'color' => $inputColor,
                'quantity' => $quantity,
                // Add any other necessary product details
            ];

            // Retrieve the existing cart items from the session
            $cartItems = json_decode($request->session()->get('cart', '[]'), true);

            // Check if the same product with the same size and color already exists in the cart
            $existingItemKey = array_search(function ($value) use ($productId, $inputSize, $inputColor) {
                return $value['id'] == $productId && $value['size'] == $inputSize && $value['color'] == $inputColor;
            }, array_column($cartItems, null, 'id'));

            if ($existingItemKey !== false) {
                // If the same item exists, increment its quantity
                $cartItems[$existingItemKey]['quantity'] += $quantity;
            } else {
                // If the item doesn't exist, add it to the cart array
                $cartItems[] = $item;
            }

            // Store the updated cart items in the session
            $request->session()->put('cart', json_encode($cartItems));

            // Calculate the total cart count
            $cartCount = count($cartItems);

            return response()->json(['success' => true, 'cartCount' => $cartCount]);



         }



















           //-----------function to count cart item product(function is ajax based)
        public function addtocartbadge(){
            $cartItems = json_decode(session('cart', '[]'), true);
            $cartCount = count($cartItems);

            return response()->json(['success' => true, 'cartCount' => $cartCount]);
     }



















     //----------------------get products for cart page from local storage of project
     public function getproductforcart(){
        $cartItems = json_decode(session('cart', '[]'), true);
        $mergedItems = [];

        foreach ($cartItems as $item) {
            $key = $item['id'] . '-' . $item['size'] . '-' . $item['color'];

            if (isset($mergedItems[$key])) {
                // If the item already exists, increment its quantity
                $mergedItems[$key]['quantity'] += $item['quantity'];
            } else {
                // If the item doesn't exist, add it to the merged items array
                $mergedItems[$key] = $item;
            }
        }

        $mergedItems = array_values($mergedItems);

        return view('User.cart', ['cartItems' => $mergedItems]);

     }















     //----------------function to remove product from cart
     public function removeFromCart(Request $request, $productId, $inputColor = null, $inputSize = null)
     {
         // Retrieve the existing cart items from the session
         $cartItems = json_decode($request->session()->get('cart', '[]'), true);

         // Find the indexes of the products to remove in the cart array
         $indexes = array_keys(array_filter($cartItems, function ($item) use ($productId, $inputColor, $inputSize) {
             return $item['id'] == $productId &&
                    ($inputColor === null || $item['color'] == $inputColor) &&
                    ($inputSize === null || $item['size'] == $inputSize);
         }));

         // Remove the products from the cart if found
         if (!empty($indexes)) {
             foreach ($indexes as $index) {
                 unset($cartItems[$index]);
             }
             $cartItems = array_values($cartItems); // Reset array keys
             $request->session()->put('cart', json_encode($cartItems));
         }

         // Redirect or return a response as needed
         return redirect()->back()->with('success', 'Products removed from cart.');
     }















     //------------------function to place order
     public function orderplaced(Request $request)
     {
       $orderDetailData = $request->input('orderDetails');

       foreach ($orderDetailData as $orderDetail) {
        $address = $orderDetail['address'];
        $totalbill = $orderDetail['totalbill'];
        $mobileno=$orderDetail['mobileno'];
       }

       $orderId = DB::table('ordertb')->insertGetId([
         'Customer_Id' => auth()->user()->id,
         'TotalBill' => $totalbill,
         'DeliveryAddress' => $address,
         'MobileNo'=>$mobileno,
         'Order_Date' => Carbon::now()
       ]);

       $orderDetails = [];
       $productsToRemove = [];

       foreach ($orderDetailData as $orderDetail) {
         $productId = $orderDetail['productId'];
         $quantity = $orderDetail['quantity'];
         $price = $orderDetail['price'];
         $color = $orderDetail['color'];
         $size = $orderDetail['size'];

         $pr = str_replace(',', '', str_replace('Rs ', '', $price)); // Remove commas and "Rs:" prefix from the price

         $sellerId = DB::table('product')->where('ID', $productId)->pluck('Seller_Id')->first();

         $orderDetails[] = [
           'Order_Id' => $orderId,
           'Seller_Id' => $sellerId,
           'Product_Id' => $productId,
           'Product_Size' => $size,
           'Product_Color' => $color,
           'Quantity' => $quantity,
           'Purchase_Price' => $pr,
           'Status' => 'placed'
         ];

      // Keep track of products to remove
      $productsToRemove[] = [
        'Product_Id' => $productId,
        'Product_Size' => $size,
        'Product_Color' => $color
     ];
  }

  // Remove the products from the cart
  $cart = $request->session()->get('cart');
  if (!empty($cart)) {
     foreach ($productsToRemove as $productToRemove) {
        $productId = $productToRemove['Product_Id'];
        $size = $productToRemove['Product_Size'];
        $color = $productToRemove['Product_Color'];

        // Remove the specific product from the cart
        if (isset($cart[$productId][$size][$color])) {
           unset($cart[$productId][$size][$color]);

           // If all sizes and colors for a product are removed, remove the product entry completely
           if (empty($cart[$productId][$size])) {
              unset($cart[$productId][$size]);
           }

           // If all sizes are removed for a product, remove the product entry completely
           if (empty($cart[$productId])) {
              unset($cart[$productId]);
           }
        }
     }

     // Update the modified cart in the session
     $request->session()->put('cart', $cart);
         DB::table('productdetail')->where('Product_Id', $productId)->where('Size',$size)->where('Color',$color)->decrement('Quantity', $quantity);
       }

       $order=DB::table('orderdetail')->insert($orderDetails);
       $request->session()->forget('cart');

       $seller = DB::table('users')->where('id',$sellerId)->first();


       return response()->json(['message' => 'Order placed successfully']);



       // Send the notification to the seller

       $seller = DB::table('users')->where('id',$sellerId)->first();
       Notification::send($seller, new OrderPlacedNotification);

// $email = trim(DB::table('users')->where('id',$sellerId)->pluck('email'),'["]');
     //  Notification::route('mail', $email)
      // ->notify(new OrderPlacedNotification);
     }






























     //-----------function to edit user information for my account page in user end
     public function editmyaccount(Request $request){
        $id=$request->input('id');
        $name=$request->input('name');
        $email=$request->input('email');
        $mobileno=$request->input('mobileno');
        $cnic=$request->input('cnic');
        $address=$request->input('address');
        DB::table('users')->where('id',auth()->user()->id)->update(['name'=>$name,'email'=>$email,'mobileno'=>$mobileno,'cnic'=>$cnic,'address'=>$address]);
        return redirect()->back()->withInput();
     }

















     //----------- function to change password of customer
     public function changepassword(Request $request){

        $id=$request->input('id');
        $currentpassword=$request->input('currentpassword');
        $newpassword=$request->input('newpassword');
        $confirmnewpassword=$request->input('confrimnewpassword');
        $match=trim(DB::table('users')->where('id',$id)->pluck('password'),'["]');
        if(hash::check($currentpassword,$match)){
            if($newpassword==$confirmnewpassword)
            {
                DB::table('users')->where('id',$id)->update(array('password'=>hash::make($confirmnewpassword)));
                return redirect()->back()->withInput();
            }
            else{
                return redirect()->back()->withErrors('confirm password')->withInput();
            }

        }
        else{
            return redirect()->back()->withErrors('password mismatched')->withInput();
        }

     }














     //--------------------functions to show order made by the current user its reviews and all detials
     public function getmyorders(Request $request)
     {


        $orderdata = DB::table('ordertb')
        ->select('ordertb.Id', 'ordertb.Customer_Id', 'ordertb.TotalBill', 'ordertb.DeliveryAddress', 'ordertb.Order_Date', 'ordertb.MobileNo',
            'orderdetail.Status','product.ID AS product_id', 'product.Name AS productname', 'product.CoverImage AS productimage'
        )
        ->join('orderdetail', 'orderdetail.Order_Id', 'ordertb.Id')
        ->join('product', 'product.Id', 'orderdetail.Product_Id')
        ->where('ordertb.Customer_Id', auth()->user()->id)
        ->groupBy(
            'ordertb.Id', 'ordertb.Customer_Id', 'ordertb.TotalBill', 'ordertb.DeliveryAddress', 'ordertb.Order_Date', 'ordertb.MobileNo',
            'orderdetail.Status', 'product.ID', 'product.Name', 'product.CoverImage'
        )
        ->orderByDesc('ordertb.Order_Date')
        ->get();


         return view('User.myorder', ['orderdata' => $orderdata]);
     }







     //---------------------function to view order----------------
     public function vieworder(Request $request)
     {
        setlocale(LC_TIME, 'en_US');
        $id=$request->input('id');
        $orderDetail=DB::table('orderdetail')
        ->select('orderdetail.*','product.Name','product.ID','product.CoverImage','ordertb.Order_Date')
        ->join('product','product.ID','orderdetail.Product_Id')
        ->join('ordertb','ordertb.Id','orderdetail.Order_Id')
        ->where('Order_Id',$id)->get();
        $productId = $orderDetail->pluck('ID')->toArray();

        $complaint=DB::table('complaint')->where('Product_Id',$productId)->where('Customer_Id',auth()->user()->id)->get();
        return view('User.vieworder',['orderDetail'=>$orderDetail,'complaint'=>$complaint]);
     }





     //--------------------function to rate product
     public function rateproduct(Request $request)
     {
        $id=$request->input('productId');
        $order_Id=$request->input('orderId');
        $rating=$request->input('rating');
        $feedback=$request->input('feedback');

        DB::table('orderdetail')->where('Order_Id',$order_Id)->where('Product_Id',$id)->update(['Rating'=>$rating,'Feedback'=>$feedback]);
        return response()->json(['success'=>true]);

     }






     //-------------function to complaint on product
     public function complain_on_product(Request $request){

        $id=$request->input('id');
        $custid=auth()->user()->id;
        $complaint=$request->input('complaint');
        if(DB::table('complaint')->where('Customer_Id',$custid)->where('Product_Id',$id)->exists()){
            return response()->json(['success'=>false]);
        }
        else{
            DB::table('complaint')->insertGetId(['Customer_Id'=>$custid,'Product_Id'=>$id,'Description'=>$complaint]);
            return response()->json(['success'=>true]);
        }


     }






     //---------------function to cancel order from user side
     public function cancelorder($id,$prodid){
        $size = DB::table('orderdetail')->where('Order_Id', $id)->where('Product_Id', $prodid)->pluck('Product_Size')->first();
        $size = $size !== null ? trim($size, '["]') : '';

        $color = DB::table('orderdetail')->where('Order_Id', $id)->where('Product_Id', $prodid)->pluck('Product_Color')->first();
        $color = $color !== null ? trim($color, '["]') : '';

        $quantity = DB::table('orderdetail')->where('Order_Id', $id)->where('Product_Id', $prodid)->pluck('Quantity')->first();
        $quantity = $quantity !== null ? trim($quantity, '["]') : '';
       // Check the values before proceeding with the next querie
        DB::table('productdetail')->where('Product_Id',$prodid)->orwhere('Size',$size)->where('Color',$color)->increment('Quantity',$quantity);
        DB::table('orderdetail')
        ->where('Order_Id',$id)
        ->where('Product_Id',$prodid)
        ->orwhere('Product_Size',$size)
        ->where('Product_Color',$color)
        ->where('Quantity',$quantity)
        ->update(['Status'=>'cancelled']);

//return $size.$color.$quantity.$incremtn.$update;
        //$sellerId = DB::table('product')->where('ID', $prodid)->pluck('Seller_Id')->first();
      //  $sellerId->notify(new OrderCancelledNotification($sellerId));
       return redirect()->back()->withInput();
     }













     //-----------------function to get my reviews
     public function myreviews()
     {
        $reviews=DB::table('orderdetail')
        ->select('orderdetail.*','ordertb.Order_Date','product.Name','product.Price','product.ID','product.CoverImage')
        ->join('ordertb','ordertb.Id','orderdetail.Order_Id')->join('product','orderdetail.Product_Id','product.ID')
        ->where('ordertb.Customer_Id',auth()->user()->id)
        ->whereNotNull('orderdetail.Rating')
        ->whereNotNull('orderdetail.Feedback')
        ->get();
        return view('User.myreviews',['reviews'=>$reviews]);
     }


    }



