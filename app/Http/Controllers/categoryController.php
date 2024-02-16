<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\subcategory;

class categoryController extends Controller
{


    //--------------Function to Store Category
    public function putdataincattable(Request $request)
    {
       $categoryname= $request->input('catname');
       $categorydesc= $request->input('catdesc');
       $catnamedb=DB::table('category')->where('Name',$categoryname)->value('Name');
   if($categoryname==""){
    return Redirect::back()->withErrors($categoryname.' Please Enter Category name and Description');

   }
       elseif($catnamedb==$categoryname)
       {

        return Redirect::back()->withErrors($categoryname.' category already exit please enter another one.');

       }
       else{
        DB::table('category')->insertGetId(['Name' => $categoryname, 'Description' => $categorydesc]);

        $categorydata = DB::table('category AS c1')
        ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
        ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
        ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
        ->get();

        Return view('admin.categorylist',['categorydata'=>$categorydata]);
       }

    }






    //--------------------Function to get Category data from Category table
    public function getdatafromtable(Request $request){
        $search=trim($request->input('search'),'["]');

        //Session::put('search', $search);
        if($request->input('search')==""){
            // $categorydata = DB::table('category AS c1')
            // ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
            // ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
            // ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
            // ->get();

            $categorydata = Category::select('id', 'name', 'description')
            ->has('subcategory')
            ->withCount('subcategory as subcategory_count')
            ->having('subcategory_count', '>', 0)
            ->get();

            dd($categorydata);


            // $categorydata= Category::select('category.id', 'category.name', 'category.description', DB::raw('COUNT(subcategory.id) AS subcategory_count'))
            // ->leftJoin('subcategory', 'category.id', '=', 'subcategory.category_id')
            // ->groupBy('category.id', 'category.name', 'category.description')
            // ->get();
        Return view('admin.categorylist',['categorydata'=>$categorydata]);
        }
        else{
            $categorydata = DB::table('category AS c1')
            ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
            ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
            ->where('c1.Name', 'LIKE', '%'.$search.'%')
            ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
            ->get();

        Return view('admin.categorylist',['categorydata'=>$categorydata]);
        }


    }







    //------------------function to delete Category Data from Category Table
    public function deletecat(Request $request){
        $cid=$request->input('catidp');
        $status=DB::table('subcategory')->where('Category_Id',$cid)->count();
        if($status==0){
            DB::table('category')->where('id',$cid)->delete();
            DB::table('subcategory')->where('Category_Id',$cid)->delete();
            $categorydata = DB::table('category AS c1')
            ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
            ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
            ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
            ->get();

            return view('admin.categorylist',['categorydata'=>$categorydata]);
        }
        else{
            //return $status;
           return Redirect::back()->withErrors('Please First Delete Its SubCategory then the main Category will able to delete');

        }

    }






     //------------------function to edit Category Data from Category Table
    public function editcat(Request $request){
        $cid=$request->input('catid');
        $cname=$request->input('catname');
        $cdesc=$request->input('catdesc');

        DB::table('category')->where('ID',$cid)->update(['Name'=>$cname,'Description'=>$cdesc]);
        $categorydata = DB::table('category AS c1')
        ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
        ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
        ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
        ->get();

        return view('admin.categorylist',['categorydata'=>$categorydata]);
    }









     //------------------function to add data in subCategory Table
    public function putdatainsubcattable(Request $request)
    {
       $catID=$request->input('cat');
       $categoryname= $request->input('catname');
       $categorydesc= $request->input('catdesc');
       $catnamedb=DB::table('category')->where('Name',$categoryname)->value('Name');
   if($categoryname==""){
    return Redirect::back()->withErrors($categoryname.' Please Enter Category name and Description');

   }
       elseif($catnamedb==$categoryname)
       {

        return Redirect::back()->withErrors($categoryname.' category already exit please enter another one.');

       }
       else{
        DB::table('subcategory')->insertGetId(['Category_Id'=>$catID,'Name' => $categoryname, 'Description' => $categorydesc]);

        $subcategorydata = DB::table('subcategory')
        ->select('subcategory.*', 'category.Name as maincategoryname')
        ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
        ->get();

        $categorydata = DB::table('category AS c1')
        ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
        ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
        ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
        ->get();

          Return view('admin.subcategorylist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata]);
       }

    }








     //------------------function to get data from subCategory Table  as well as for search also
    public function getdatafromsubcategory(Request $request){

        $search=trim($request->input('search'),'["]');
        //Session::put('search', $search);
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
        Return view('admin.subcategorylist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata]);
        }
        else{
            $subcategorydata = DB::table('subcategory')
            ->select('subcategory.*', 'category.Name as maincategoryname')
            ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
            ->where('subcategory.Name', 'LIKE', '%'.$search.'%')
            ->orWhere('category.Name', 'LIKE', '%'.$search.'%')
            ->get();
            $categorydata = DB::table('category AS c1')
           ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
           ->leftJoin('subcategory AS c2', 'c1.id', '=', 'c2.Category_Id')
           ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
           ->get();

          Return view('admin.subcategorylist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata]);
        }




    }








     //------------------function to get sepecific Data from subCategory Table
    public function getdatafromsubcategorylist(Request $request){

        $id=$request->input('id');
        $subcategorydata = DB::table('subcategory')
        ->select('subcategory.*', 'category.Name as maincategoryname')
        ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
        ->where('category.ID', $id)
        ->get();

          $maincategory=DB::table('category')->where('ID',$id)->get();
          $categorydata = DB::table('category as c1')
          ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
          ->leftJoin('subcategory as c2', 'c1.id', '=', 'c2.Category_Id')
          ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
          ->get();

          Return view('admin.subcategoryspecificlist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata,'maincategory'=>$maincategory]);

        }








     //------------------function to Edit Data from SubCategory Table
    public function editsubcat(Request $request){
        $cid=$request->input('catid');
        $cname=$request->input('catname');
        $cdesc=$request->input('catdesc');

        DB::table('subcategory')->where('Id',$cid)->update(['Name'=>$cname,'Description'=>$cdesc]);
          $subcategorydata = DB::table('subcategory')
          ->select('subcategory.*', 'category.Name as maincategoryname')
          ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
          ->get();

         $categorydata = DB::table('category as c1')
         ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
         ->leftJoin('subcategory as c2', 'c1.id', '=', 'c2.Category_Id')
         ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
         ->get();

          Return view('admin.subcategorylist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata]);
    }








    //------------------function to Delete Data from SubCategory Table
    public function deletesubcat(Request $request){
        $cid=$request->input('catidp');
        DB::table('subcategory')->where('Id',$cid)->delete();
        $subcategorydata = DB::table('subcategory')
        ->select('subcategory.*', 'category.Name as maincategoryname')
        ->join('category', 'subcategory.Category_Id', '=', 'category.ID')
        ->get();

        $categorydata = DB::table('category as c1')
        ->select('c1.ID', 'c1.Name', 'c1.Description', DB::raw('COUNT(c2.id) AS subcategory_count'))
        ->leftJoin('subcategory as c2', 'c1.id', '=', 'c2.Category_Id')
        ->groupBy('c1.ID', 'c1.Name', 'c1.Description')
        ->get();

          Return view('admin.subcategorylist',['subcategorydata'=>$subcategorydata,'categorydata'=>$categorydata]);
    }

}
