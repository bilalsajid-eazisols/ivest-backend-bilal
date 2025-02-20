<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\blogcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogcategoryController extends Controller
{
    //
    public function index(){
        $blogcategories = blogcategory::all();
        return view('admin.blogs.category',compact('blogcategories'));
        // return response()->json($blogcategories);
    }
    public function create(Request $request){
        // return response()->json("test",200);
        if($request->user()){
            $user = $request->user();}else{
                $user = Auth::user();
            }

        $request->validate(['name'=>'required|string|min:3|max:65']);
        $blogcategory = new blogcategory();
        $name =str_replace(' ','_',$request->name);
        $blogcategory->name=$name;
        $blogcategory->name=$request->name;
        $blogcategory->is_active=$request->is_active?? 0;
        $blogcategory->created_by=$user->id;
        try {
            $blogcategory->save();
            return response()->json('Category Created',200);
        }
         catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'Something went Wrong',
                'error'=>$th,
            ],400);

        }
        // $display
    }
    public function update(Request $request,$id){
        // $user = $request->user();
        if($request->user()){
            $user = $request->user();}else{
                $user = Auth::user();
            }
        $request->validate(['name'=>'required|string|min:3|max:65']);
        $blogcategory =  blogcategory::find($id);
        $name =str_replace(' ','_',$request->name);
        $blogcategory->name=$name;
        $blogcategory->name=$request->name;
        $blogcategory->is_active=$request->is_active?? 0;
        $blogcategory->updated_by=$user->id;
        try {
            $blogcategory->save();
            return response()->json('Category Updated',200);
        }
         catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'Something went Wrong',
                'error'=>$th,
            ],400);

        }
        // $display
    }
    public function destroy($id){
        $blogcatgories = blogcategory::find($id);
        if ($blogcatgories) {
            if(blog::where('blogcategory_id',$id)->exists() ){
                return response()->json('Blog Category contains blogs. Move the blogs to another category or delete them first.',400);
            }
            else{
                $blogcatgories->delete();
                return response()->json('Blog Category deleted successfully.', 200);

            }
        }
        else{
            return response()->json('Blog Category not found.', 404);
        }
    }
}
