<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sellerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('','App\Http\Controllers\ProductController@recommendedproduct');

Auth::routes();


Route::post('/Register','App\Http\Controllers\registrationController@register');
Route::get('/Register',function(){return view('auth.register');});



Route::get('/home',function(){return view('admin.dashboard');});



///-------------Auth for admin with all admin roots
Route::middleware(['auth','user-role:admin'])->group(function()
{



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function()
{
   //Login Route
    Route::get('/dashboard',function(){return view('admin.dashboard');});


    Route::get('/categorylist','App\Http\Controllers\categoryController@getdatafromtable');


    Route::post('/subcategorylist','App\Http\Controllers\categoryController@getdatafromsubcategorylist');
    Route::get('/subcategorylist','App\Http\Controllers\categoryController@putdataincattable');


    Route::post('/addm','App\Http\Controllers\categoryController@putdataincattable');
    Route::get('/addm','App\Http\Controllers\categoryController@getdatafromtable');


    Route::post('/addsubcategory','App\Http\Controllers\categoryController@putdatainsubcattable');
    Route::get('/addsubcategory','App\Http\Controllers\categoryController@getdatafromtable');


    Route::get('/subcategory','App\Http\Controllers\categoryController@getdatafromsubcategory');

    Route::get('/analytics','App\Http\Controllers\adminController@analytics');


    Route::post('/editm','App\Http\Controllers\categoryController@editcat');
    Route::get('/editm','App\Http\Controllers\categoryController@getdatafromtable');


    Route::post('/deletem','App\Http\Controllers\categoryController@deletecat');
    Route::get('/deletem','App\Http\Controllers\categoryController@getdatafromtable');


    Route::get('/brand','App\Http\Controllers\BrandController@getbrand');


    Route::post('/addbrand','App\Http\Controllers\BrandController@storebrand');
    Route::get('/addbrand','App\Http\Controllers\BrandController@getbrand');


    Route::post('/deletebrand','App\Http\Controllers\BrandController@Deletebrand');
    Route::get('/deletebrand','App\Http\Controllers\BrandController@getbrand');


    Route::post('/editbrand','App\Http\Controllers\BrandController@Editbrand');
    Route::get('/editbrand','App\Http\Controllers\BrandController@getbrand');


    Route::post('/editsubcateogry','App\Http\Controllers\categoryController@editsubcat');
    Route::get('/editsubcateogry','App\Http\Controllers\categoryController@getdatafromsubcategory');


    Route::post('/deletesubcategory','App\Http\Controllers\categoryController@deletesubcat');
    Route::get('/deletesubcategory','App\Http\Controllers\categoryController@getdatafromsubcategory');


    Route::get('/logout','App\Http\Controllers\adminController@logout');


    Route::post('/approveseller','App\Http\Controllers\adminController@approvedseller');
    Route::get('/approveseller','App\Http\Controllers\adminController@getseller');


    Route::post('/blockseller','App\Http\Controllers\adminController@blockseller');
    Route::get('/blockseller','App\Http\Controllers\adminController@getseller');


    Route::get('/seller','App\Http\Controllers\adminController@getseller');


    Route::post('/addcolor','App\Http\Controllers\adminController@putincolor');
    Route::get('/addcolor','App\Http\Controllers\adminController@getdataforcolor');


    Route::post('/deletecolor','App\Http\Controllers\adminController@delcolor');
    Route::get('/deletecolor','App\Http\Controllers\adminController@getdataforcolor');


    Route::post('/editcolor','App\Http\Controllers\adminController@editcolor');
    Route::get('/editcolor','App\Http\Controllers\adminController@getdataforcolor');


    Route::get('/color','App\Http\Controllers\adminController@getdataforcolor');


    Route::post('/deletesize','App\Http\Controllers\adminController@delsize');
    Route::get('/deletesize','App\Http\Controllers\adminController@getdataforsize');


    Route::post('/editsize','App\Http\Controllers\adminController@editsize');
    Route::get('/editsize','App\Http\Controllers\adminController@getdataforsize');


    Route::post('/addsize','App\Http\Controllers\adminController@addsize');
    Route::get('/addsize','App\Http\Controllers\adminController@getdataforsize');


    Route::get('/size','App\Http\Controllers\adminController@getdataforsize');


    Route::get('/customer','App\Http\Controllers\adminController@getcustomer');


    Route::post('/removecustomer','App\Http\Controllers\adminController@removecustomer');
    Route::get('/removecustomer','App\Http\Controllers\adminController@getcustomer');


    Route::get('/review','App\Http\Controllers\adminController@getreviews');


    Route::get('/setting','App\Http\Controllers\adminController@setting');


    Route::get('/complaint','App\Http\Controllers\adminController@getcomplaint');


    Route::get('/admins','App\Http\Controllers\adminController@getadmin')->name('adminlist');


    Route::post('/addadmin','App\Http\Controllers\adminController@addadmin');
    Route::get('/addadmin','App\Http\Controllers\adminController@getadmin');


    Route::post('/editadmin','App\Http\Controllers\adminController@editadmin');
    Route::get('/editadmin','App\Http\Controllers\adminController@getadmin');


    Route::post('/removeadmin','App\Http\Controllers\adminController@removeadmin');
    Route::get('/removeadmin','App\Http\Controllers\adminController@getadmin');


    Route::post('/viewreviews','App\Http\Controllers\adminController@detailonreview');
    Route::get('/viewreviews','App\Http\Controllers\adminController@getreviews');


    Route::post('/viewcomplaints','App\Http\Controllers\adminController@detailoncomplaint');
    Route::get('/viewcomplaints','App\Http\Controllers\adminController@getcomplaint');


    Route::post('/updateadmin','App\Http\Controllers\adminController@updateadmin');
    Route::get('/updateadmin','App\Http\Controllers\adminController@setting');


    Route::post('/changepassword','App\Http\Controllers\adminController@changepassword');
    Route::get('/changepassword',function(){return view('admin.changepassword');});


    Route::get('users', ['as' => 'user', 'uses' => 'AdminController@users']);
    Route::get('/test','App\Http\Controllers\adminController@changepassword');
});
});







  // Routes for seller
Route::middleware(['auth','user-role:seller'])->group(function()
{
    //Route::get('/home',function(){return view('seller.dashboard');});


Route::group(['prefix' => 'seller', 'as' => 'seller.'], function()
{
    //Login Route


    Route::get('/notifications', 'App\Http\Controllers\sellerController@notifications')->name('notifications');

    Route::get('/dashboard',function(){return view('seller.dashboard');});

    Route::get('/analytics','App\Http\Controllers\sellerController@analytics');

    Route::get('/dashboard',function(){return view('seller.dashboard');});

    Route::get('/product','App\Http\Controllers\SellerController@getcatbrand');


    Route::post('/newshop','App\Http\Controllers\sellerController@newshop');
    Route::get('/newshop',function(){return view('seller.underreview');});


    Route::post('/reregister','App\Http\Controllers\SellerController@updateseller');
    Route::get('/reregister',function(){return view('auth.login');});


    Route::get('/block',function(){return view('seller.block');});

    Route::get('/underreview',function(){return view('seller.underreview');});

    Route::post('/productadded','App\Http\Controllers\sellerController@addprod');
    Route::get('/productadded','App\Http\Controllers\sellerController@getcatbrand');


    Route::post('/deleteproduct','App\Http\Controllers\sellerController@deleteproduct');
    Route::get('/deleteproduct','App\Http\Controllers\SellerController@getcatbrand');



    Route::get('/supplier','App\Http\Controllers\sellercontroller@getsupplier');


    Route::post('/viewreviews','App\Http\Controllers\sellerController@detailonreview');
    Route::get('/viewreviews','App\Http\Controllers\sellerController@getreview');
    Route::get('/review','App\Http\Controllers\sellerController@getreview');



    Route::get('/addstock',function(){return view('seller.addstock');});

    Route::get('/vieworder/{id}','App\Http\Controllers\sellerController@detailbyorder');


    Route::get('/stocksummary','App\Http\Controllers\sellerController@stocksummary');


    Route::post('/searchproduct','App\Http\Controllers\sellercontroller@searchstock');
    Route::get('/searchproduct',function(){return view('seller.addstock');});


    Route::get('/getvariations/{id}','App\Http\Controllers\sellerController@getvariations');
    Route::get('/deletevariation/{id}','App\Http\Controllers\sellerController@deletevariation');


    Route::get('/editproduct/{id}','App\Http\Controllers\sellerController@getdataforeditproduct');

    Route::post('/editproduct','App\Http\Controllers\sellerController@editproduct');
    Route::get('/editproduct','App\Http\Controllers\SellerController@getcatbrand');

    Route::post('/addstock','App\Http\Controllers\sellercontroller@addstock');
    Route::get('/addstock',function(){return view('seller.addstock');});

    Route::post('/viewcomplaints','App\Http\Controllers\sellerController@detailoncomplaint');
    Route::get('/viewcomplaints','App\Http\Controllers\sellerController@getcomplaint');
    Route::get('/complaint','App\Http\Controllers\sellerController@getcomplaint');

    Route::post('/addsupplier','App\Http\Controllers\sellerController@addsupplier');
    Route::get('/addsupplier','App\Http\Controllers\sellercontroller@getsupplier');



    Route::post('/editsupplier','App\Http\Controllers\sellerController@editsupplier');
    Route::get('/editsupplier','App\Http\Controllers\sellercontroller@getsupplier');

    Route::post('/removesupplier','App\Http\Controllers\sellerController@delsupplier');
    Route::get('/removesupplier','App\Http\Controllers\sellercontroller@getsupplier');




    Route::get('/setting',function(){return view('seller.setting');});


    Route::post('/updateseller','App\Http\Controllers\sellerController@updateseller');
    Route::get('/updateseller',function(){return view('seller.setting');});



    Route::post('/editshop','App\Http\Controllers\sellerController@editshop');
    Route::get('/editshop',function(){return view('seller.setting');});

    Route::get('/addproductform','App\Http\Controllers\sellerController@getdataforproductaddition');

    Route::post('/changepassword','App\Http\Controllers\sellerController@changepassword');
    Route::get('/changepassword',function(){return view('seller.changepassword');});

    Route::post('/deliverproduct','App\Http\Controllers\sellerController@deliverorder');
    Route::get('/deliverproduct',function(){return view('seller.dashboard');});


    Route::get('/viewdetailorder/{id}/{productId}','App\Http\Controllers\sellerController@viewdetailorder');

    Route::get('/orderstatusplaced','App\Http\Controllers\sellerController@orderstatusplaced');

    Route::get('/list','App\Http\Controllers\sellerController@getStudents')->name('list');


    Route::get('/order','App\Http\Controllers\sellerController@showorders');

    Route::get('/logout',function(){return view('seller.login');});

});

});





















//user routes

Route::group(['prefix' => 'user', 'as' => 'user.'], function()
{

Route::get('dashboard','App\Http\Controllers\ProductController@recommendedproduct');

Route::get('/categoryoptionforsearch','App\Http\Controllers\ProductController@categoryoptionforsearch');

Route::get('/contactus',function(){return view('User.contactus');});

Route::get('/aboutus',function(){return view('User.aboutus');});

Route::get('/uniquecategory','App\Http\Controllers\ProductController@getuniquesubcategory');

Route::post('/product','App\Http\Controllers\ProductController@showproduct');
Route::get('/product','App\Http\Controllers\ProductController@showproduct');

Route::get('/productdetail/{id}','App\Http\Controllers\ProductController@productdetail');

Route::get('/category','App\Http\Controllers\ProductController@showcat');

Route::post('/getstock', 'App\Http\Controllers\ProductController@getStock');

Route::get('/category/{id}','App\Http\Controllers\ProductController@categorywiseproduct');

});


Route::middleware(['auth','user-role:user'])->group(function()
{

    Route::group(['prefix' => 'user', 'as' => 'user.'], function()
{
    //Login Route

    Route::post('/login','App\Http\Controllers\sellerController@login');

    //Route::get('/product',function(){return view('User.product');});

    //Route::get('/category',function(){return view('User.category');});


    Route::post('/addtowishlist/{id}/{color?}/{size?}','App\Http\Controllers\ProductController@addtowishlist')->name('addtowishlist');


    Route::post('/removewishlistproduct/{id}/{color?}/{size?}','App\Http\Controllers\ProductController@removewishlistproduct')->name('removewishlistproduct');



    Route::post('/addtocart','App\Http\Controllers\ProductController@addtocart');

    Route::get('/wishlistbadge','App\Http\Controllers\ProductController@wishlistbadge')->name('wishlistbadge');

    Route::get('/cart','App\Http\Controllers\ProductController@getproductforcart');

    Route::get('/cartremove/{productId}/{inputColor?}/{inputSize?}', 'App\Http\Controllers\ProductController@removeFromCart')->name('cartremove');

    Route::get('/addtocartbadge','App\Http\Controllers\ProductController@addtocartbadge')->name('cartbadge');

    Route::get('/proceedtocheckout',function(){return view('user.checkout');});

    Route::post('/placed','App\Http\Controllers\ProductController@orderplaced')->name('placed');

    Route::get('/myorders','App\Http\Controllers\ProductController@getmyorders');

    //Route::get('/myreviews',function(){return view('User.myreviews');});

    Route::post('/vieworder','App\Http\Controllers\ProductController@vieworder');
    Route::get('/vieworder','App\Http\Controllers\ProductController@getmyorders');

    Route::post('/docomplaint','App\Http\Controllers\ProductController@complain_on_product')->name('cn');

    Route::get('/cancelorder/{id}/{prodid}','App\Http\Controllers\ProductController@cancelorder');

    Route::post('/rateproduct','App\Http\Controllers\ProductController@rateproduct')->name('rateproduct');

    Route::get('/myreviews','App\Http\Controllers\ProductController@myreviews');



    Route::get('/myaccount',function(){return view('User.myaccount');});

    Route::post('/editmyaccount','App\Http\Controllers\ProductController@editmyaccount');
    Route::get('/editmyaccount',function(){return view('User.myaccount');});

    Route::post('/changepassword','App\Http\Controllers\ProductController@changepassword');
    Route::get('/changepassword',function(){return view('User.myaccount');});

    Route::get('/wishlist','App\Http\Controllers\ProductController@wishlisteditems');

    Route::get('/logout','App\Http\Controllers\ProductController@showproduct');

});

});







